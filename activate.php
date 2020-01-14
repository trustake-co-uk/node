<?php
session_start();
include('include/node-check.php');

// Check session is live

if ($_SESSION['Session'] != 'Open') {
	$wallet->web_redirect("index.php");
}

//If payments are active, check if invoice paid

if ($payment == '1' && $_SESSION['Plan'] != '0') {

	if (
		$_SESSION['Address'] == '' || empty($_SESSION['Address']) ||
		$_SESSION['OrderID'] == '' || empty($_SESSION['OrderID']) ||
		$_SESSION['Price'] == '' || empty($_SESSION['Price']) ||
		$_SESSION['Expiry'] == '' || empty($_SESSION['Expiry']) ||
		$_SESSION['InvoiceID'] == '' || empty($_SESSION['InvoiceID'])
	) {
		$wallet->web_redirect("index.php");
	}

	$InvoiceID = $_SESSION['InvoiceID'];
	$OrderPaid = $wallet->GetInvoiceStatus($_SESSION['InvoiceID'], $_SESSION['OrderID']);

	if ($OrderPaid == 'FAIL') {
		exit('Payment not successful - please try again');
	}
} else {
	$InvoiceID = 'FREETRIAL';
}

// Whitelist Delegator address //
// Capture delegator address & Log delegator address and expiry date to a file  //

$displaymessage = '';

// Test to see if we have the Delegator address from the form 
if (empty($_POST["DelegatorAddress"])) {
	// If we don't let's post a message
	$displaymessage .= "<p><label style='color:red'>Enter your delegator staking address</label></p>";
} else {
	// If we do set variables
	$DelegatorAddress = $_POST["DelegatorAddress"];
	$ExpiryDate = $_SESSION['Expiry'];
	$Address = $_SESSION['Address'];
	$Price = $_SESSION['Price'];

	// Whitelist the Delegator address
	$result = $wallet->rpc('delegatoradd', '"' . $DelegatorAddress . '"');
	if ($result == false) {
		exit(' Something went wrong checking the node! - please try again in a new tab it could just be a timeout.');
	} else {
		// Log the expiry date to DB
		$db = new SQLite3('/data/coldstake.db');
		if (!$db) {
			die($db->lastErrorMsg());
		}
//		$sql = <<<EOF
//INSERT INTO WHITELIST (DelegatorAddress,ExpiryDate,ColdStakingAddress,InvoiceID,Price,Whitelisted) 
//VALUES ('$DelegatorAddress', '$ExpiryDate', '$Address' , '$InvoiceID', $Price, 1 );
//EOF;
//		$result = $db->exec($sql);

		$sql = $db->prepare('INSERT INTO WHITELIST (DelegatorAddress,ExpiryDate,ColdStakingAddress,InvoiceID,Price,Whitelisted) VALUES (:da, :exp, :add , :inv, :pr, :wh );');
		$sql->bindValue(':da', $DelegatorAddress, SQLITE3_TEXT);
		$sql->bindValue(':exp', $ExpiryDate, SQLITE3_TEXT);
		$sql->bindValue(':add', $Address, SQLITE3_TEXT);
		$sql->bindValue(':inv', $InvoiceID, SQLITE3_TEXT);
		$sql->bindValue(':pr', $Price, SQLITE3_FLOAT);
		$sql->bindValue(':wh', 1, SQLITE3_INTEGER);
		$dbselect = $sql->execute();
	
		$db->close();

		// Update message to confirm whitelist done & reset variables
		$displaymessage = '<label class="text-success">Your address has been whitelisted</label>';
	}
}
?>
<?php include('include/header.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Main -->
<article id="main">
	<header>
		<img src="images/coin_logo-<?php print $ticker; ?>.png" alt="" width="200" />
	</header>
	<section class="wrapper style5">
		<div class="inner">
			<?php if ($payment == '1' && $_SESSION['Plan'] != '0') { ?>
				<h3>ORDER #<?php print $_SESSION['OrderID']; ?></h3>
				<p>Thank you for your payment!</p><br>
			<?php } else { ?>
				<h3>Thank you for using coldstake.co.in</h3>
			<?php }; ?>
			<p>Before you can delegate your staking to Coldstake.co.in, you will need to enter your owner address from your local wallet. This will enable the Coldstake.co.in platform to whitelist the address.</p>
			<?php if (empty($_POST["DelegatorAddress"])) { ?>
				<form method="post" action="activate.php">
					<div class="row gtr-uniform">
						<div>
							<b style='color:red'>Enter your owner address:</b>
							<input type="text" name="DelegatorAddress" id="DelegatorAddress" />
						</div>
						<div">
							<ul class="actions">
								<li><input type="submit" value="Whitelist Now!" class="primary" /></li>
							</ul>
				</form>
			<?php } else { ?>
				<p>Here is your personal cold staking address:
				<pre><code><?php print $_SESSION['Address']; ?></code></pre>
			</p>
				<pre><code><?php print $_POST['DelegatorAddress'] . " has been whitelisted until: " . $ExpiryDate; ?></code></pre>
			<?php } ?>

		</div>
	</section>
</article>
<?php include('include/footer.php'); ?>