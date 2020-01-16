<?php
require('/var/secure/keys.php');
require('include/config.php');
require('include/functions.php');
$wallet = new phpFunctions_Wallet();

// TODO: Review if balance is required

//Grab staking status from daemon
$get_stakinginfo = $wallet->rpc('getstakingstatus');

if (is_array($get_stakinginfo)) {
	// Node online
	$enabled = <<<EOD
<a href="index.html" class="icon fa-circle" style="color:green">COLDSTAKE.CO.IN</a>
EOD;
	$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:green'>Node online</a></li>
EOD;


	// 	// Check staking status and set messages 		
	// 	if ($get_stakinginfo['staking status'] == 1) {
	// 		// Staking online
	// 		$message = <<<EOD
	// <li><a href=""class="icon fa-circle" style='color:green'>Staking online</a></li>
	// EOD;
	// 	} else {
	// 		// Staking offline
	// 		$message = <<<EOD
	// <li><a href=""class="icon fa-circle" style='color:red'>Staking offline</a></li>
	// EOD;
	// 	}

} else {
	$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Node offline</a></li>
EOD;
}
