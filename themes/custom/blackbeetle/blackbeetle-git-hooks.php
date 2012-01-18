<?php
  $source_dir = "/home/laudanum/public_html/blackbeetle.com.au/blackbeetle-profile/";
// Use in the "Post-Receive URLs" section of your GitHub repo.
  if ( $_REQUEST['payload'] ) {
    echo shell_exec('whoami');
    echo "<br />";
    echo shell_exec('ls -la '. $source_dir); 
    echo "<br />";
    echo shell_exec('GIT_DIR' . $source_dir . ' && git reset --hard HEAD && git pull');
    echo "<br />"; 
    print_r($_REQUEST['payload']);
    echo "<br />"; 
  }
	print "OK:";
?>
