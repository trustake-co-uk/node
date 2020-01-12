<?php 
// Coin specific variables will get injected
$ticker='pivx';
$api_port='51473'; 

// Service specific variables will get injected
$redirectURL='';
$ipnURL='';
$email='';

// general variables
$server_ip='localhost'; // '0.0.0.0' target server ip. [ex.] 10.0.0.15
$scheme='http' ;// tcp protocol to access json on coin. [default]
$AccountName='coldStakingHotAddresses' ; // special account for cold staking addresses
$api_ver=''; // additional parameters for api call (deprecated for pivx forks) 
$coldstakeui=''; // switch off the scripts (deprecated for pivx forks) 
$whitelist=''; //is whitelisting enabled (deprecated for pivx forks) 
$payment='1'; // is payment enabled
?>