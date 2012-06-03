<?php
	session_start();
?>
<html>
<head>
<title>Rhino Launch</title>
</head>



<div class="wrapper">
<?php
	include('header.php');
?>

<!--[if !IE 7]>
	<style type="text/css">
		#wrap {display:table;height:100%}
	</style>
<![endif]-->

<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT">
	var min = 13;
	var max = 25;
	var width = 13;
	var b = 0;
	
	function expand(){
		if(b != 2){
			b = 1;
			exp = document.getElementById("sidebar").style.width=width+'%';
			if(width < max)
			{	
				width = width + 1;
				setTimeout('expand()', 10);
			} else {
				b = 0;
			}
		}
	}
	
	function reset(){
		if(b != 1){
			b = 2;
			exp = document.getElementById("sidebar").style.width=width+'%';
			if(width > min)
			{
				width = width - 1;
				setTimeout('reset()', 10);
			} else {
				b = 0;
			}
		}
	}
</SCRIPT>

	
	<div id="content">
	<div id="sidebar" onmouseover="expand()" onmouseout="reset()">
		
			'I'm sure those are not the right words,' said poor Alice, and her eyes filled with tears again as she went on,
			'I must be Mabel after all, and I shall have to go and live in that poky little house, and have next to no toys to play with,
			and oh! ever so many lessons to learn! No, I've made up my mind about it; if I'm Mabel, I'll stay down here! It'll be no use
			their putting their heads down and saying "Come up again, dear!" I shall only look up and say "Who am I then? Tell me that first, 
			and then, if I like being that person, I'll come up: if not, I'll stay down here till I'm somebody else"—but, oh dear!' cried Alice,
			with a sudden burst of tears, 'I do wish they WOULD put their heads down! I am so VERY tired of being all alone here!'
		
	</div>

	
	<div id="splash">
		<div style="width:45%; position: absolute; left:0%; top: 10%">
			<?php
				include('login.php');
			?>
		</div>
		
		<div style="width:45%; position: absolute; left:50%">
			</br>
			<h3 style="color:#FFFFFF"> What is this about? </h3>
			</br>
			<p> RhinoLaunch takes the untapped potential of viral-video making and the necessity for cheap effective advertising and combines them into a competitive online community
			for amateur filmmakers to show off their talent by creating incentive for quality content. 
			This content can then be used by local businesses to promote their businesses in ways that were not possible before now. </p>
			
		</div>
	</div>
	<div style="position: absolute; top:140px; left:80%">
				<img src="images/Sitting_Rhino2.jpg" alt="sitting rhino" class="no-border"/>
	</div>
	
	<div style="width: 75%; position: absolute; left: 15%; top: 500px; padding-bottom:30px">
		<h3></h3>
		<p style="text-align:left; padding-right:5%; padding-left:5%">
			
		</p></br>
		
		<h3>Recent Contests</h3>
		
		<?php
			@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
				
				if(!$db)
				{
					echo '<p style="text-align:center">Error: could not connect to the database.</p>';
				}
				else
				{
					mysql_select_db('rhino_launch');
					
					$query = "select Description, Title, duedate, Contest_ID, Points from contest2 order by duedate desc";
					$result = mysql_query($query);
					$num_results = mysql_num_rows($result);
					
					
					
					if($num_results > 0)
					{
						if($num_results > 3)
							$num_results = 3;
							
						echo '<table width="100%" border="1" bordercolor="#A0080D">';
						echo '<tr>';
						echo '<th width="100px">Contest</th>';
						echo '<th>Due Date</th>';
						echo '<th>Title</th>';
						echo '<th>Description</th>';
						echo '<th>Points</th>';
						echo '</tr>';
						
						for($i=0; $i < $num_results; $i++)
						{
							$row = mysql_fetch_array($result);
							echo '<tr>';
							//thumb img
							echo '<td><img src="images/thumb'.$row['Contest_ID'].'.jpg" class="no-border"></td>';
							echo '<td width="100px">';
							echo htmlspecialchars(stripslashes($row['duedate']));
							echo '</td>';
							echo '<td style="text-align:center"><strong><a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_ID'])).'">';
							echo htmlspecialchars(stripslashes($row['Title'])).'</a></strong></td>';
							echo '<td>';
							echo substr(htmlspecialchars(stripslashes($row['Description'])), 0, 200)."...</td>";
							echo '<td style="text-align:center">';
							echo $row['Points'];
							echo '</td>';
							echo '</tr>';
						}
						
						echo '</table>';
					}
					else
						echo '<p style="text-align:center">No contests at this time.</p></br>';
				}
			
		?>
		
	</div>
	
	<div class="push"></div>
	
	</div>
	</div>



<?php
	include('footer.php');
?>

</body>
</html>