<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup templates
 */
?>
<?php if ($variables['logged_in']): ?>
<div id="wrapper">

  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
          <div class="dropdown profile-element">
            <?php if ($logo): ?>
              <div>
                <img src="<?php print $logo; ?>"
              </div>
            <?php endif; ?>
          </div>
          <?php if ($logo): ?>
            <div class="logo-element">
              <img src="<?php print $logo; ?>"
            </div>
          <?php endif; ?>
        </li>
        <?php if (!empty($primary_nav)): ?>
          <?php print render($primary_nav); ?>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
      <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
          <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          <form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
              <input type="text" placeholder="Buscar..." class="form-control" name="top-search" id="top-search">
            </div>
          </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
          <li>
            <?php if (!empty($secondary_nav)): ?>
              <?php print render($secondary_nav); ?>
            <?php endif; ?>
          </li>
        </ul>
      </nav>
    </div>

    <?php if (!empty($title) or !empty($breadcrumb)): ?>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">

        <?php if (!empty($title)): ?>
          <?php print render($title_prefix); ?>
          <?php if (!empty($title)): ?>
            <h2><?php print $title; ?></h2>
          <?php endif; ?>
          <?php print render($title_suffix); ?>
        <?php endif; ?>
        <!--<ol class="breadcrumb">-->
          <?php if (!empty($breadcrumb)): print $breadcrumb; endif;?>
        <!--</ol>-->
      </div>
      <div class="col-lg-2"></div>
    </div>
    <?php endif; ?>

    <?php if (!empty($page['content'])): ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">
          <div class="ibox">
            <!--<div class="ibox-title"></div>-->
            <div class="ibox-content">
              <?php if (!empty($page['highlighted'])): ?>
                <div class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
              <?php endif; ?>

              <?php print $messages; ?>
              <?php if (!empty($tabs)): ?>
                <?php print render($tabs); ?>
              <?php endif; ?>
              <?php if (!empty($page['help'])): ?>
                <?php print render($page['help']); ?>
              <?php endif; ?>
              <?php if (!empty($action_links)): ?>
                <ul class="action-links"><?php print render($action_links); ?></ul>
              <?php endif; ?>
              <?php print render($page['content']); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($page['footer'])): ?>
      <div class="footer">
        <?php print render($page['footer']); ?>
      </div>
    <?php endif; ?> 
  </div>

</div>
<?php endif; ?>

<?php if (!$variables['logged_in']): ?>
<div class="gray-bg">

  <div class="loginColumns animated fadeInDown">
      <div class="row">

          <div class="col-md-6">
              <img class="login_site_logo" src="/sites/default/files/pictures/logo.mpd.png">
          </div>

          <div class="col-md-6">
              <div class="ibox-content">
                <?php print render($page['content']); ?>
              </div>
          </div>
      </div>
      <br/>
      <br/>
      <br/>
      <hr/>
      <div class="row">
        <?php if (!empty($page['footer'])): ?>
          <div>
            <?php print render($page['footer']); ?>
          </div>
        <?php endif; ?> 
      </div>
  </div>

</div>
<?php endif; ?>