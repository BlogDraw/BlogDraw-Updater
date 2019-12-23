<?php
//Update Script for Updating BlogDraw to v0.0.1-beta-2.1
echo '<h1>Starting Update...</h1>';
echo '<p>Thank you for your patience.</p>';

file_put_contents("BlogDrawSrc.tar.gz", fopen("https://github.com/TuxSoftLimited/BlogDraw/archive/v0.0.1-beta-2.1.tar.gz", 'r'));
exec('tar -xf BlogDrawSrc.tar.gz');

//Alter the functions file
$functionsFile = file_get_contents('../functions.php');
$functionsFileData = explode('?><?php', $functionsFile);
$functionsFile = $functionsFileData[0] . "?>" . file_get_contents('./BlogDraw-0.0.1-beta-2.1/functions.php');
file_put_contents('../functions.php', $functionsFile);

//Alter the .htaccess file
$htaccessFile = file_get_contents('../.htaccess');
if (!(strpos($htaccessFile, 'RewriteRule ^(Back/functions) - [F,L,NC]') !== false))
{
	$htaccessFileData = explode('RewriteRule ^(functions\.php) - [F,L,NC]', $htaccessFile);
	$htaccessFile = $htaccessFileData[0] . "RewriteRule ^(functions\.php) - [F,L,NC]
RewriteRule ^(Back/functions) - [F,L,NC]" . $htaccessFileData[1];
	file_put_contents('../.htaccess', $htaccessFile);
}

//Remove old analytics table from database
require_once('../functions.php');
$DBConnection = mysqli_connect(DBSERVER,DBUSER,DBPASS,DBNAME);
if (!$DBConnection)
{
  die('Could not connect to database.  Please try again later.');
}
$DBQuery = "CREATE TABLE ". DBPREFIX . "_AnalyticsTable IF NOT EXISTS;";
mysqli_query($DBConnection,$DBQuery);
$DBQuery = "DROP TABLE ". DBPREFIX . "_AnalyticsTable;";
mysqli_query($DBConnection,$DBQuery);
mysqli_close($DBConnection);

//Change files
$rootDir = "BlogDraw-0.0.1-beta-2.1";
scan_folder($rootDir);

function scan_folder($dir)
{
	$files = scandir(realpath($dir));
	foreach($files as $file)
	{
		if (is_dir(realpath($dir) . '/' . $file))
		{
			if ($file != '.' && $file != '..')
				scan_folder(realpath($dir) . '/' . $file);
		}
		else
		{
			if ($file != ".htaccess" && $file != "functions.php" && $file != "install.php" )
			{
				$from = explode("updater", realpath($dir) . '/' . $file);
				$to = explode("BlogDraw-0.0.1-beta-2.1", realpath($dir) . '/' . $file);
				file_put_contents('..' . $to[1], file_get_contents('.' . $from[1]));
			}
		}
	}
}
rmdir('../template/BlogDraw2018');
rmdir('../template/DarkBlogDraw2018');
echo "<p>Done!  You can now close this window and delete the &quot;updater&quot; directory.</p>";
?>