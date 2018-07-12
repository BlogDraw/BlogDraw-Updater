<?php
	//Update Script for Updating BlogDraw from v0.0.1-beta-1 to v0.0.1-beta-2
	echo '<h1>Starting Update...</h1>';
	echo '<p>Thank you for your patience.</p>';
	//Alter the functions file
	$FunctionsFile = file_get_contents('../functions.php');
	$FunctionsFileData = explode('?><?php', $FunctionsFile);
	$FunctionsFileNew = $FunctionsFileData[0] . "?>" . file_get_contents('./functions.php.new');
	file_put_contents('../functions.php',$FunctionsFileNew);
	echo '<p>11% Complete.</p>';
	//Alter Database
	require_once('../functions.php');
	$DBConnection = mysqli_connect(DBSERVER,DBUSER,DBPASS,DBNAME);
	if (!$DBConnection)
	{
		die('Could not connect to database.  Please try again later.');
	}
	$DBQuery = "ALTER TABLE ". DBPREFIX . "_LoginTable ADD COLUMN UserBlurb LONGTEXT,ADD COLUMN UserImage VARCHAR(255);";
	mysqli_query($DBConnection,$DBQuery);
	mysqli_close($DBConnection);
	echo '<p>22% Complete.</p>';
	//Changes to /Back/functions_back.php
	file_put_contents('../Back/functions_back.php', file_get_contents('./functions_back.php.new'));
	echo '<p>33% Complete.</p>';
	//Changes to /index.php
	file_put_contents('../index.php', file_get_contents('./index.php.new'));
	echo '<p>44% Complete.</p>';
	//Changes to /template/BlogDraw2018/index.php
	file_put_contents('../template/BlogDraw2018/index.php', file_get_contents('./template-blogdraw2018-index.php.new'));
	echo '<p>55.5% Complete.</p>';
	//Changes to /template/DarkBlogDraw2018/index.php
	file_put_contents('../template/DarkBlogDraw2018/index.php', file_get_contents('./template-darkblogdraw2018-index.php.new'));
	echo '<p>67% Complete.</p>';
	//Changes to /Uploads/1.png
	file_put_contents('../Uploads/1.png', file_get_contents('./1.png'));
	echo '<p>78% Complete.</p>';
	//Changes to /Uploads/apple-touch-icon.png
	file_put_contents('../Uploads/apple-touch-icon.png', file_get_contents('./apple-touch-icon.png'));
	echo '<p>89% Complete.</p>';
	//Changes to /Uploads/favicon.ico
	file_put_contents('../Uploads/favicon.ico', file_get_contents('./favicon.ico'));
	echo '<p>100% Complete.</p>';
	echo '<p>Done!  You can now close this window.</p>
	<strong>It is highly recommended that you now delete the &quot;update-0-0-1-beta-1-0-0-1-beta-2&quot; directory.</strong';
?>
