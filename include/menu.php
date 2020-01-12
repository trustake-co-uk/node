<!-- Header -->
<header id="header" class="alt">
	<h1><?php if (isset($enabled)) { print $enabled;};?></h1>
   		<nav id="nav">
	        <ul>
		        <li class="special">
			    <a href="#menu" class="menuToggle"><span>Menu</span></a>
			    <div id="menu">
			        <ul>
			            <?php if (isset($message)) { print $message;}?>
			            <li><a href="index.php">Home</a></li>
						<li><a href="about.php">FAQ</a></li>
						<li><a href="https://donations.coldstake.co.in/" target="_blank">Donations</a></li>
					</ul>
					<ul>
						<li><a href="" style='color:green'> HOW-TO GUIDES</a></li>
						<li><a href="how-to.php" target="_blank">Staking Guide</a></li>
						<li><a href="check_expiry.php">Check my expiry date</a></li>
					</ul>
			    </div>
			</li>
	        </ul>
    	</nav>
</header>