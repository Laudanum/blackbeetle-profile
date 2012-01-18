<?php
// Use in the "Post-Receive URLs" section of your GitHub repo.
  if ( $_POST['payload'] ) {
    shell_exec( 'cd /home/laudanum/public_html/blackbeetle/blackbeetle_profile/ && git reset --hard HEAD && git pull' );
  }
?>
