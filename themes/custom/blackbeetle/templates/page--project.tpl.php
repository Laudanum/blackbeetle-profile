<div class="container_12">
            <div id="header">
                <div class="title">
                    <h1><?php print $site_name; ?></h1>
                    <span class="num"><?php print $page_number; ?></span>
                    <h2><?php print $page_title; ?></h2>
                </div>
                <div class="nav">
                    <?php print render($page['primary_menu']);  ?>
                </div>
            </div>
            <div id="body">
                <div class="arrows">
                    <div class="arrow arrow-left"><a  class="previous" href="javascript: void(0)"></a></div>
                    <div class="arrow arrow-right"><a class="next" href="javascript: void(0)"></a></div>
                </div>  
                <div class="col" style="width: 630px; padding-right: 20px;">
                   <div class="single_gallery">
                       <?php print $media_info; ?>
                   </div>
                   <div class="art">     
                            <div class="meta">
                                <h4 class="title"><?php print $node_title; ?></h4>
                                <div class="byline"><?php print $byline; ?></div>
                                <div class="location"><?php print $location; ?></div>
                                <div class="country"><?php print $country; ?></div>
                            </div>
                   </div>
                   
                   
                </div>
                <div class="col art-text">
                    <?php if ($tabs = render($tabs)): ?>
                            <div class="tabs"><?php print $tabs; ?></div>
                        <?php endif; ?><div class="clear">&nbsp;</div>
                    <div class="body">
                        <?php print $body; ?>
                    </div>
                    <div class="dots">
                        <?php print $dots; ?>
                    </div>
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
