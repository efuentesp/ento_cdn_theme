<div class="gray-bg">

  <div class="loginColumns animated fadeInDown">
      <div class="row">

          <div class="col-md-6">
              <img class="login_site_logo" src="/sites/default/files/pictures/logo.mpd.png">
          </div>

          <div class="col-md-6">
              <div class="ibox-content">
                <?php print render($page['content']); ?>
                <div class="password_link">
                  <?php print l(t('¿Olvidaste tu contraseña?'), 'user/password'); ?>
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
