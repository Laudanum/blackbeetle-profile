<div class="container_12">
            <div id="header"></div>
            <div id="body">
                <?php print render($page['front_section']); 

                ?>

                <?php
                  foreach ( $sections as $column ):
                ?>

                <div class="col col_01">
                  <a class="link" href="<?=url($column['path'])?>">
                    <div class="img">
                      <? foreach ( $column['field_media_file'] as $file ): ?>
                      <img src="<?=$file['url']?>" alt="<?=$file['title']?>" />                        
                      <? endforeach; ?>

                      <div class="text">
                        <div class="body"><?=$column['field_description']?></div>
                      </div>
                    </div>
                    
                    <div class="title">
                      <span class="num">0<?=$column['delta']?></span>
                      <h2><?=$column['title']?></h2>
                    </div>
                  </a>
                </div>
                
                <?php endforeach; ?>
                                
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