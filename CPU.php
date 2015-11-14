<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HCM :: CPU Usage Watchdog</title>
<style type="text/css">
<!--
.title {
	font-weight: bold;
	border-top-style: none;
	border-bottom-style: none;
	color: #FFF;
	background-color: #000;
	text-align: center;
}
.data {
	text-align: center;
}
.high {
	text-align: center;
	font-weight:bolder;
	color:#000;
	background-color:#F00;
}
.moderate {
	text-align: center;
	font-weight:bolder;
	color:#000;
	background-color:#FF3;
}
.low {
	text-align: center;
	font-weight:bolder;
	color:#000;
	background-color:#0F0;
}
-->
</style>
</head>
<body>

<p align="center">
<img src="sum.jpg" alt="Server Utilization Manager" />
<br />
    <a href="http://validator.w3.org/check?uri=referer"><img
        src="http://www.w3.org/Icons/valid-xhtml10-blue"
        alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
</p>

<?php

define( 'IN_HCM', 1 );

require ("includes/mainClass.php");


$capture = $_GET['r'];

$statCode = array("S", "D", "R", "Z", "T");
$statString = array("Sleeping", "Uninterruptible Sleep", "Running", "Zombie", "Stopped");

exec ("top -b -n 1",$cpuUsage);

$numres = count($cpuUsage);

unset($cpuUsage[0]);
unset($cpuUsage[1]);
unset($cpuUsage[2]);
unset($cpuUsage[3]);
unset($cpuUsage[4]);
unset($cpuUsage[5]);
unset($cpuUsage[6]);

?>
<div align="center">
<table width="80%" border="2" cellpadding="3" cellspacing="3">
<tr>
<td class="title">Process<br />ID</td>
<td class="title" width="15%">User</td>
<td class="title">Priority</td>
<td class="title">Swap<br />Used</td>
<td class="title" width="15%">Status</td>
<td class="title">CPU<br />Usage</td>
<td class="title">Memory<br />Usage</td>
<td class="title">Task Run<br />Time</td>
<td class="title" width="15%">Command<br />Name</td>
</tr>

<?php

foreach ($cpuUsage as $value) 
{
	$value = preg_replace('/\s\s+/', ' ', $value);
	$value = preg_replace('/ /', ' ', $value);
	$value = str_replace(' ', ',', $value);
	$value = trim($value);
	$results = explode(',', $value);
		
	//Fix Space Related Parse Issues
	if ( strlen($results[1]) == 0)
	{
		//Do Nothing
	}
	elseif ( strlen($results[0]) == 0 )
	{
		$results[8] = ltrim( $results[8] );
		$results[8] = rtrim( $results[8] );
		$results[8] = str_replace($statCode, $statString, $results[8]);
		
		echo "<tr>";
		echo "<td class='data'>";
		echo $results[1];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[2];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[3];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[5];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[8];
		echo "</td>";
		
		if ( $results[9] >= "70" )
		{
			echo "<td class='high'>";
			echo $results[9];
			echo "</td>";
		}
		elseif ( $results[9] >= "40" )
		{
			echo "<td class='moderate'>";
			echo $results[9];
			echo "</td>";
		}
		else
		{
			echo "<td class='low'>";
			echo $results[9];
			echo "</td>";
		}
		
		
		echo "<td class='data'>";
		echo $results[10];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[11];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[12];	
		echo "</td>";
		echo "</tr>";
		
		$user = $results[2];
		$cpuUsage = $results[9];
		$memUsage = $results[10];
		$commName = $results[12];
	}
	else
	{	
		$results[7] = ltrim( $results[7] );
		$results[7] = rtrim( $results[7] );
		$results[7] = str_replace($statCode, $statString, $results[7]);
		
		echo "<tr>";
		echo "<td class='data'>";
		echo $results[0];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[1];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[2];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[4];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[7];
		echo "</td>";
		
		if ( $results[8] > "69" )
		{
			echo "<td class='high'>";
			echo $results[8];
			echo "</td>";
		}
		elseif ( $results[8] > "39" )
		{
			echo "<td class='moderate'>";
			echo $results[8];
			echo "</td>";
		}
		else
		{
			echo "<td class='low'>";
			echo $results[8];
			echo "</td>";
		}
		
		echo "<td class='data'>";
		echo $results[9];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[10];
		echo "</td>";
		echo "<td class='data'>";
		echo $results[11];	
		echo "</td>";
		echo "</tr>";
		
		$user = $results[1];
		$cpuUsage = $results[8];
		$memUsage = $results[9];
		$commName = $results[11];
	}	
}

?>

</table>
</div>
</body>
</html>
