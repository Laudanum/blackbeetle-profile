<div class="container_12">
            <div id="header"></div>
            <div id="body">
                <?php print render($page['front_section']); ?>
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
                <div id="site-name">
                    <h1><?php print $site_name; ?></h1>
                </div>
            </div>
        </div>