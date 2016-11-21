<?php

/**
 * @file
 * This is the template file for the object page for basic image
 *
 * @TODO: add documentation about file and available variables
 */
$imgpath = "http://digital.lib.niu.edu/islandora/object/{$islandora_object->id}/datastream/TN";
$element = array(
  '#tag' => 'meta',
  '#attributes' => array(
    'property' => 'og:image',
    'content' => $imgpath,
  ),
);
drupal_add_html_head($element, 'og_image');

?>

<div class="islandora-basic-image-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="ImageObject">
  <div class="islandora-basic-image-content-wrapper clearfix">
    <?php if (isset($islandora_content)): ?>
      <div class="islandora-basic-image-content">
        <?php print $islandora_content; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<row>
  <div class="col-lg-8 col-md-8 col-sm-8">
    <?php print $metadata; ?>
  </div>
  <div id="services" class="col-lg-4 col-md-4 col-sm-4">
    <h2 class="block-title">Share</h2>
    <?php $block = module_invoke('addthis', 'block_view', 'addthis_block'); ?>
    <?php print render($block['content']); ?>
  </div>
  <?php
    $blockObject = block_load('islandora_blocks', 'citation');
    $block = _block_get_renderable_array(_block_render_blocks(array($blockObject)));
    $output = drupal_render($block);
    print $output
  ?>
</row>
  <div class="col-lg-8 col-md-8 col-sm-8">
    <?php if ($parent_collections): ?>
      <div>
        <h2 class="block-title"><?php print t('In collections'); ?></h2>
        <ul>
          <?php foreach ($parent_collections as $collection): ?>
        <li><?php print l($collection->label, "islandora/object/{$collection->id}"); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
  </div>

