<?php
  $REPO = "/home/laudanum/public_html/blackbeetle.com.au/blackbeetle-profile/.git";
// Use in the "Post-Receive URLs" section of your GitHub repo.
  if ( $_REQUEST['payload'] ) {
    $command = ("git --git-dir=$REPO reset --hard HEAD && git --git-dir=$REPO pull");
    echo shell_exec($command);
  }
  print "\nOK";
?>
