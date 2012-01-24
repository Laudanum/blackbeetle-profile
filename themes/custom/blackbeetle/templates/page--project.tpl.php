<!-- template page project -->
<div class="container_12">
            <div id="header">
                <div class="title">
                    <h1><?php print $site_name; ?></h1>
                    <a href="<?=$page_url?>" title="<?=$page_title?>">
                    <span class="num"><?php print $page_number; ?></span>
                    <h2><?php print $page_title; ?></h2>
                    </a>
                </div>
                <div class="nav">
                    <?php if (isset($main_menu)) : ?>
                        <?php print theme('links', array('links' => $main_menu, 'attributes' => array('class' => 'links main-menu'))) ?>
                    <?php endif; ?>
                </div>
            </div>
            <div id="body">
                <div class="arrows">
                    <div class="arrow arrow-left"><?=$page_previous?></div>
                    <div class="arrow arrow-right"><?=$page_next?></div>
                </div>  

                <?php if ($tabs = render($tabs)): ?>
                  <div class="tabs"><?php print $tabs; ?></div>
                  <div class="clear">&nbsp;</div>
                <?php endif; ?>

                <?php print render($page['content']) ?>
                
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
