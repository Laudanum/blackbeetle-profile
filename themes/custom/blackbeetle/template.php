<?php

/**
 * Implements hook_css_alter().
 * @TODO: Once http://drupal.org/node/901062 is resolved, determine whether
 * this can be implemented in the .info file instead.
 *
 * Omitted:
 * - color.css
 * - contextual.css
 * - dashboard.css
 * - field_ui.css
 * - image.css
 * - locale.css
 * - shortcut.css
 * - simpletest.css
 * - toolbar.css
 */
function blackbeetle_css_alter(&$css) {
  $exclude = array(
    'misc/vertical-tabs.css' => FALSE,
    'modules/aggregator/aggregator.css' => FALSE,
    'modules/block/block.css' => FALSE,
    'modules/book/book.css' => FALSE,
    'modules/comment/comment.css' => FALSE,
    'modules/dblog/dblog.css' => FALSE,
    'modules/file/file.css' => FALSE,
    'modules/filter/filter.css' => FALSE,
    'modules/forum/forum.css' => FALSE,
    'modules/help/help.css' => FALSE,
    'modules/menu/menu.css' => FALSE,
    'modules/node/node.css' => FALSE,
    'modules/openid/openid.css' => FALSE,
    'modules/poll/poll.css' => FALSE,
    'modules/profile/profile.css' => FALSE,
    'modules/search/search.css' => FALSE,
    'modules/statistics/statistics.css' => FALSE,
    'modules/syslog/syslog.css' => FALSE,
    'modules/system/admin.css' => FALSE,
    'modules/system/maintenance.css' => FALSE,
    'modules/system/system.css' => FALSE,
    'modules/system/system.admin.css' => FALSE,
    'modules/system/system.base.css' => FALSE,
    'modules/system/system.maintenance.css' => FALSE,
    'modules/system/system.menus.css' => FALSE,
    'modules/system/system.messages.css' => FALSE,
    'modules/system/system.theme.css' => FALSE,
    'modules/taxonomy/taxonomy.css' => FALSE,
    'modules/tracker/tracker.css' => FALSE,
    'modules/update/update.css' => FALSE,
    'modules/user/user.css' => FALSE,
  );
  $css = array_diff_key($css, $exclude);
}

/**
 * Implementation of hook_theme().
 */
function blackbeetle_theme() {
  $items = array();

  // Consolidate a variety of theme functions under a single template type.
  $items['block'] = array(
    'arguments' => array('block' => NULL),
    'template' => 'object',
    'path' => drupal_get_path('theme', 'blackbeetle') .'/templates',
  );
  $items['comment'] = array(
    'arguments' => array('comment' => NULL, 'node' => NULL, 'links' => array()),
    'template' => 'object',
    'path' => drupal_get_path('theme', 'blackbeetle') .'/templates',
  );
  $items['node'] = array(
    'arguments' => array('node' => NULL, 'teaser' => FALSE, 'page' => FALSE),
    'template' => 'node',
    'path' => drupal_get_path('theme', 'blackbeetle') .'/templates',
  );
  $items['fieldset'] = array(
    'arguments' => array('element' => array()),
    'template' => 'fieldset',
    'path' => drupal_get_path('theme', 'blackbeetle') .'/templates',
  );

  // Split out pager list into separate theme function.
  $items['pager_list'] = array('arguments' => array(
    'tags' => array(),
    'limit' => 10,
    'element' => 0,
    'parameters' => array(),
    'quantity' => 9,
  ));

  return $items;
}

/**
 * Preprocess functions ===============================================
 */
function blackbeetle_preprocess_html(&$vars) {
  $vars['classes_array'][] = 'blackbeetle';
}

/**
 * Implementation of preprocess_page().
 */
