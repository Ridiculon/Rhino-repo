
<div id="header">
<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
<div style="position: absolute; left:65%; top: 10%">
	<a href="logout.php"><img src="images/Logout_button.png" style="border:none"></a>
</div>
<div id="header-content">	
		<!-- Menu Tabs -->
		<ul style="position: absolute; top: 10px; left: 20px;">
			<?php
			echo '<li><a href="./profile.php?id='.htmlspecialchars(stripslashes($_SESSION['valid_user'])).'">Main</a></li>';
			echo '<li><a href="./account.php">Account</a></li>'; ?>
			<li><a href="./contests.php">Contests</a></li>
			<li><a href="./profiles.php">Profiles</a></li>
			<li><a href="">Forum</a></li>
			<li><a href="./about.php">About</a></li>			
		</ul>

		<!-- Search Field -->
		<div class="searchform">
			<form action="contestsearch.php" method=get>
				<div class="searchboxdiv" style="position: absolute; right: 40px;">
					<input class="searchbox" type="text" name="Search" value="Search"/>
				</div>
				<input type="image" src="images/Search_unpressed.png" style="position:absolute; right:0px; top: 0px;"/>
			</form>
		</div>
</div>
</div>

