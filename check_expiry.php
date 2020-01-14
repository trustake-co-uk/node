<?php
session_start();
include('include/node-check.php');

class MyDB extends SQLite3 {
	function __construct() {
	   $this->open('/data/coldstake.db');
	}
 }

if (isset($_POST['address'])) {
	// Open DB
	//	$db = new SQLite3('/data/coldstake.db');
	$db = new MyDB();
	if(!$db){ die ($db->lastErrorMsg()); }
	$address = $_POST['address'];

	//Search for the owner address.
	$sql = <<<EOF
	SELECT * from WHITELIST where DelegatorAddress = '$address';
	EOF;

	$dbselect = $db->query($sql);
	while ($row = $dbselect->fetchArray(SQLITE3_ASSOC) ) {
		$expires = $row['ExpiryDate'];
		if ( $row['Whitelisted'] = 1 ) {$whiteliststatus = "Enabled"; } else {$whiteliststatus = "Expired";};
	}
	$db->close();
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
			<section>
				<h3>Check My Expiry Date</h3>
		</div>
		<?php if ((isset($_POST['address'])) && isset($expires)) { ?>
			<div class="table-wrapper">
				<table>
					<thead>
						<tr>
							<th>Address</th>
							<th>Expiry Date</th>
							<th>Whitelisted</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $address; ?></td>
							<td><?php echo $expires; ?></td>
							<td><?php echo $whiteliststatus; ?></td>
						</tr>
					</tbody>
					<tfoot>
					</tfoot>
				</table>
			<?php } ?> <br />
			<form method="post" action="">
				<div class="col-24">
					<input type="text" name="address" id="address" value="" placeholder="address" />
				</div>
				<br />
				<div class="col-12">
					<ul class="actions">
						<li><input type="submit" value="Search" class="primary" /></li>
						<li><input type="reset" value="Reset" /></li>
					</ul>
				</div>
			</form>
	</section>
	</section>
</article>
<?php include('include/footer.php'); ?>