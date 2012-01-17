<div class="container_12">
            <div id="header">
                <div class="title">
                    <h1><?php print $site_name; ?></h1>
                    <span class="num">02</span>
                    <h2>Selected Projects</h2>
                </div>
                <div class="nav">
                    <?php print render($page['primary_menu']);  ?>
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