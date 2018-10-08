<?php
	//Update Script for Updating BlogDraw from v0.0.1-beta-2 to v0.0.1-beta-2.1
	echo '<h1>Starting Update...</h1>';
	echo '<p>Thank you for your patience.</p>';
	//Alter the functions file
	$FunctionsFile = file_get_contents('../functions.php');
	$FunctionsFileData = explode('?><?php', $FunctionsFile);
	$FunctionsFileNew = $FunctionsFileData[0] . "?>" . file_get_contents('./functions.php.new');
	file_put_contents('../functions.php',$FunctionsFileNew);
	echo '<p>15.15% Complete.</p>';
  //Changes to /Back/index.php
	file_put_contents('../Back/index.php', file_get_contents('./back_index.php.new'));
	echo '<p>33.3% Complete.</p>';
	//Changes to /Back/functions_back.php
	file_put_contents('../Back/functions_back.php', file_get_contents('./functions_back.php.new'));
	echo '<p>48.48% Complete.</p>';
	//Changes to /index.php
	file_put_contents('../index.php', file_get_contents('./index.php.new'));
	echo '<p>66.66% Complete.</p>';
	//Changes to /README.md
	file_put_contents('../README.md', file_get_contents('./README.md.new'));
  echo '<p>81.81% Complete.</p>';
	//Changes to /CONTRIBUTING.md
	file_put_contents('../CONTRIBUTING.md', file_get_contents('./CONTRIBUTING.md.new'));
  echo '<p>100% Complete.</p>';
	echo '<p>Done!  You can now close this window.</p>
	<strong>It is highly recommended that you now delete the &quot;update-0-0-1-beta-2-0-0-1-beta-2-2&quot; directory.</strong';
?>
