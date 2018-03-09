<div class="wrap">
<h2>Wp Sentry ESYS</h2>
<p>Options for Sentry configuration in Wordpress.</p>
<?php settings_errors(); ?>

<?php
            if (isset($_GET[ 'tab' ])) {
                $active_tab = $_GET[ 'tab' ];
            } else {
                $active_tab = 'display_settings';
            }
        ?>

<h2 class="nav-tab-wrapper">
    <a href="?page=sentry_configuration&tab=display_settings" class="nav-tab <?php echo $active_tab == 'display_settings' ? 'nav-tab-active' : ''; ?>">Sentry settings</a>
    <a href="?page=sentry_configuration&tab=display_testing" class="nav-tab <?php echo $active_tab == 'display_testing' ? 'nav-tab-active' : ''; ?>">Connection testing</a>
</h2>

<div style='<?php echo $active_tab == 'display_testing' ? 'display: block;' : 'display: none;'; ?>'>


<?php

    if ($_GET['testing'] == 'on') {
        ?>
        <h2>Test result</h2>
        <?php
        $ex = new \Exception("Test ".NAME_PLUGIN);
        testConection(get_option('_sentry_dsn'));
    } else {
        ?>
      <h2>Testing... </h2>
      <p>Press the <b>Run test</b> button to execute the test.</p>
      <?php
    }


?>
<br>
<a href="?page=sentry_configuration&testing=on&tab=display_testing" class="button button-primary">Run test</a>

</div>
<form method="POST" action="options.php" style='<?php echo $active_tab == 'display_settings' ? 'display: block;' : 'display: none;'; ?>'>
  <?php
  settings_fields('display_settings');
  do_settings_sections('display_settings');
   ?>
   <label>DSN:</label>
   <div><?php
   if (get_option('_sentry_dsn') != '') {
       echo "<small style='color:#848484;'>Current DSN.</small>";
   } else {
       echo "<small style='color:#8A0808;'>No stored data</small>";
   } ?></div>
   <input type="text" style="width:100%;"
          name="_sentry_dsn"
          id="dsn"
          value="<?php echo get_option('_sentry_dsn'); ?>" />
  <div>
<hr>
  <label>CA Certificate:</label>
    <div><?php
  if (get_option('_sentry_certificate') != '') {
      echo "<small style='color:#848484;'>Current Certificate CA.</small>";
  } else {
      echo "<small style='color:#8A0808;'>No stored data</small>";
  } ?></div>

  <textarea style="width:100%; height:500px; overflow:scroll;" name="_sentry_certificate"
            id="_sentry_certificate">
    <?php echo get_option('_sentry_certificate'); ?>
  </textarea>


  <?php submit_button(); ?>
 </form>

</div>
