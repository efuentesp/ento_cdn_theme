<div class="gray-bg">

  <div class="loginColumns animated fadeInDown">
      <div class="row">

          <div class="col-md-6">
            <img class="login_site_logo" src="/sites/default/files/pictures/logo.mpd.png">
<!--             <a href="<?php print url('<front>'); ?>">
              <img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>">
            </a> -->
          </div>

          <div class="col-md-6">
            <div class="ibox-content">
              <h2 class="title font-bold"><?php print $title; ?></h2>

              <p>
                Si deseas restablecer la contraseña, ingresa el usuario que utilizas para acceder a <?php print $site_name; ?></a>.
              </p>
              <br/>

              <?php print $messages; ?>
              
              <?php print render($page['content']); ?>

              <br/>
              <div class="back_link">
                <a href="<?php print url('<front>'); ?>">&larr; <?php print t('Regresar a '); ?> <?php print $site_name; ?></a>
              </div>
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