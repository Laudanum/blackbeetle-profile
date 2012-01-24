<!-- template node project -->
<?php
  hide($content['field_category']);
  hide($content['field_country']);
  hide($content['field_location']);
  hide($content['field_byline']);
  hide($content['field_description']);
?>
                
                <div class="col full_image">

                  <div class="gallery-container">
                    <?php print render($content['field_media']); ?>
                  </div>
                  
                  <div class="art">
                    <div class="meta">
                      <h4 class="title"><?php print $title; ?></h4>
                      <div class="byline"><?php print render($content['field_byline']); ?></div>
                      <div class="location"><?php print render($content['field_location']); ?></div>
                      <div class="country"><?php print render($content['field_country']); ?></div>
                    </div>
                  </div>
                    
                </div>
                
                <div class="col art-text">
                    <div class="clear">&nbsp;</div>
                    <?php 
                      print render($content);
                    ?>                    
                </div>
