<?php // Pongalator 4000, Index

  $by = "Jeff Moreland";
  $contact = "jeff@evose.com";
  $on = "24 Sep 2014";
  $updated = "03 Oct 2014";
  $version = "0.3";

/* Change Log
0.3	Added deuce feature to input winner score, otherwise winner defaults to score of 11
	Now shows total points, points per game, and point total differential (need to make function for this)	
*/

// Load DB
  require("mysql.php");
  $now = date("Y-m-d H:i:s");

  if(isset($_REQUEST['start_match'])) {

/*
Column 	Type 	Null 	Default 	Comments
id 		int(11) 	No  	  	 
winner 	int(11) 	No  	  	 
loser 	int(11) 	No  	  	 
winner_steps int(11) 	Yes  	NULL  	 
loser_steps int(11) 	Yes  	NULL  	 
start_time 	timestamp 	No  	CURRENT_TIMESTAMP  	 
end_time 	timestamp 	Yes  	0000-00-00 00:00:00 
*/
    $sql = "INSERT INTO matches VALUES (NULL,NULL,NULL,NULL,NULL,NULL,NULL)";
    $null_sql = str_replace("''","NULL",$sql);
    //echo "$null_sql <br />";
    mysqli_query($db, $null_sql) or die(mysql_error());
    $current_match_id = mysqli_insert_id($db);
  } else {

    $current_match_result = mysqli_query($db,"SELECT * FROM matches WHERE end_time IS NULL");
    if($current_match = mysqli_fetch_array($current_match_result)) {
      extract($current_match,EXTR_PREFIX_ALL,"current_match");
      //echo $current_match_id;
    } else {
       echo "No current match";
    }
  }
  
  if(isset($_REQUEST['end_match'])) {
    $match = $_REQUEST['match'];
    $sql = "UPDATE `matches` ".
           "SET end_time = '$now' ".
           "WHERE id = $match";
    //echo $sql;
    mysqli_query($db, $sql) or die(mysql_error());
    unset($current_match_id);
  }

  $last_match_result = mysqli_query($db,"SELECT * FROM matches WHERE end_time IS NOT NULL ORDER BY start_time DESC");
  if($last_match = mysqli_fetch_array($last_match_result)) {
    extract($last_match,EXTR_PREFIX_ALL,"last_match");
    //echo $last_match_id;
  } else {
    echo "No previous match";
  }


/*
Column 	Type 		Null 	Default
id 		int(11) 	No  	  	 
match 	int(11) 	No  	  	 
winner 	int(11) 	No  
winner_scoreint(11) 	Yes  	NULL  	 	  	 
loser 	int(11) 	No  	  	 
loser_score	int(11) 	Yes  	NULL  	 
deuce 	tinyint(1) 	Yes  	NULL  	 
steps 	int(11) 	Yes  	NULL  	 
date 		timestamp 	No  	CURRENT_TIMESTAMP 
*/ 	 
  if(isset($_REQUEST['log'])) {
 
    print_r($_REQUEST);
    extract($_REQUEST);
    if(isset($match)) {
      if($winner=='Jeff') {
        $winner=1;
        $loser=2;
      } elseif($winner=='Tim') {
        $winner=2;
        $loser=1;
      } else {
        break;
      }

      if(isset($deuce)) {
   
      } else {
        $deuce = NULL;
      }
      $sql = "INSERT INTO games VALUES (NULL,'$match','$winner','$winner_score','$loser','$loser_score','$deuce',NULL,NULL)";
      $null_sql = str_replace("''","NULL",$sql);
      //echo "$null_sql <br />";
      mysqli_query($db, $null_sql) or die(mysql_error());
    } else {
      echo "Please start a new match first. Game not logged.";
    }
  } 

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" id="iphone-viewport" content="minimum-scale=1.0, maximum-scale=1.0, width=device-width" />
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<link rel="stylesheet" href="spinningwheel.css" type="text/css" media="all" />
	<script type="text/javascript" src="spinningwheel.js?v=1.4"></script>

	<title>Pongalator 4000</title>


