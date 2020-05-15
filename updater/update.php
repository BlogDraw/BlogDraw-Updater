<?php
/**
 * Update Script for Updating BlogDraw to v0.0.1-rc-1
 **/
////Development error reporting.  Should usually be turned off in production systems.
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

echo '<h1>Starting Update...</h1>';
echo '<p>Thank you for your patience.</p>';

file_put_contents("BlogDrawSrc.tar.gz", fopen("https://github.com/TuxSoftLimited/BlogDraw/archive/v0.0.1-rc-1.tar.gz", 'r'));// Get the release from GitHub.
exec('tar -xf BlogDrawSrc.tar.gz');// Unpack it.

//Alter the functions file
$functionsFile = file_get_contents('../functions.php');
$functionsFileData = explode('?><?php', $functionsFile);// Split the client data from the primary functions.
$functionsFile = $functionsFileData[0] . "?>" . file_get_contents('./BlogDraw-0.0.1-rc-1/functions.php');
file_put_contents('../functions.php', $functionsFile);// replace the functions.

//Alter the .htaccess file
$htaccessFile = file_get_contents('../.htaccess');
$htaccessFile = str_replace("Back/", "control/", $htaccessFile);
file_put_contents('../.htaccess', $htaccessFile);// Write it in.

//Alter the robots.txt file
$robotsFile = file_get_contents('../robots.txt');
$robotsFile = str_replace("/Back", "/control", $robotsFile);
file_put_contents('../robots.txt', $robotsFile);// Write it in.

//Change files
$rootDir = "BlogDraw-0.0.1-rc-1";// The root node containing new files.
scan_folder($rootDir);// Replaces old BlogDraw files with new ones from the root node.

//Update Database
require_once('../functions.php');
$DBConnection = mysqli_connect(DBSERVER,DBUSER,DBPASS,DBNAME);
if (!$DBConnection)
  die('Failed to update Database.');
$DBQuery = "ALTER TABLE ". DBPREFIX . "_LoginTable ADD COLUMN DisplayName VARCHAR(25) NOT NULL;";// Add the rc-1 DisplayName feature.
mysqli_query($DBConnection,$DBQuery);
mysqli_close($DBConnection);

echo "<p>Done!  You can now close this window and delete the &quot;updater&quot; directory.</p>";
echo "<p><strong>NEXT STEPS: </strong> For your previous uploads to appear in future versions of BlogDraw, please copy and paste them from the \"Uploads\"directory to the \"uploads\" directory.  To ensure better system security, please delete the \"Back\" directory.  New versions of those files are now available in the \"control\" directory.</p>";

/**
 * This recursively reads a directory and all of it's subdirectories given a relative filepath, then replaces the old files with the new ones.
 * Essentially filesystem traversal.
 * @param dir - The directory to read.
 **/
function scan_folder($dir)
{
  $files = scandir(realpath($dir));
  foreach ($files as $file)
  {
    if (is_dir(realpath($dir) . '/' . $file))// If it's a directory, we want to traverse through that too.
    {
      if ($file != '.' && $file != '..' && $file != 'Uploads')// Don't infinitely loop, or loop back.  scandir gives pointers to . and .. too.
        scan_folder(realpath($dir) . '/' . $file);// traverse deeper.
    }
    else
    {
      if ($file != ".htaccess" && $file != "functions.php" && $file != "install.php" )// Files we don't want to deal with.
      {
        $from = explode("updater", realpath($dir) . '/' . $file);
        $to = explode("BlogDraw-0.0.1-rc-1", realpath($dir) . '/' . $file);
        if (!file_put_contents($_SERVER['DOCUMENT_ROOT'] . $to[1], file_get_contents('.' . $from[1])))
        {
          $copyToDir = implode('/', explode('/', ($_SERVER['DOCUMENT_ROOT'] . $to[1]), -1));
          if (! mkdir($copyToDir, 0755, TRUE))
            echo '<br />Failed to create directory ' . $copyToDir . '!';
          $newFile = fopen($_SERVER['DOCUMENT_ROOT'] . $to[1], "w");
          fwrite($newFile, file_get_contents('.' . $from[1]));
          fclose($newFile);
        }
      }
    }
  }
}
?>
