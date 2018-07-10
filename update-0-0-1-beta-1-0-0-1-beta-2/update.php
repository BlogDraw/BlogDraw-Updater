<?php
 //Update Script for Updating BlogDraw from v0.0.1-alpha-2 to v0.0.1-beta-1
 //Changes to .htaccess
 echo '<h1>Starting Update...</h1>';
 echo '<p>Thank you for your patience.</p>';

//Alter Database

//Figure out how to alter thefunctions file

echo '<p>% Complete.</p>';
//Changes to /Back/functions_back.php
file_put_contents('../Back/functions_back.php', file_get_contents('./functions_back.php.new'));
echo '<p>% Complete.</p>';
//Changes to /index.php
file_put_contents('../index.php', file_get_contents('./index.php.new'));
echo '<p>% Complete.</p>';
//Changes to /template/BlogDraw2018/index.php
file_put_contents('../template/BlogDraw2018/index.php', file_get_contents('./template-blogdraw2018-index.php.new'));
echo '<p>% Complete.</p>';
//Changes to /template/DarkBlogDraw2018/index.php
file_put_contents('../template/DarkBlogDraw2018/index.php', file_get_contents('./template-darkblogdraw2018-index.php.new'));
echo '<p>% Complete.</p>';
//Changes to /Uploads/1.png
file_put_contents('../Uploads/1.png', file_get_contents('./1.png'));
echo '<p>% Complete.</p>';
//Changes to /Uploads/apple-touch-icon.png
file_put_contents('../Uploads/apple-touch-icon.png', file_get_contents('./apple-touch-icon.png'));
echo '<p>% Complete.</p>';
//Changes to /Uploads/favicon.ico
file_put_contents('../Uploads/favicon.ico', file_get_contents('./favicon.ico'));
echo '<p>100% Complete.</p>';
echo '<p>Done!  You can now close this window.</p>
<strong>It is highly recommended that you now delete the &quot;update-0-0-1-alpha-2-0-0-1-beta-1&quot; folder.</strong';
?>