<style type="text/css">
body { text-align:center; font-family:helvetica; }
button { font-size:16px; }
.submit { font-size:16px; }
#result { margin:10px; background:#aaa; -webkit-border-radius:8px; padding:8px; font-size:18px; }
</style>

<script language="javascript" type="text/javascript">
	function showScore () {
		if (document.getElementById('winner_score').style.display == '') {
			document.getElementById('winner_score').style.display = 'none';
			document.getElementById('winner_score_label').style.display = 'none';
		} else {
			document.getElementById('winner_score').style.display = '';
			document.getElementById('winner_score_label').style.display = '';
		}
	}
</script>

</head>
<body>
<P>
Pongulator 4000
<br>
<form method="post">
<table align="center" border="1px">
<tr>
<td><br /></td>
<td>Jeff</td>
<td>Tim</td>
<td>Deuce</td>
<td>Score</td>
</tr>
<tr>
<td>
Select Winner:
</td>
<td>
<input type="Radio" id="winner" name="winner" value="Jeff">
</td>
<td>
<input type="Radio" id="winner" name="winner" value="Tim">
</td>
<td>
<input type="checkbox" id="deuce" name="deuce" value="TRUE" onchange="showScore()">
</td>
<td>
<label id="winner_score_label" for="winner_score" style="display:none;">Winner</label>
<select name="winner_score" id="winner_score" style="display:none;">
  <option>21</option>
  <option>20</option>
  <option>19</option>
  <option>18</option>
  <option>17</option>
  <option>16</option>
  <option>15</option>
  <option>14</option>
  <option>13</option>
  <option>12</option>
  <option selected>11</option>
</select> 
<label for="loser_score">Loser</label>
<select name="loser_score">
  <option>21</option>
  <option>20</option>
  <option>19</option>
  <option>18</option>
  <option>17</option>
  <option>16</option>
  <option>15</option>
  <option>14</option>
  <option>13</option>
  <option>12</option>
  <option>11</option>
  <option>10</option>
  <option selected>9</option>
  <option>8</option>
  <option>7</option>
  <option>6</option>
  <option>5</option>
  <option>4</option>
  <option>3</option>
  <option>2</option>
  <option>1</option>
  <option>0</option>
</select> 
<?php 
  if(isset($current_match_id)) {
    echo "<input type=\"hidden\" name=\"match\" value=\"$current_match_id\" />";
  }