function blackbeetle_preprocess_page(&$vars) {
  // Split primary and secondary local tasks
  $vars['primary_local_tasks'] = menu_primary_local_tasks();
  $vars['secondary_local_tasks'] = menu_secondary_local_tasks();

  // Link site name to frontpage
  $vars['site_name'] = l($vars['site_name'], '<front>');
  $vars['site_slogan'] = $vars['site_slogan'];
  
  if (arg(0) == 'taxonomy' && arg(1) == 'term' && is_numeric(arg(2))) {
    $tid = arg(2);
    
    //Get Selected Project Info
    
    $node_url = "";
    $title = "";
    $description = "";
    
    $byline = "";
    $location = "";
    $country = "";
    
    
    $image = "";
    $image_uri = "";
    $thumb_file_src = "";
    $image_info = "";
    
/*
  get project ID's (nids) related to this page's term
  @TODO this is probably unsorted–we need to interact with nodequeue
*/
    $result = db_query("
      SELECT node.nid AS nid
      FROM {node} node
      INNER JOIN {field_data_field_category} field_data_field_category ON node.nid = field_data_field_category.entity_id 
      AND (
        field_data_field_category.entity_type = 'node' 
        AND field_data_field_category.deleted = 0
      )
      WHERE node.status = 1
      And node.promote = 1
      AND node.type = 'project'
      AND field_data_field_category.field_category_tid = :tid
      ", array(
        ':tid' => $tid,
      )
    );
    
    //  flatten the nids into an array
    $nids = array();
    foreach ($result as $obj) {
      $nids[] = $obj->nid;
    }    

    //  load all the nodes now
    $nodes = node_load_multiple($nids);
    
    if (!empty($nodes)) {
         
      $output = '<ul class="slide_items clearfix" >';

      foreach($nodes as $current_node){
   
        $node_url = url("node/".$current_node->nid);
        $title = $current_node->title;

        $byline = "";
        foreach($current_node->field_byline as $byline_item){
          $byline = $byline_item[0]['value'];
        }


        $location = "";
        foreach($current_node->field_location as $location_item){
          $location = $location_item[0]['value'];
        }

        $country = "";
        foreach($current_node->field_country as $country_item){
          $country = $country_item[0]['value'];
        }

        //  get the first media asset
        $media = $current_node->field_media;        
        $first_image = array();
        foreach($media as $value){
          if(!empty($value)){
            $first_image = $value[0];  
            break;
          }
        }

        //Get File info.
          if(!empty($first_image)) {
              $file = db_query("Select * from {file_managed} Where fid = :fid",array(
              ':fid' => $first_image['fid']
              ));
    
              $thumb_file_src = "";
              foreach ( $file as $file_item ) {
              //  if there is no file then skip ahead
                  if ( ! $file_item->filename ) 
                    continue;
          
                  $thumb_file_src = image_style_url("thumbnail", $file_item->uri);
                  break;
        
              }    
          }    

        $image_info = "";
        $image_info = '<img src="' . $thumb_file_src . '" alt="" />';


        $output .= '<li class="col col_01">';
        $output .= '<a class="art" href="' . $node_url . '">';
        $output .= '<div class="img">';
        $output .= $image_info;
        $output .= "</div>";
        $output .= '<div class="meta"><h4 class="title">' . $title . '</h4><div class="byline" >' . $byline . '</div>';
        $output .= '<div class="location">'.$location . '</div><div class="country">' . $country ;
        $output .= '</div></div></a></li>';
   
      }

      $output .= "</ul>";

      if($output == '<ul class="slide_items clearfix" ></ul>') $output = '';

    }
    
    $vars['body'] =  $output;
    $vars['theme_hook_suggestions'][] = 'page__taxonomy__term'. str_replace('_', '--', $tid);
  }
  
  if (isset($vars['node']) && ($vars['node']->type == 'page')) {
      
      global $base_url;
      
      $file_directory_path = '/' . file_stream_wrapper_get_instance_by_uri('public://')->getDirectoryPath();
    
      $node = $vars['node'];
    
      $node_url = url("node/".$node->nid);
      $node_title = $node->title;
      
    
      $body = "";
      foreach($node->body as $key=>$value) {   
        $body .= $node->body[$key][0]['safe_value'];
      }
      
      $image = $node->field_image;
      $image_uri = $image['und'][0]['uri'];
      
      $thumb_file_src = image_style_url("thumbnail", $image_uri);
      
      $image_info .= '<img src="' . $thumb_file_src . '" title="" />';
     
      $vars['node_url'] = $node_url;
      $vars['node_title'] = $node_title;
      $vars['body'] = $body;
      $vars['image'] = $image_info;
      
      $vars['theme_hook_suggestions'][] = 'page__'. str_replace('_', '--', $vars['node']->type);
  }
  
  if (isset($vars['node']) && ($vars['node']->type == 'project')) {
      
      global $base_url;
      
      $file_directory_path = '/' . file_stream_wrapper_get_instance_by_uri('public://')->getDirectoryPath();
      
      //Current Node info
      $current_node = $vars['node'];
      $current_node_id = $current_node->nid;
      
      //Taxonomy term
      $category_id = "";
      foreach($current_node->field_category as $category_item){
        $category_id = $category_item[0]['tid'];
      }
      
   /***** Get selected projects/arts list *****/
      
      $result = db_query("SELECT 
                                node.nid AS nid
                            FROM 
                            {node} node
                            INNER JOIN {field_data_field_category} field_data_field_category ON node.nid = field_data_field_category.entity_id AND (field_data_field_category.entity_type = 'node' AND field_data_field_category.deleted = 0)
                            WHERE (( (node.status = '1') AND (node.type IN  ('project')) AND (node.promote = '1') And (field_data_field_category.field_category_tid = :tid) ))
                                ", array(
                                    ':tid' => $category_id,));
    
        //  flatten the nids into an array
        $nids = array();
        foreach ($result as $obj) {
          $nids[] = $obj->nid;
        }    

        //  load all the nodes now
        $nodes = node_load_multiple($nids);
        
         if (!empty($nodes)) {
         
            $output_slide_items = '<ul class="slide_items clearfix" >';
            $output_slide_items_right = '<ul class="slide_items_right clearfix" >';
            
            $node_count = 0;
            
            foreach($nodes as $node_item){
                 
                  $node_url = url("node/".$node_item->nid);
                  $title = $node_item->title;
                  
                  $byline = "";
                  foreach($node_item->field_byline as $byline_item){
                    $byline = $byline_item[0]['value'];
                  }
                  
                  
                  $location = "";
                  foreach($node_item->field_location as $location_item){
                    $location = $location_item[0]['value'];
                  }
                  
                  $country = "";
                  foreach($node_item->field_country as $country_item){
                    $country = $country_item[0]['value'];
                  }
                  
                  $body = "";
                  foreach($node_item->body as $key=>$value) {   
                    $body .= $node_item->body[$key][0]['safe_value'];
                  }
                  
                  //  get the first media asset
                  $media = $node_item->field_media; 
                  
                  $gallery_info = "<ul>";
                  $dots = "<ul>";
                  
                  $iterator = 0;      
                  
                  foreach($media as $media_item){
                      
                        if(!empty($media_item)){
                            
                              foreach($media_item as $current_image) { 
                              
                               //Get File info.
                                if(!empty($current_image)) {
                                    
                                        $file = db_query("Select * from {file_managed} Where fid = :fid",array(
                                        ':fid' => $current_image['fid']
                                        ));
                                    
                                        //$caption_value = "";
                                        $classes = array();
                                
                                        $large_file_src = "";
                                    
                                        foreach ( $file as $file_item ) {
                                            //  if there is no file then skip ahead
                                                if ( ! $file_item->filename ) 
                                                  continue;
                                                  
                                             $large_file_src = image_style_url("large", $file_item->uri);
                                             
                                             if ( $iterator === 0 ) {
                                              $classes[] = "active";
                                              $classes[] = "first";
                                            } 
                                            $classes[] = "item-$iterator";

                                            $gallery_info .= '<li class="' . implode(" ", $classes) . '"><a href="'. url("node/".$node_item->nid) .'" ><img src="' . $large_file_src . '" /></a>';
                                            $gallery_info .= '</li>';
                                            
                                            $dots .= '<li class="' . implode(" ", $classes) . '"><a href="javascript:void(0)" ></a>';
                                            $dots .= '</li>';
                                            
                                            $iterator++;
                                         
                                        }    
                                }
                                    
                            }
                                                    
                            $gallery_info .= "</ul>";
                            $dots .= "</ul>";
                            
                            if($gallery_info == "<ul></ul>") {
                                $gallery_info = "";   
                                $dots = "";
                            }
                        }
                    
                  }
                  
                  //Configure UI
                  
                  $classes = array();
                  
                   if ($node_count === 0 ) {
                       $classes[] = "first";
                   }
                   
                   if($current_node_id == $node_item->nid){
                        $classes[] = "active-project";
                   }
                    
                   $classes[] = "project item-$node_count";
                  
                  $output_slide_items .= '<li class="' . implode(" ", $classes) . '">';
                  
                      
                          $output_slide_items .= '<div class="single_gallery">';
                            $output_slide_items .= $gallery_info;
                          $output_slide_items .= '</div>';
                          $output_slide_items .= '<a class="art" href="' . $node_url . '"> ';
                              $output_slide_items .= '<div class="art">';     
                              $output_slide_items .= '<div class="meta">';
                              $output_slide_items .= '<h4 class="title">' . $title . '</h4>';
                              $output_slide_items .= '<div class="byline">' . $byline . '</div>';
                              $output_slide_items .= '<div class="location">' . $location . '</div>';
                              $output_slide_items .= '<div class="country">' . $country. '</div>';
                              $output_slide_items .= '</div>';
                              $output_slide_items .= '</div>';
                          $output_slide_items .= '</a>'; 
                      
                      
                  $output_slide_items .= '</li>';
                  
                  $output_slide_items_right .= '<li class="' . implode(" ", $classes) . '" >';
                      $output_slide_items_right .= '<div class="body">';
                      $output_slide_items_right .= $body;
                      $output_slide_items_right .= '</div>';
                      $output_slide_items_right .= '<div class="dots">';
                      $output_slide_items_right .= $dots;
                      $output_slide_items_right .= '</div>';
                  $output_slide_items_right .= '</li>';
                  
                  $node_count++;
             }
            
            
            
            
             
             $output_slide_items .= "</ul>";
             $output_slide_items_right .= "</ul>";
             
             if($output_slide_items == '<ul class="slide_items clearfix" ></ul>') $output_slide_items = '';
             if($output_slide_items_right == '<ul class="slide_items_right clearfix" ></ul>') $output_slide_items_right = '';
         
             
         }
        
      
      $page_title = "";
      $page_number = "";
      
      if($category_id == '1'){
        $page_title = "Selected Prorjects";
        $page_number = "02";  
      }else {
        $page_title = "Arts";
        $page_number = "03";    
      }
      
      $vars['page_title'] = $page_title;
      $vars['page_number'] = $page_number;
      
      $vars['slide_items'] = $output_slide_items;
      $vars['slide_items_right'] = $output_slide_items_right;
      
      $vars['theme_hook_suggestions'][] = 'page__'. str_replace('_', '--', $vars['node']->type);
  }
  
}

