<?php

class phpFunctions_Wallet
{

    public function crypto_rand($min, $max, $pedantic = True)
    {
        $diff = $max - $min;
        if ($diff <= 0) return $min; // not so random...
        $range = $diff + 1; // because $max is inclusive
        $bits = ceil(log(($range), 2));
        $bytes = ceil($bits / 8.0);
        $bits_max = 1 << $bits;
        $num = 0;
        do {
            $num = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes))) % $bits_max;
            if ($num >= $range) {
                if ($pedantic) continue; // start over instead of accepting bias
                // else
                $num = $num % $range;  // to hell with security
            }
            break;
        } while (True);  // because goto attracts velociraptors
        return $num + $min;
    }

    public function rpc($command, $params = null)
    {
        require('/var/secure/keys.php');
        require('include/config.php');
        $rpcpass=$WalletPassword;
        $rpcuser=$WalletName;
        $url = $scheme . '://' . $server_ip . ':' . $api_port . '/';
        $request = '{"jsonrpc": "1.0", "$rpcuser":"$rpcpass", "method": "' . $command . '", "params": [' . $params . '] }';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$rpcuser:$rpcpass");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "accept: application/json",
            "content-type: application/json-patch+json",
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        
        $response = curl_exec($ch);
        $response = json_decode($response, true);

        if (isset($response)) {
            $result=$response['result'];
            $error=$response['error'];
        } else {
            $result='';
            $error='';
        } 

        if ( isset($error) ) {
            return $error;
        } else {
            return $result;
        }
        curl_close($ch);
    }

    public function CallAPI($url, $request_type)
    {

        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $options = array(
            CURLOPT_RETURNTRANSFER => true,       // return web page
            CURLOPT_HEADER         => false,      // do not return headers
            CURLOPT_FOLLOWLOCATION => true,       // follow redirects
            CURLOPT_USERAGENT      => $useragent, // who am i
            CURLOPT_AUTOREFERER    => true,       // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 2,          // timeout on connect (in seconds)
            CURLOPT_TIMEOUT        => 2,          // timeout on response (in seconds)
            CURLOPT_MAXREDIRS      => 10,         // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false,      // SSL verification not required
            CURLOPT_SSL_VERIFYHOST => false,      // SSL verification not required
            CURLOPT_CUSTOMREQUEST => $request_type,
            CURLOPT_HTTPHEADER => array(
                // here Set your security here requred headers
                "accept: application/json",
                "content-type: application/json-patch+json",
            ),
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch); // Execute
        $response = json_decode($response, true);
        $error = curl_errno($ch);
        $result = $response;
        curl_close($ch);
        return $result;
    }

    public function CallAPIParams($url, $request_type, $params)
    {

        $payload = json_encode($params);
        if ($request_type == 'POST') {
            $post = true;
        } else {
            $post = false;
        }

        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,            //to track the handle's request string. 
            CURLOPT_POSTFIELDS => $payload,         // holds the json payload
            CURLOPT_POST => $post,                  // POST
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload)
            ),
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);                     // Execute
        $response = json_decode($response, true);
        $error = curl_errno($ch);
        $result = $response;
        curl_close($ch);
        return $result;
    }

    public function GetInvoiceStatus($invoiceId, $orderID)
    {
        require('/var/secure/keys.php'); //secured location - sensitive keys
        require('include/config.php'); // coin configuration
        require('vendor/autoload.php'); //loads the btcpayserver library

        $storageEngine = new \BTCPayServer\Storage\EncryptedFilesystemStorage($encryt_pass);
        $privateKey    = $storageEngine->load('/var/secure/btcpayserver.pri');
        $publicKey     = $storageEngine->load('/var/secure/btcpayserver.pub');
        $client        = new \BTCPayServer\Client\Client();
        $adapter       = new \BTCPayServer\Client\Adapter\CurlAdapter();

        $client->setPrivateKey($privateKey);
        $client->setPublicKey($publicKey);
        $client->setUri($btcpayserver);
        $client->setAdapter($adapter);

        $token = new \BTCPayServer\Token();
        $token->setToken($pair_token);
        $token->setFacade('merchant');
        $client->setToken($token);

        $invoice = $client->getInvoice($invoiceId);

        $OrderIDCheck = $invoice->getOrderId();
        $OrderStatus = $invoice->getStatus();
        $ExcStatus = $invoice->getExceptionStatus();

        if (($OrderStatus == 'complete' || $OrderStatus == 'paid') && $OrderIDCheck == $orderID) {
            $result = "PASS";
        } else { //TODO: Handle partial payments
            $result = "FAIL";
        }
        return $result;
    }

    public function CreateInvoice($OrderID, $Price, $Description, $redirectURL, $ipnURL)
    {
        require('/var/secure/keys.php'); //secured location - sensitive keys
        require('include/config.php'); // coin configuration
        require('vendor/autoload.php'); //loads the btcpayserver library

        $storageEngine = new \BTCPayServer\Storage\EncryptedFilesystemStorage($encryt_pass);
        $privateKey    = $storageEngine->load('/var/secure/btcpayserver.pri');
        $publicKey     = $storageEngine->load('/var/secure/btcpayserver.pub');
        $client        = new \BTCPayServer\Client\Client();
        $adapter       = new \BTCPayServer\Client\Adapter\CurlAdapter();

        $client->setPrivateKey($privateKey);
        $client->setPublicKey($publicKey);
        $client->setUri($btcpayserver);
        $client->setAdapter($adapter);

        $token = new \BTCPayServer\Token();
        $token->setToken($pair_token);
        //$token->setFacade('merchant');
        $client->setToken($token);

        // * This is where we will start to create an Invoice object, make sure to check
        // * the InvoiceInterface for methods that you can use.
        $invoice = new \BTCPayServer\Invoice();
        $buyer = new \BTCPayServer\Buyer();
        //$buyer->setEmail($email);

        // Add the buyers info to invoice
        $invoice->setBuyer($buyer);

        // Item is used to keep track of a few things
        $item = new \BTCPayServer\Item();
        $item
            //->setCode('skuNumber')
            ->setDescription($Description)
            ->setPrice($Price);
        $invoice->setItem($item);

        // Setting this to one of the supported currencies will create an invoice using
        // the exchange rate for that currency.
        $invoice
            ->setCurrency(new \BTCPayServer\Currency('USD'));

        // Configure the rest of the invoice
        $invoice
            ->setNotificationUrl($ipnURL)
            ->setOrderId($OrderID)
            ->setRedirectURL($redirectURL);

        // Updates invoice with new information such as the invoice id and the URL where
        // a customer can view the invoice.
        try {
            echo "Creating invoice at coldstake.co.in now." . PHP_EOL;
            $client->createInvoice($invoice);
        } catch (\Exception $e) {
            echo "Exception occured: " . $e->getMessage() . PHP_EOL;
            $request  = $client->getRequest();
            $response = $client->getResponse();
            echo (string) $request . PHP_EOL . PHP_EOL . PHP_EOL;
            echo (string) $response . PHP_EOL . PHP_EOL;
            exit(1); // We do not want to continue if something went wrong
        }

        return array('invoice_id' => $invoice->getId(), 'invoice_url' => $invoice->getUrl());
    }

    public function web_redirect($url, $permanent = false)
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: ' . $url);
        exit();
    }
}
