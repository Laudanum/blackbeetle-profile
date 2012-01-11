<div class="container_12">
            <div id="header">
                <div class="title">
                    <h1><?php print $site_name; ?></h1>
                    <span class="num">03</span>
                    <h2>Arts</h2>
                </div>
                <div class="nav">
                    <?php print render($page['header']);  ?>
                </div>
            </div>
            <div id="body">
                <div class="arrows">
                    <div class="arrow arrow-left"><a href="javascript: void(0)"></a></div>
                    <div class="arrow arrow-right"><a href="javascript: void(0)"></a></div>
                </div>
                <?php print $body; ?>
                <div class="clear">&nbsp;</div>
            </div>
            <div id="footer">
                <div class="body footer-left">
                    <div class="contacts">
                        <div class="phone">ph: +61 2 9999 5555</div>
                    </div>
                    
                </div>
                <div id="site-name" class="footer-right">
                    <h1><?php print $site_name; ?></h1>
                </div>
            </div>
        </div>