/**
 * Implementation of preprocess_block().
 */
function blackbeetle_preprocess_block(&$vars) {
  $vars['hook'] = 'block';

  $vars['attributes_array']['id'] = $vars['block_html_id'];

  $vars['title_attributes_array']['class'][] = 'block-title';
  $vars['title_attributes_array']['class'][] = 'clearfix';

  $vars['content_attributes_array']['class'][] = 'block-content';
  $vars['content_attributes_array']['class'][] = 'clearfix';
  if ($vars['block']->module == 'block') {
    $vars['content_attributes_array']['class'][] = 'prose';
  }

  $vars['title'] = !empty($vars['block']->subject) ? $vars['block']->subject : '';

  // In D7 the page content may be served as a block. Replace the generic
  // 'block' class from the page content with a more specific class that can
  // be used to distinguish this block from others.
  // Subthemes can easily override this behavior in an implementation of
  // preprocess_block().
  if ($vars['block']->module === 'system' && $vars['block']->delta === 'main') {
    $vars['classes_array'] = array_diff($vars['classes_array'], array('block'));
    $vars['classes_array'][] = 'block-page-content';
  }
}

/**
 * Implementation of preprocess_node().
 */
function blackbeetle_preprocess_node(&$vars) {
  $vars['hook'] = 'node';

  $vars['attributes_array']['id'] = "node-{$vars['node']->nid}";

  $vars['title_attributes_array']['class'][] = 'node-title';
  $vars['title_attributes_array']['class'][] = 'clearfix';

  $vars['content_attributes_array']['class'][] = 'node-content';
  $vars['content_attributes_array']['class'][] = 'clearfix';
  $vars['content_attributes_array']['class'][] = 'prose';

  if (isset($vars['content']['links'])) {
    $vars['links'] = $vars['content']['links'];
    unset($vars['content']['links']);
  }

  if (isset($vars['content']['comments'])) {
    $vars['post_object']['comments'] = $vars['content']['comments'];
    unset($vars['content']['comments']);
  }

  if ($vars['display_submitted']) {
    $vars['submitted'] = t('Submitted by !username on !datetime', array(
      '!username' => $vars['name'],
      '!datetime' => $vars['date'],
    ));
  }
}

