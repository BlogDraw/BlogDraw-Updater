<?php
	//Update Script for Updating BlogDraw to v0.0.1-beta-2.1
	echo '<h1>Starting Update...</h1>';
	echo '<p>Thank you for your patience.</p>';
	//Alter the functions file
	$FunctionsFile = file_get_contents('../functions.php');
	$FunctionsFileData = explode('?><?php', $FunctionsFile);
	$FunctionsFileNew = $FunctionsFileData[0] . "?>" . file_get_contents('./XXXXX');//NEW FUNCTIONS FILE
	file_put_contents('../functions.php',$FunctionsFileNew);
	echo '<p>X% Complete.</p>';
	//Alter Database
	require_once('../functions.php');
	$DBConnection = mysqli_connect(DBSERVER,DBUSER,DBPASS,DBNAME);
	if (!$DBConnection)
	{
		die('Could not connect to database.  Please try again later.');
	}
	$DBQuery = "DROP TABLE ". DBPREFIX . "_AnalyticsTable;";
	mysqli_query($DBConnection,$DBQuery);
	mysqli_close($DBConnection);
	echo '<p>XX% Complete.</p>';

	//Changes to Files
	file_put_contents('XXXFILE TO REPLACEXXX', file_get_contents('./XXXNEW FILEXXX'));
	echo '<p>XX% Complete.</p>';
	
	echo "<p>Done!  You can now close this window.</p>
	<strong>It's highly recommended that you now delete the &quot;updater&quot; directory.</strong>";
?>
