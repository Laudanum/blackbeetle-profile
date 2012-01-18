<?php
  $REPO = "/home/laudanum/public_html/blackbeetle.com.au/blackbeetle-profile/.git";
// Use in the "Post-Receive URLs" section of your GitHub repo.
  if ( $_REQUEST['payload'] ) {
//  not sure why we have to reset afterwards too but otherwise the changes don't come in
    $command = ("git --git-dir=$REPO reset --hard HEAD && git --git-dir=$REPO pull; git --git-dir=$REPO reset --hard HEAD");
    echo shell_exec($command);
  }
  print "\nOK";
?>