?>
<input type="submit" name="log" value="Log Game">
</td>
</tr>
<tr>
<?php
  if(isset($current_match_id)) {
    echo "<tr><td><input type=\"submit\" name=\"end_match\" value=\"End Current Match\" /></td>";

    echo "<td>";
    $result = mysqli_query($db,"SELECT * FROM games WHERE `match` = $current_match_id AND winner = 1");
    $p1_games_won = mysqli_num_rows($result);
    echo $p1_games_won." wins";

    $result = mysqli_query($db,"SELECT * FROM games WHERE `match` = $current_match_id AND loser = 1");
    $p1_games_lost = mysqli_num_rows($result);
    //echo $p1_games_lost;
    $p1_total_games = $p1_games_won+$p1_games_lost;

    $result = mysqli_query($db,"SELECT SUM(winner_score) AS winner_score_sum FROM games WHERE `match` = $current_match_id AND winner=1"); 
    $row = mysqli_fetch_assoc($result); 
    $p1_winner_score = $row['winner_score_sum'];

    $result = mysqli_query($db,"SELECT SUM(loser_score) AS loser_score_sum FROM games WHERE `match` = $current_match_id AND loser=1"); 
    $row = mysqli_fetch_assoc($result); 
    $p1_loser_score = $row['loser_score_sum'];
  
    $p1_total_score = $p1_winner_score + $p1_loser_score; 

    $p1_ppg = round($p1_total_score/$p1_total_games,1);
    echo "<small><br />".$p1_total_score."pts"."<br />$p1_ppg"."ppg</small>";
    echo "</td>";

    echo "<td>";
    $result = mysqli_query($db,"SELECT * FROM games WHERE `match` = $current_match_id AND winner = 2");
    $p2_games_won = mysqli_num_rows($result);
    echo $p2_games_won." wins";

    $result = mysqli_query($db,"SELECT * FROM games WHERE `match` = $current_match_id AND loser = 2");
    $p2_games_lost = mysqli_num_rows($result);
    //echo $p1_games_lost;
    $p2_total_games = $p2_games_won+$p2_games_lost;

    $result = mysqli_query($db,"SELECT SUM(winner_score) AS winner_score_sum FROM games WHERE `match` = $current_match_id AND winner=2"); 
    $row = mysqli_fetch_assoc($result); 
    $p2_winner_score = $row['winner_score_sum'];

    $result = mysqli_query($db,"SELECT SUM(loser_score) AS loser_score_sum FROM games WHERE `match` = $current_match_id AND loser=2"); 
    $row = mysqli_fetch_assoc($result); 
    $p2_loser_score = $row['loser_score_sum'];
  
    $p2_total_score = $p2_winner_score + $p2_loser_score; 

    $p2_ppg = round($p2_total_score/$p1_total_games,1);
    echo "<small><br />".$p2_total_score."pts"."<br />$p2_ppg"."ppg</small>";
    echo "</td>";
    echo "<td colspan=\"2\">Dscore ".abs($p1_total_score-$p2_total_score)."</td>";

  } else {
    echo "<tr><td colspan=\"5\"><input type=\"submit\" name=\"start_match\" value=\"Start New Match\" /></td>";
  }
?>
</tr>
<tr>
<td>
Previous Match
</td>
<td>
<?php
  
  if(isset($last_match_id)) {
    //$result = mysqli_query($db,"SELECT * FROM games WHERE `match` = $last_match_id AND winner = 1");
    //echo mysqli_num_rows($result);

    $result = mysqli_query($db,"SELECT * FROM games WHERE `match` = $last_match_id AND winner = 1");
    $p1_games_won = mysqli_num_rows($result);
    echo $p1_games_won." wins";

    $result = mysqli_query($db,"SELECT * FROM games WHERE `match` = $last_match_id AND loser = 1");
    $p1_games_lost = mysqli_num_rows($result);
    //echo $p1_games_lost;
    $p1_total_games = $p1_games_won+$p1_games_lost;

    $result = mysqli_query($db,"SELECT SUM(winner_score) AS winner_score_sum FROM games WHERE `match` = $last_match_id AND winner=1"); 
    $row = mysqli_fetch_assoc($result); 
    $p1_winner_score = $row['winner_score_sum'];

    $result = mysqli_query($db,"SELECT SUM(loser_score) AS loser_score_sum FROM games WHERE `match` = $last_match_id AND loser=1"); 
    $row = mysqli_fetch_assoc($result); 
    $p1_loser_score = $row['loser_score_sum'];
  
    $p1_total_score = $p1_winner_score + $p1_loser_score; 

    $p1_ppg = round($p1_total_score/$p1_total_games,1);
    echo "<small><br />".$p1_total_score."pts"."<br />$p1_ppg"."ppg</small>";
  }
  
