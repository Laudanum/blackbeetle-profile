<div class="container_12">
            <div id="header">
                <div class="title">
                    <h1><?php print $site_name; ?></h1>
                    <span class="num"><?php print $page_number; ?></span>
                    <h2><?php print $page_title; ?></h2>
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
                <div class="col" style="width: 630px; padding-right: 20px;">
                    <a class="art" href="javascript: void(0)">
                        <div class="img">
                            <?php print $media_info; ?>
                        </div>
                        <div class="meta">
                            <h4 class="title"><?php print $node_title; ?> <br /> <?php print $byline; ?></h4>
                            <?php print $location; ?> <br />
                            <?php print $country; ?>
                        </div>
                    </a>
                </div>
                <div class="col art-text">
                    <?php if ($tabs = render($tabs)): ?>
                            <div class="tabs"><?php print $tabs; ?></div>
                        <?php endif; ?><div class="clear">&nbsp;</div>
                    <div class="body">
                        <?php print $body; ?>
                    </div>
                    <div class="dots">
                        <ul>
                            <li class="active"><a href="javascript: void(0)"></a></li>
                            <li><a href="javascript: void(0)"></a></li>
                            <li><a href="javascript: void(0)"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear">&nbsp;</div>
            </div>
            <div id="footer">
                <div class="body footer-left">
                    <div class="contacts">
                        <div class="phone">ph: +61 2 9999 5555</div>
                    </div>
                </div>
                <div id="site-name" class="footer-right">
                    <h1><a href="home.html">SEO_BB</a></h1>
                </div>
            </div>
        </div>