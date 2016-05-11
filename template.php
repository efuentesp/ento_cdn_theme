<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

/**
 * Bootstrap theme wrapper function for the primary menu links.
 */
function ento_cdn_menu_tree__primary(&$variables) {
  return $variables['tree'];
}

/**
 * Returns HTML for a menu link and submenu.
 *
 * @param array $variables
 *   An associative array containing:
 *   - element: Structured array data for a menu link.
 *
 * @return string
 *   The constructed HTML.
 *
 * @see theme_menu_link()
 *
 * @ingroup theme_functions
 */
function ento_cdn_menu_link(array $variables) {
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
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      $element['#title'] .= ' <span class="caret"></span>';
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
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

/**
 * Returns HTML for a breadcrumb trail.
 *
 * @param array $variables
 *   An associative array containing:
 *   - breadcrumb: An array containing the breadcrumb links.
 *
 * @return string
 *   The constructed HTML.
 *
 * @see theme_breadcrumb()
 *
 * @ingroup theme_functions
 */
function ento_cdn_breadcrumb($variables) {
  // Use the Path Breadcrumbs theme function if it should be used instead.
  //if (_bootstrap_use_path_breadcrumbs()) {
  //  return path_breadcrumbs_breadcrumb($variables);
  //}

  $output = '';
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    $crumbs = '<ol class="breadcrumb">';
    $array_size = count($breadcrumb);
    $i = 0;
    while ( $i < $array_size) {
      $crumbs .= '<li';
      if ($i+1 == $array_size) {
        $crumbs .= ' class="active"';
      }
      $crumbs .=  '>';
      if ($i+1 == $array_size) {
        $crumbs .= ' <strong>' . $breadcrumb[$i] . '</strong>' . '</li>';
      } else {
      	$crumbs .= $breadcrumb[$i] . '</li>';
      }
      $i++;
    }
    $crumbs .= '</ol>';
    return $crumbs;
  }

  // Determine if we are to display the breadcrumb.
/*  $bootstrap_breadcrumb = bootstrap_setting('breadcrumb');
  if (($bootstrap_breadcrumb == 1 || ($bootstrap_breadcrumb == 2 && arg(0) == 'admin')) && !empty($breadcrumb)) {
    $output = theme('item_list', array(
      'attributes' => array(
        'class' => array('breadcrumb'),
      ),
      'items' => $breadcrumb,
      'type' => 'ol',
    ));
  }
  return $output;*/
}

function ento_cdn_preprocess_page (&$variables) {
  if ($variables['logged_in']) {
    $user = user_load($variables['user']->uid);
    if (isset($user->picture->uri)) {
      $path = $user->picture->uri;
    }
    else {
      $path = variable_get('user_picture_default', '');
    }
    $variables['user_avatar'] = theme_image_style(
              array(
                'style_name' => 'user_picture_side_bar',
                'path' => $path,
                'attributes' => array(
                  'class' => 'img-circle'
                                      ),
                  'width' => NULL,
                  'height' => NULL,
                )
              );
    $variables['user_name'] = $user->name;
    $variables['user_roles'] = implode(', ', array_slice($user->roles, 1));
  }
  else {
    echo '';
  }
}

function ento_cdn_form_alter(&$form, $form_state, $form_id) {
  if ($form_id == 'user_register') {
    drupal_set_title(t('Create new account'));
  }
  elseif ($form_id == 'user_pass') {
    drupal_set_title(t('Solicitar nueva contraseña'));
  }
  elseif ($form_id == 'user_login') {
  drupal_set_title(t('Log in'));
  }
}

function ento_cdn_form_user_login_block_alter(&$form, &$form_state, $form_id) {

  //dpm($form);
  $form['name']['#title'] = Null;
  $form['name']['#attributes'] = array('placeholder' => t('Usuario'));
  $form['pass']['#title'] = Null;
  $form['pass']['#attributes'] = array('placeholder' => t('Contraseña'));
  unset($form['actions']['submit']['#attributes']);
  //$form['actions']['submit']['#attributes']['class'][] = 'btn btn-primary block full-width m-b';
  $form['actions']['submit']['#attributes'] = array('class' => array('block full-width m-b'));
  $form['links']['#weight'] = 10000;

  $markup = l(t('¿Olvidaste tu contraseña?'), 'user/password', array('attributes' => array('title' => t('Solicitar contraseña por correo electrónico.'))));
  if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
    $markup .= ' ' . l(t('Sign up'), 'user/register', array('attributes' => array('title' => t('Create a new user account.'), 'class' => 'register-link')));
  }
  $markup = '<div class="clearfix">' . $markup . '</div>';
  $form['links']['#markup'] = $markup;

}

function ento_cdn_form_user_pass_alter(&$form, &$form_state) {
  $form['name']['#title'] = Null;
  $form['name']['#attributes'] = array('placeholder' => t('Usuario'));
  $form['actions']['submit']['#value'] = t('Enviar Contraseña');

  $form['actions']['submit']['#attributes'] = array('class' => array('block full-width m-b'));
}

function ento_cdn_bootstrap_colorize_text_alter(&$texts) {
  // This matches the exact string: "Log in".
  $texts['matches'][t('Log in')] = 'primary';
  $texts['matches'][t('Enviar Contraseña')] = 'primary';

  // This would also match the string above, however the class returned would
  // also be the one above; "matches" takes precedence over "contains".
  $texts['contains'][t('Unique')] = 'notice';

  // Remove matching for strings that contain "apply":
  unset($texts['contains'][t('Apply')]);

  // Change the class that matches "Rebuild" (originally "warning"):
  $texts['contains'][t('Rebuild')] = 'success';
}