/**
 * Implementation of preprocess_comment().
 */
function blackbeetle_preprocess_comment(&$vars) {
  $vars['hook'] = 'comment';

  $vars['title_attributes_array']['class'][] = 'comment-title';
  $vars['title_attributes_array']['class'][] = 'clearfix';

  $vars['content_attributes_array']['class'][] = 'comment-content';
  $vars['content_attributes_array']['class'][] = 'clearfix';

  $vars['submitted'] = t('Submitted by !username on !datetime', array(
    '!username' => $vars['author'],
    '!datetime' => $vars['created'],
  ));

  if (isset($vars['content']['links'])) {
    $vars['links'] = $vars['content']['links'];
    unset($vars['content']['links']);
  }
}

/**
 * Implementation of preprocess_fieldset().
 */
function blackbeetle_preprocess_fieldset(&$vars) {
  $element = $vars['element'];
  _form_set_class($element, array('form-wrapper'));
  $vars['attributes'] = isset($element['#attributes']) ? $element['#attributes'] : array();
  $vars['attributes']['class'][] = 'fieldset';
  if (!empty($element['#title'])) {
    $vars['attributes']['class'][] = 'titled';
  }
  if (!empty($element['#id'])) {
    $vars['attributes']['id'] = $element['#id'];
  }

  $description = !empty($element['#description']) ? "<div class='description'>{$element['#description']}</div>" : '';
  $children = !empty($element['#children']) ? $element['#children'] : '';
  $value = !empty($element['#value']) ? $element['#value'] : '';
  $vars['content'] = $description . $children . $value;
  $vars['title'] = !empty($element['#title']) ? $element['#title'] : '';
  $vars['hook'] = 'fieldset';
}

