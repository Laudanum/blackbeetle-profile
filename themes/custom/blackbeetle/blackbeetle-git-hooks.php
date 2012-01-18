<?php
/*
# discover the ssh key directories used for home by www-data
sudo -u www-data ssh -v git@github.com
debug1: identity file /var/www/.ssh/id_rsa type -1

# make a keey for the www-data user
sudo -u www-data mkdir /var/www/.ssh/; sudo -u www-data ssh-keygen -f /var/www/.ssh/id_rsa && sudo -u www-data less /var/www/.ssh/id_rsa.pub

# add the key to github

# target our repo - note the trailing .git
REPO=/home/laudanum/public_html/blackbeetle.com.au/blackbeetle-profile/.git

# chown everything in the repo to www-data
sudo chown -R www-data $REPO

# test the method
sudo -u www-data git --git-dir=$REPO reset --hard HEAD && sudo -u www-data git --git-dir=$REPO pull

# create a php file to hit from github
sudo -u www-data git --git-dir=/home/laudanum/public_html/blackbeetle.com.au/blackbeetle-profile/.git reset --hard HEAD && sudo -u www-data git --git-dir=/home/laudanum/public_html/blackbeetle.com.au/blackbeetle-profile/.git pull

# point github to it
admin > Repository Administration > Service Hooks > Post-Receive URLs
*/

  $TREE = "/home/laudanum/public_html/blackbeetle.com.au/blackbeetle-profile";
  $REPO = "$TREE/.git";
  
// Use in the "Post-Receive URLs" section of your GitHub repo.
  if ( $_REQUEST['payload'] ) {
//  not sure why we have to reset afterwards too but otherwise the changes don't come in
    $command = "git --git-dir=$REPO reset --hard HEAD";
    echo $command . "\n";
    echo shell_exec($command) . "\n";
    $command = "git --git-dir=$REPO fetch";
    echo $command . "\n";
    echo shell_exec($command) . "\n";
    $command = "git --git-dir=$REPO --work-tree=$TREE merge origin/master;
    echo $command . "\n";
    echo shell_exec($command);
  }
  print "\nOK";
?>
