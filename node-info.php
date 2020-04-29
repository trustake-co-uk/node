<?php
require('/var/secure/keys.php');
require('include/config.php');
require('include/functions.php');
$functions = new phpFunctions_Wallet();
$bal = 0;

//Check if node is online before further checks
$check_server = $functions->rpc('getinfo', '');

if ($check_server != '' || !empty($check_server)) {

	$getinfo = $functions->rpc('getinfo', '');
	$getblockchaininfo = $functions->rpc('getblockchaininfo', '');
	$getstakinginfo = $functions->rpc('getstakingstatus', '');
	$getpeerinfo = $functions->rpc('getpeerinfo', '');
	$getnetworkinfo = $functions->rpc('getnetworkinfo', '');
	$getrawmempool = $functions->rpc('getrawmempool', '');

	echo '<pre>' . json_encode($getinfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getstakinginfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getnetworkinfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getblockchaininfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getrawmempool, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getpeerinfo, JSON_PRETTY_PRINT) . '</pre>';
} else {

	die('<pre> Unable to connect to the node </pre>');
}
?>