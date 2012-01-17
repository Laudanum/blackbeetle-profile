<div class="container_12">
            <div id="header">
                <div class="title">
                    <h1><?php print $site_name; ?></h1>
                    <span class="num">01</span>
                    <h2><?php print $title; ?></h2>
                </div>
                <div class="nav">
                    <?php print render($page['primary_menu']);  ?>
                </div>
            </div>
            <div id="body" style="margin-bottom: 100px;">
                        
                <div class="col col_01">
                    <div class="img">
                        <?php print $image; ?>
                    </div>
                </div>
                <div class="col col_03">
                    <div class="content" style="margin-left: 160px;">
                        <?php if ($tabs = render($tabs)): ?>
                            <div class="tabs"><?php print $tabs; ?></div>
                        <?php endif; ?><div class="clear">&nbsp;</div>
                        <section>
                            <?php print $body; ?>
                        </section>
                    </div>
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