/**
 * Implementation of preprocess_field().
 */
function blackbeetle_preprocess_field(&$vars) {
  // Add prose class to long text fields.
  if ($vars['element']['#field_type'] === 'text_with_summary') {
    $vars['classes_array'][] = 'prose';
  }
}

/**
 * Function overrides =================================================
 */

/**
 * Override of theme('textarea').
 * Deprecate misc/textarea.js in favor of using the 'resize' CSS3 property.
 */
function blackbeetle_textarea($variables) {
  $element = $variables['element'];
  $element['#attributes']['name'] = $element['#name'];
  $element['#attributes']['id'] = $element['#id'];
  $element['#attributes']['cols'] = $element['#cols'];
  $element['#attributes']['rows'] = $element['#rows'];
  _form_set_class($element, array('form-textarea'));

  $wrapper_attributes = array(
    'class' => array('form-textarea-wrapper'),
  );

  // Add resizable behavior.
  if (!empty($element['#resizable'])) {
    $wrapper_attributes['class'][] = 'resizable';
  }

  $output = '<div' . drupal_attributes($wrapper_attributes) . '>';
  $output .= '<textarea' . drupal_attributes($element['#attributes']) . '>' . check_plain($element['#value']) . '</textarea>';
  $output .= '</div>';
  return $output;
}

