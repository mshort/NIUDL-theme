<?php

/**
 * @file
 * This is the template file for the object page for video
 *
 * Available variables:
 * - $islandora_content: The rendered output of the viewer configured for
 *   this module.
 * - $islandora_dublin_core: The DC datastream object
 * - $dc_array: The DC datastream object values as a sanitized array. This
 *   includes label, value and class name.
 * - $islandora_object_label: The sanitized object label.
 * - $parent_collections: An array containing parent collection(s) info.
 *   Includes collection object, label, url and rendered link.
 *
 * @see template_preprocess_islandora_video()
 * @see theme_islandora_video()
 */

$imgpath = "http://digital.lib.niu.edu/islandora/object/{$object->id}/datastream/TN";
$element = array(
  '#tag' => 'meta',
  '#attributes' => array(
    'property' => 'og:image',
    'content' => $imgpath,
  ),
);
drupal_add_html_head($element, 'og_image');

?>

<div class="islandora-video-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="VideoObject">
  <div class="islandora-video-content-wrapper clearfix">
    <?php if ($islandora_content): ?>
      <div class="islandora-video-content">
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

