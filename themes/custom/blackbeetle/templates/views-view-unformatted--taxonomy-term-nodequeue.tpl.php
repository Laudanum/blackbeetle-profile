<!-- template views view unformatted taxonomy term nodequeue -->
<?php
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
  <ul class="slide_items clearfix" >
<?php foreach ($rows as $id => $row): ?>
    <li class="col col_01 <?php print $classes_array[$id]; ?>">
      <?php print $row; ?>
    </li>
<?php endforeach; ?>
  </ul>