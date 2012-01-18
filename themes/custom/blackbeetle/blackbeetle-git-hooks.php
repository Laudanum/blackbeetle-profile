<?php
  $REPO = "/home/laudanum/public_html/blackbeetle.com.au/blackbeetle-profile/.git";
// Use in the "Post-Receive URLs" section of your GitHub repo.
  if ( $_REQUEST['payload'] ) {
    echo shell_exec('whoami');
    echo "<br />";
    echo shell_exec('ls -la '. $REPO); 
    echo "<br />";
    echo shell_exec("sudo -u www-data git --git-dir=$REPO reset --hard HEAD && sudo -u www-data git --git-dir=$REPO pull");
    echo "<br />"; 
    print_r($_REQUEST['payload']);
    echo "<br />"; 
  }
	print "OK:";
?>
