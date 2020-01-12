<?php 
include('include/node-check.php');
include('include/header.php');
include('include/menu.php'); 
?>
<!-- Main -->
<article id="main">
	<header>
		<h2>Cold Staking<br />Frequently asked questions</h2>
	</header>
	<section class="wrapper style5">
		<div class="inner">
			<?php if ($payment != '1') { ?>
			<h3>What are the fees?</h3>
				<p>This service is being provided <b>free of charge</b> as we have decided to trial a donation/tips based business model. We will rely on these tips and donations as long as possible, giving everyone the opportunity to use cold staking. Hopefully, people will appreciate the service and donate on a regular basis so that we can keep the service running. We have opened a crowdfunding page <a href="https://donations.coldstake.co.in/">here</a> if you want to help.<p> 
			<?php }; ?>
			<h3>What is staking?</h3>
				<p>Staking is essential to the Proof of Stake consensus mechanism used on the various blockchain networks.</p>
			<p>Blocks are verified and mined by network participants who are willing to set aside a portion of their coins, effectively freezing them so they cannot be spent. In return, these participants are granted the right to verify transactions and earn bonuses paid in coins.</p>
				<p>The larger the number of coins a participant is willing to stake, the greater the chance that they will be chosen to mine the next block and earn the associated bonus.  While coins are being staked, they are frozen in a wallet.</p>
			<h3>Hot vs Cold Wallet</h3>
				<p>If the wallet is connected to the blockchain network it is referred to as a hot wallet and such an arrangement incurs some risk since the wallet is effectively online and therefore susceptible to attack. Conversely, if the wallet stores coins off-line (as is possible in a desktop wallet, or a hardware wallet, or even a paper wallet), it is known as a cold wallet.</p>
			<h3>What is cold staking?</h3>
				<p>Using a cold wallet for the staking process is referred to as “Cold Staking”. Cold Staking is inherently safer than staking in an online hot wallet since coins are not susceptible to online attack while they are held in an off-line wallet.</p>
			<h3>Why should I lock up my coins for staking?</h3>
				<p>Staking (using a hot wallet, or a cold wallet) enables coin holders to earn rewards in return for freezing their staked coins so they cannot be otherwise used while they are being staked. Cold Staking has the additional benefit that staked coins are frozen, off-line, where they are not susceptible to being stolen via an on-line attack.  To produce blocks on the network, a miner has to be on-line with a node running and have their wallet open. The chances of earning a reward for staking increases linearly with the number of coins staked, which means the most successful miners are likely to have large numbers of coins frozen in their wallets.</p>
			<h3>The risk of hot staking</h3>
				<p>Holding your coins in a hot wallet represents a risk if the node is compromised. For this reason, Cold Staking was developed where the miner still needs to be on-line with a full node running and their hot wallet open, but the coins used for staking can be safely stored off-line in “cold storage”. Their hot wallet need not hold any significant number of coins, or may be completely empty.  Cold staking is implemented on the full node, with a 24/7 connection to the internet and the rest of the network. In addition, a Cold Staking user needs to have an off-line cold wallet in which to store the staked coins.</p>
			<h3>What is "Full Node as a Service"?</h3>
				<p>Full Node as a Service (FNaaS) is a node running in the cloud that is setup, operated, maintained, secured and monitoring by a third party. </p>
			<h3>What service does coldstake.co.in provide?</h3>
				<p>coldstake.co.in operates a "Full Node as a Service" pool providing users with a secure coldstaking wallet on their chosen network. By utilising Coldstake.co.in FNaaS technology a user can setup and run Cold Staking very quickly, safe in the knowledge that their coins never leave their cold storage wallet.</p>
			<h3>What coins does coldstake.co.in support</h3>
				<p>coldstake.co.in currently supports Blockcore, Stratis and any chain built using the same technology. As new coins come online they will be added to the coldstake.co.in portfolio.</p>
			<hr />
			<h3>Disclaimer<h3></h3>
				<p>Please be aware that coldstake.co.in never handles your coins and will never ask for your private keys or seed phrase.</p>
		</div>
	</section>
</article>
<?php include('include/footer.php'); ?>