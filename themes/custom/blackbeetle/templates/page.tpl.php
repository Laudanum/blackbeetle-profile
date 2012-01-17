<div class="container_12">
            <div id="header">
                <div class="title">
                    <h1><?php print $site_name; ?></h1>
                    <span class="num">&nbsp;</span>
                    <h2><?php print $title; ?></h2>
                </div>
                <div class="nav">
                    <?php print render($page['primary_menu']);  ?>
                </div>
            </div>
            <div id="body">
                <div class="content" >
                        <section>
                           <?php print render($page['highlighted']); ?>
                          <?php print $breadcrumb; ?>
                          <a id="main-content"></a>
                          <?php print $messages; ?>
                          <?php if ($tabs = render($tabs)): ?>
                            <div class="tabs"><?php print $tabs; ?></div>
                          <?php endif; ?>
                          <?php print render($page['help']); ?>
                          <?php if ($action_links): ?>
                            <ul class="action-links"><?php print render($action_links); ?></ul>
                          <?php endif; ?>
                          <?php print render($page['content']); ?>
                          <?php print $feed_icons; ?>
                        </section>
                 </div>
                
                
                <div class="clear">&nbsp;</div>
            </div>
            <div id="footer">
                <div class="footer_body clearfix">
                    <div class="contacts">
                        <div class="phone">ph: +61 2 9999 5555</div>
                    </div>
                    <?php print render($page['footer_left']); ?>
                    
                    <div class="site-info"> <?php print $site_slogan; ?></div>
                    <?php print render($page['footer_right']); ?>
                </div>
                <div id="site-name" class="footer-right">
                    <h1><?php print $site_name; ?></h1>
                </div>
            </div>
        </div>