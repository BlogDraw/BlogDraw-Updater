<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
//Update Script for Updating BlogDraw to v0.0.1-beta-2.1
echo '<h1>Starting Update...</h1>';
echo '<p>Thank you for your patience.</p>';

file_put_contents("BlogDrawSrc.tar.gz", fopen("https://github.com/TuxSoftLimited/BlogDraw/archive/v0.0.1-beta-2.1.tar.gz", 'r'));// Get the release from GitHub.
exec('tar -xf BlogDrawSrc.tar.gz');// Unpack it.

//Alter the functions file
$functionsFile = file_get_contents('../functions.php');
$functionsFileData = explode('?><?php', $functionsFile);// Split the client data from the primary functions.
$functionsFile = $functionsFileData[0] . "?>" . file_get_contents('./BlogDraw-0.0.1-beta-2.1/functions.php');
file_put_contents('../functions.php', $functionsFile);// replace the functions.

//Alter the .htaccess file
$htaccessFile = file_get_contents('../.htaccess');
if (!(strpos($htaccessFile, 'RewriteRule ^(Back/functions) - [F,L,NC]') !== false))// If they don't have the new rewrite rule:
{
  $htaccessFileData = explode('RewriteRule ^(functions\.php) - [F,L,NC]', $htaccessFile);
  $htaccessFile = $htaccessFileData[0] . "RewriteRule ^(functions\.php) - [F,L,NC]
RewriteRule ^(Back/functions) - [F,L,NC]" . $htaccessFileData[1];
  file_put_contents('../.htaccess', $htaccessFile);// Write it in.
}

//Remove old analytics table from database
$dBServerLocation = explode("DBSERVER', '", $functionsFileData[0]);
$DBSERVER = explode("')", $dBServerLocation[1])[0];
$dBUserLocation = explode("DBUSER', '", $functionsFileData[0]);
$DBUSER = explode("')", $dBUserLocation[1])[0];
$dBPassLocation = explode("DBPASS', '", $functionsFileData[0]);
$DBPASS = explode("')", $dBPassLocation[1])[0];
$dBNameLocation = explode("DBNAME', '", $functionsFileData[0]);
$DBNAME = explode("')", $dBNameLocation[1])[0];
$dBPrefixLocation = explode("DBPREFIX', '", $functionsFileData[0]);
$DBPREFIX = explode("')", $dBPrefixLocation[1])[0];
$dBConnection = mysqli_connect($DBSERVER,$DBUSER,$DBPASS,$DBNAME);
if (!$dBConnection)
{
  die('Could not connect to database.  Please try again later.');
}
$dBQuery = "CREATE TABLE ". $DBPREFIX . "_AnalyticsTable IF NOT EXISTS;";
mysqli_query($dBConnection,$dBQuery);// To ensure we're not deleting a non-existent table.
$dBQuery = "DROP TABLE ". $DBPREFIX . "_AnalyticsTable;";
mysqli_query($dBConnection,$dBQuery);// Get rid of the table.
mysqli_close($dBConnection);

//Change files
$rootDir = "BlogDraw-0.0.1-beta-2.1";// The root node containing new files.
scan_folder($rootDir);// Replaces old BlogDraw files with new ones from the root node.

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
        $to = explode("BlogDraw-0.0.1-beta-2.1", realpath($dir) . '/' . $file);
        if (!file_put_contents($_SERVER['DOCUMENT_ROOT'] . $to[1], file_get_contents('.' . $from[1])))
        {
          $copyToDir = implode('/', explode('/', ($_SERVER['DOCUMENT_ROOT'] . $to[1]), -1));
          mkdir($copyToDir, 0755);
          $newFile = fopen($_SERVER['DOCUMENT_ROOT'] . $to[1], "w");
          fwrite($newFile, file_get_contents('.' . $from[1]));
          fclose($newFile);
        }
      }
    }
  }
}

echo "<p>Done!  You can now close this window and delete the &quot;updater&quot; directory.</p>";
?>