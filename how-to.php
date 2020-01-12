<?php
include('include/node-check.php');
include('include/header.php');
include('include/menu.php');
?>
<!-- Main -->
<article id="main">
    <header>
        <h2>Cold Staking<br />How-to Guides</h2>
    </header>

    <section class="wrapper style1 special">
        <div class="inner">
            <h2>What is cold staking?</h2>
            <p>Staking coins strengthens the network and you get rewarded for finding blocks. Cold staking is a safer way to stake your coins.<br><br>
                Cold Staking allows you to safely store your coins in your wallet while a separate always online cold staking server stakes the coins, meaning you don't have to keep your wallet open for staking.<br><br>
                The cold staking server has no access to your coins and you can withdraw coins to a spending address at any time.</p>
        </div>
    </section>
    <section id="coldstake" class="wrapper style2">
        <div class="inner">
            <h2>Start Cold Staking at Coldstake.co.in</h2>
            If you don't feel like setting up and maintaining your own cold staking server on a VPS or a dedicated server, then coldstake.co.in is the service for you!
            <br><br>
            All users who want to start staking their coins, strengthen the network and get rewards can follow the instructions below.
            <br><br>
            <h5>Requirements</h5>
            <ul>
                <li>Core wallet synced up to 100%.</li>
                <li>Coins in your main wallet account</li>
            </ul>
            <h5>Instructions</h5>
            <h5>1. Generate a "owner address" from the owner wallet</h5>
            <ul>
                <li> Generate a "owner address" from the owner wallet. Owner addresses are regular addresses. Their private key can be used to redeem delegated coins. </li><br>
                <li>Creating an owner address is the same as creating a receiving address. They must belong to the <b>owners</b> wallet (the one that is offline and has the ownership of the coins). The owner wallet can also be a hardware wallet device or a paper wallet.</li>
                    <br><i>CLI</i>
                    <br><br><li>To get a new owner address, from the owner wallet do:</li>
                    <br><pre>pivx-cli getnewaddress</pre>
                    <i>GUI</i>
                    <br><br><li>To get a new owner address, simply go to the "Receive" tab and click "Generate address"</li><br>
                    <img src="images/cold-stake//02-01.png" width="670">
                    <br>Please note: You don't need to create a new owner address for each delegation. You can reuse your previously generated addresses.<br>
            </ul>
            <h5>2) Whitelist your "owner" address and generate a "staking address" on Coldstake.co.in</h5>
            <ul>    
                <?php if ($payment == '1') { ?>
                    <li>Go to <a href="https://<?php echo $ticker; ?>.coldstake.co.in"><?php echo $ticker; ?>.coldstake.co.in</a>, choose your plan (and make your payment) or a free trial.</li><br>
                    <img src="images/cold-stake/choose-plan.png">
                <?php } else { ?>
                    <li>Go to <a href="https://<?php echo $ticker; ?>.coldstake.co.in/"><?php echo $ticker; ?>.coldstake.co.in</a>, click Cold Stake Now.</li><br>
                    <img src="images/cold-stake/trustaking-1.png">
                <?php }; ?>

                <li>In order to delegate staking, your owner address must be whitelisted at <a href="https://<?php echo $ticker; ?>.coldstake.co.in/"><?php echo $ticker; ?>.coldstake.co.in</a>. This is a simple case of entering the owner address on the website and clicking WHITELIST NOW!</li>
                <br><img src="images/cold-stake/04-01.png" width="670"><br><br>
                <li>Next, your personal coldstaking address will be automatically generated by the Coldstake.co.in platform.</li>
                <br><img src="images/cold-stake/01-03.png" width="670"><br>
                Please note: You don't need to create a new staking address for each delegation. You can reuse your previously generated addresses, as long as it hasn't expired.<br>
            </ul>
                <h5>3) Create a "cold stake delegation"</h5>
            <ul>
                <li>This is the critical step to enable coldstaking. To delegate coins you need to send a special "delegation contract" transaction.</li>
                <br><i>CLI</i>
                <br><br><li>Specify the personal coldstaking address (from <a href="https://<?php echo $ticker; ?>.coldstake.co.in/"><?php echo $ticker; ?>.coldstake.co.in</a>), the amount to delegate and the owner address:</li>
                <br><pre>pivx-cli delegatestake "S1t2a3kab9c8c71VA78xxxy4MxZg6vgeS6" 1000 "DMJRSsuU9zfyrvxVaAEFQqK4MxZg34fk"</pre>
                Please note: If you want to delegate from an <b>external address</b> (using an owner address not present in the wallet, e.g. one from a hardware device), then you need to add `true` at the end of the command (check `pivx-cli help delegatestake` for more info).
                <br><br><i>GUI</i>
                <br><br><li>From the coldstaking widget, click "delegation". (as with the regular sending operation, you must select an amount and either let the wallet pick the coins, or select them with coin control)</li>
                <br><li>Insert the personal coldstaking address (from Coldstake.co.in or select it from the list of previously used ones), a description, and your owner address. Then click "Delegate".</li>
                <br><img src="images/cold-stake/03-01.png" width="670"><br>
            </ul>
        </div>
    </section>
</article>
<?php include('include/footer.php'); ?>