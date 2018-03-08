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
  TEST
</div>
<form method="POST" action="options.php" style='<?php echo $active_tab == 'display_settings' ? 'display: block;' : 'display: none;'; ?>'>
  <?php
  settings_fields('display_settings');
  do_settings_sections('display_settings');
   ?>
   <label>DSN:</label>
   <div><?php
   if (get_option('dsn') != '') {
       echo "<small style='color:#848484;'>Current DSN.</small>";
   } else {
       echo "<small style='color:#8A0808;'>No stored data</small>";
   } ?></div>
   <input type="text" style="width:100%;"
          name="dsn"
          id="dsn"
          value="<?php echo get_option('dsn'); ?>" />
  <div>
<hr>
  <label>PATH CA:</label>
    <div><?php
  if (get_option('path_ca') != '') {
      echo "<small style='color:#848484;'>Current Path_Ca.</small>";
  } else {
      echo "<small style='color:#8A0808;'>No stored data</small>";
  } ?></div>
  <input type="text" style="width:100%;"
         name="path_ca"
         id="path_ca"
         value="<?php echo get_option('path_ca'); ?>" />
  <hr>
  <label>Activate test</label>
  <?php
  $isChecked = "";
if (get_option('sentry_test')) {
    $isChecked = "checked";
} ?>

  <?php submit_button(); ?>
 </form>

</div>
