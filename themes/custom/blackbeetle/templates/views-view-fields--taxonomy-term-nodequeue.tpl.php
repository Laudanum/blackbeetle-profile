<?php
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
*
 *      $output .= '<li class="col col_01">';
  *      $output .= '<a class="art" href="' . $node_url . '">';
   *     $output .= '<div class="img">';
    *    $output .= $image_info;
 *       $output .= "</div>";
     *   $output .= '<div class="meta"><h4 class="title">' . $title . '</h4><div class="byline" >' . $byline . '</div>';
      *  $output .= '<div class="location">'.$location . '</div><div class="country">' . $country ;
       * $output .= '</div></div></a></li>';
*
*
 */
//  kpr($fields['view_node']);
//  $nid = $fields['view_node']->raw;
  $node_url = url("node/" . $fields['view_node']->raw);
?>

<!-- template views view fields taxonomy term nodequeue -->
    <a class="art" href="<?=$node_url?>">
      <div class="img">
        <?=$fields['field_media']->content?>
      </div>
      <div class="meta">
        <h4 class="title"><?=$fields['title']->content ?></h4>

        <?php if ( ! empty($fields['field_byline']->content) ):?>
        <div class="byline" ><?=$fields['field_byline']->content ?></div>
        <?php endif; ?>

        <?php if ( ! empty($fields['field_location']->content) ):?>
        <div class="location"><?=$fields['field_location']->content ?></div>
        <?php endif; ?>

        <?php if ( ! empty($fields['field_content']->content) ):?>
        <div class="country"><?=$fields['field_content']->content ?></div>
        <?php endif; ?>
      </div>
    </a>
<!-- end views view fields taxonomy term nodequeue -->
