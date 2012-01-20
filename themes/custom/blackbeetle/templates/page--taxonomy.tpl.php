<!-- template page taxonomy -->
<?php 
  kpr($page);
  $body = $page['content']['system_main']['main']['#markup'];
?>
<div class="container_12">
            <div id="header">
                <div class="title">
                    <h1><?php print $site_name; ?></h1>
                    <span class="num"><?php print $page_number; ?></span>
                    <h2><?php print $page_title; ?></h2>
                </div>
                <div class="nav">
                    <?php if (isset($main_menu)) : ?>
                        <?php print theme('links', array('links' => $main_menu, 'attributes' => array('class' => 'links main-menu'))) ?>
                    <?php endif; ?>
                </div>
            </div>
            <div id="body">
                <!--<div class="arrows">
                    <div class="arrow arrow-left"><a href="javascript: void(0)"></a></div>
                    <div class="arrow arrow-right"><a href="javascript: void(0)"></a></div>
                </div>-->
                <div class="gallery">
                    <?php print $body; ?>
                </div>
                
                <div class="clear">&nbsp;</div>
            </div>
            <div id="footer">
                <div class="footer_body clearfix">
                    <?php print render($page['footer_left']); ?>
                    <?php print render($page['footer_right']); ?>
                </div>
                <div id="site-name">
                    <h1><?php print $site_name; ?></h1>
                </div>
            </div>
        </div>