/**
 * Override of theme_pager().
 * Easily one of the most obnoxious theming jobs in Drupal core.
 * Goals: consolidate functionality into less than 5 functions and
 * ensure the markup will not conflict with major other styles
 * (theme_item_list() in particular).
 */
function blackbeetle_pager($vars) {
  $tags = $vars['tags'];
  $element = $vars['element'];
  $parameters = $vars['parameters'];
  $quantity = $vars['quantity'];
  $pager_list = theme('pager_list', $vars);

  $links = array();
  $links['pager-first'] = theme('pager_first', array(
    'text' => (isset($tags[0]) ? $tags[0] : t('First')),
    'element' => $element,
    'parameters' => $parameters
  ));
  $links['pager-previous'] = theme('pager_previous', array(
    'text' => (isset($tags[1]) ? $tags[1] : t('Prev')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters
  ));
  $links['pager-next'] = theme('pager_next', array(
    'text' => (isset($tags[3]) ? $tags[3] : t('Next')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters
  ));
  $links['pager-last'] = theme('pager_last', array(
    'text' => (isset($tags[4]) ? $tags[4] : t('Last')),
    'element' => $element,
    'parameters' => $parameters
  ));
  $links = array_filter($links);
  $pager_links = theme('links', array(
    'links' => $links,
    'attributes' => array('class' => 'links pager pager-links')
  ));
  if ($pager_list) {
    return "<div class='pager clearfix'>$pager_list $pager_links</div>";
  }
}

/**
 * Split out page list generation into its own function.
 */
function blackbeetle_pager_list($vars) {
  $tags = $vars['tags'];
  $element = $vars['element'];
  $parameters = $vars['parameters'];
  $quantity = $vars['quantity'];

  global $pager_page_array, $pager_total;
  if ($pager_total[$element] > 1) {
    // Calculate various markers within this pager piece:
    // Middle is used to "center" pages around the current page.
    $pager_middle = ceil($quantity / 2);
    // current is the page we are currently paged to
    $pager_current = $pager_page_array[$element] + 1;
    // first is the first page listed by this pager piece (re quantity)
    $pager_first = $pager_current - $pager_middle + 1;
    // last is the last page listed by this pager piece (re quantity)
    $pager_last = $pager_current + $quantity - $pager_middle;
    // max is the maximum page number
    $pager_max = $pager_total[$element];
    // End of marker calculations.

    // Prepare for generation loop.
    $i = $pager_first;
    if ($pager_last > $pager_max) {
      // Adjust "center" if at end of query.
      $i = $i + ($pager_max - $pager_last);
      $pager_last = $pager_max;
    }
    if ($i <= 0) {
      // Adjust "center" if at start of query.
      $pager_last = $pager_last + (1 - $i);
      $i = 1;
    }
    // End of generation loop preparation.

    $links = array();

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      // Now generate the actual pager piece.
      for ($i; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $links["$i pager-item"] = theme('pager_previous', array(
            'text' => $i,
            'element' => $element,
            'interval' => ($pager_current - $i),
            'parameters' => $parameters
          ));
        }
        if ($i == $pager_current) {
          $links["$i pager-current"] = array('title' => $i);
        }
        if ($i > $pager_current) {
          $links["$i pager-item"] = theme('pager_next', array(
            'text' => $i,
            'element' => $element,
            'interval' => ($i - $pager_current),
            'parameters' => $parameters
          ));
        }
      }
      return theme('links', array(
        'links' => $links,
        'attributes' => array('class' => 'links pager pager-list')
      ));
    }
  }
  return '';
}

