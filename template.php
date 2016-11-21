<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

function niudl_preprocess_page(&$variables) {
        //Removes the "Welcome" message that is caused by lack of content
  if (drupal_is_front_page()) { $variables['title']=""; }
}

//Implements hook_form_FORM_ID_alter to replace Islandora Simple Search button text with icon

function niudl_form_islandora_collection_search_form_alter(&$form, &$form_state) {
  $form['simple']['submit']['#value'] = t('<span class="glyphicon glyphicon-search"></span>');
}

function niudl_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul>' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle disabled';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

// Adds machine name to class of ul for styling

function niudl_menu_tree($variables) {  
  $menu_type = str_replace('menu_tree__menu_', '', $variables['theme_hook_original']);  
  return '<ul class="menu ' . str_replace(array('_', ' '), '-', strtolower($menu_type)) . '-menu">' . $variables['tree'] . '</ul>';
}

//Begin template.php from Nickels and Dimes //


function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

//Overrides Islandora IA book viewer JavaScript. Replacement JS removes info button. //

function niudl_js_alter(&$javascript) { 
  if (isset($javascript[drupal_get_path('module', 'islandora_internet_archive_bookreader') . '/js/islandora_book_reader.js'])) {
    $javascript[drupal_get_path('module', 'islandora_internet_archive_bookreader') . '/js/islandora_book_reader.js']['data'] = drupal_get_path('theme', 'niudl') . '/js/islandora_book_reader.js';
  }
}

?>