?>
</td>
<td>
<?php

  if(isset($last_match_id)) {
    //$p2_result = mysqli_query($db,"SELECT * FROM games WHERE winner = 2 AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)");
    //$result = mysqli_query($db,"SELECT * FROM games WHERE winner = 2 AND `match` = $last_match_id");
    //echo mysqli_num_rows($result);
    $result = mysqli_query($db,"SELECT * FROM games WHERE `match` = $last_match_id AND winner = 2");
    $p2_games_won = mysqli_num_rows($result);
    echo $p2_games_won." wins";

    $result = mysqli_query($db,"SELECT * FROM games WHERE `match` = $last_match_id AND loser = 2");
    $p2_games_lost = mysqli_num_rows($result);
    //echo $p1_games_lost;
    $p2_total_games = $p2_games_won+$p2_games_lost;

    $result = mysqli_query($db,"SELECT SUM(winner_score) AS winner_score_sum FROM games WHERE `match` = $last_match_id AND winner=2"); 
    $row = mysqli_fetch_assoc($result); 
    $p2_winner_score = $row['winner_score_sum'];

    $result = mysqli_query($db,"SELECT SUM(loser_score) AS loser_score_sum FROM games WHERE `match` = $last_match_id AND loser=2"); 
    $row = mysqli_fetch_assoc($result); 
    $p2_loser_score = $row['loser_score_sum'];
  
    $p2_total_score = $p2_winner_score + $p2_loser_score; 

    $p2_ppg = round($p2_total_score/$p1_total_games,1);
    echo "<small><br />".$p2_total_score."pts"."<br />$p2_ppg"."ppg</small>";
  }

?>
</td>
<td colspan="2">
<?php
echo "Dscore ".abs($p1_total_score-$p2_total_score);
?>
</td>
</tr>
<tr>
<td>
Overall Record
</td>
<td>
<?php

  $result = mysqli_query($db,"SELECT * FROM games WHERE winner = 1");
  $p1_games_won = mysqli_num_rows($result);
  echo $p1_games_won." wins";

  $result = mysqli_query($db,"SELECT * FROM games WHERE loser = 1");
  $p1_games_lost = mysqli_num_rows($result);
  //echo $p1_games_lost;
  $p1_total_games = $p1_games_won+$p1_games_lost;

  $result = mysqli_query($db,"SELECT SUM(winner_score) AS winner_score_sum FROM games WHERE winner=1"); 
  $row = mysqli_fetch_assoc($result); 
  $p1_winner_score = $row['winner_score_sum'];

  $result = mysqli_query($db,"SELECT SUM(loser_score) AS loser_score_sum FROM games WHERE loser=1"); 
  $row = mysqli_fetch_assoc($result); 
  $p1_loser_score = $row['loser_score_sum'];
  
  $p1_total_score = $p1_winner_score + $p1_loser_score; 

  $p1_ppg = round($p1_total_score/$p1_total_games,1);
  echo "<small><br />".$p1_total_score."pts"."<br />$p1_ppg"."ppg</small>";

?>
</td>
<td>
<?php

  $result = mysqli_query($db,"SELECT * FROM games WHERE winner = 2");
  $p2_games_won = mysqli_num_rows($result);
  echo $p2_games_won." wins";

  $result = mysqli_query($db,"SELECT * FROM games WHERE loser = 2");
  $p2_games_lost = mysqli_num_rows($result);
  //echo $p2_games_lost;
  $p2_total_games = $p2_games_won+$p2_games_lost;

  $result = mysqli_query($db,"SELECT SUM(winner_score) AS winner_score_sum FROM games WHERE winner=2"); 
  $row = mysqli_fetch_assoc($result); 
  $p2_winner_score = $row['winner_score_sum'];

  $result = mysqli_query($db,"SELECT SUM(loser_score) AS loser_score_sum FROM games WHERE loser=2"); 
  $row = mysqli_fetch_assoc($result); 
  $p2_loser_score = $row['loser_score_sum'];
  
  $p2_total_score = $p2_winner_score + $p2_loser_score; 

  $p2_ppg = round($p2_total_score/$p2_total_games,1);
  echo "<small><br />".$p2_total_score."pts"."<br />$p2_ppg"."ppg</small>";

?>
</td>
<td colspan="2">
<?php
echo "Dscore ".abs($p1_total_score-$p2_total_score);
?>
</td>
</tr>
</table>
</form>

<img src="pong_track.php" />
<br />
<?

  echo "<small>Created by $by ($contact) on $on as homage to St. Probaloni. Version $version updated on $updated.<a href=\"https://just69.justhost.com:2083/cpsess1570049879/3rdparty/phpMyAdmin/index.php?input_username=evosecom\">DB</a></small>";

?>

</body>
</html>
