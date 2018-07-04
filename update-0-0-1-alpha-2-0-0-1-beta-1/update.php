<?php
 //Update Script for Updating BlogDraw from v0.0.1-alpha-2 to v0.0.1-beta-1
 //Changes to .htaccess
 echo '<h1>Starting Update...</h1>';
 echo '<p>Thank you for your patience.</p>';
$HtaccessFile = "../.htaccess";
$HtaccessContent = file($HtaccessFile);
foreach($HtaccessContent as $LineNumber => &$LineContent)
{
	if($LineNumber == 1)
	{
		$LineContent = 'ErrorDocument 404 /index.php' . $LineContent;
	}
}
$AllContent = implode("", $HtaccessContent);
file_put_contents($HtaccessFile, $AllContent);
echo '<p>25% Complete.</p>';
//Changes to /Back/functions_back.php
file_put_contents('../Back/functions_back.php', file_get_contents('./functions_back.php.new'));
echo '<p>50% Complete.</p>';
//Changes to /README.md
file_put_contents('../README.md', file_get_contents('./README.md.new'));
echo '<p>75% Complete.</p>';
//Changes to /plugins/Cookies/index.php
file_put_contents('../plugins/Cookies/index.php', file_get_contents('./Cookies-index.php.new'));
echo '<p>100% Complete.</p>';
echo '<p>Done!  You can now close this window.</p>
<strong>It is highly recommended that you now delete the &quot;update-0-0-1-alpha-2-0-0-1-beta-1&quot; folder.</strong';
?>