/**
 * Return an array suitable for theme_links() rather than marked up HTML link.
 */
function blackbeetle_pager_link($vars) {
  $text = $vars['text'];
  $page_new = $vars['page_new'];
  $element = $vars['element'];
  $parameters = $vars['parameters'];
  $attributes = $vars['attributes'];

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
    $parameters['page'] = $new_page;
  }

  $query = array();
  if (count($parameters)) {
    $query = drupal_get_query_parameters($parameters, array());
  }
  if ($query_pager = pager_get_query_parameters()) {
    $query = array_merge($query, $query_pager);
  }

  // Set each pager link title
  if (!isset($attributes['title'])) {
    static $titles = NULL;
    if (!isset($titles)) {
      $titles = array(
        t('« first') => t('Go to first page'),
        t('‹ previous') => t('Go to previous page'),
        t('next ›') => t('Go to next page'),
        t('last »') => t('Go to last page'),
      );
    }
    if (isset($titles[$text])) {
      $attributes['title'] = $titles[$text];
    }
    else if (is_numeric($text)) {
      $attributes['title'] = t('Go to page @number', array('@number' => $text));
    }
  }

  return array(
    'title' => $text,
    'href' => $_GET['q'],
    'attributes' => $attributes,
    'query' => count($query) ? $query : NULL,
  );
}

/**
 * Override of theme_views_mini_pager().
 */
function blackbeetle_views_mini_pager($vars) {
  $tags = $vars['tags'];
  $quantity = $vars['quantity'];
  $element = $vars['element'];
  $parameters = $vars['parameters'];

  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  $links = array();
  if ($pager_total[$element] > 1) {
    $links['pager-previous'] = theme('pager_previous', array(
      'text' => (isset($tags[1]) ? $tags[1] : t('Prev')),
      'element' => $element,
      'interval' => 1,
      'parameters' => $parameters
    ));
    $links['pager-current'] = array(
      'title' => t('@current of @max', array(
        '@current' => $pager_current,
        '@max' => $pager_max)
      )
    );
    $links['pager-next'] = theme('pager_next', array(
      'text' => (isset($tags[3]) ? $tags[3] : t('Next')),
      'element' => $element,
      'interval' => 1,
      'parameters' => $parameters
    ));
    return theme('links', array('links' => $links, 'attributes' => array('class' => array('links', 'pager', 'views-mini-pager'))));
  }
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function blackbeetle_menu_local_tasks(&$variables) {
  $output = '';

  if ($primary = drupal_render($variables['primary'])) {
    $output .= '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $output .= '<ul class="tabs primary clearfix">' . $primary . '</ul>';
  }
  if ($secondary = drupal_render($variables['secondary'])) {
    $output .= '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $output .= '<ul class="tabs secondary clearfix">' . $secondary . '</ul>';
  }

  return $output;
}

/**
 * Override or insert variables into theme_menu_local_task().
 */
function blackbeetle_preprocess_menu_local_task(&$variables) {
  $link =& $variables['element']['#link'];

  // If the link does not contain HTML already, check_plain() it now.
  // After we set 'html'=TRUE the link will not be sanitized by l().
  if (empty($link['localized_options']['html'])) {
    $link['title'] = check_plain($link['title']);
  }
  $link['localized_options']['html'] = TRUE;
  $link['title'] = '<span class="tab">' . $link['title'] . '</span>';
}
