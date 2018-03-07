<?php
    /*
    Plugin Name: Wp Sentry ESYS
    Plugin URI: https://github.com/ElementSystems/wp-sentry-esys
    Description: Activation Sentry in Wordpress.
    Author: ElementSystems.de
    Version: 0.1
    Autor URI: http://www.elementsystems.de
     */


    /**
     * Data for the wordpress administration menu
     * @return void
     */
    function sentry_plugin_menu()
    {
        $mode = "";
        if (get_option('sentry_test')) {
            $mode = " In test mode";
        }
        add_menu_page(
            'Sentry Configuration',     // Title Page
            'Sentry Settings <br><span style="color:#F5A9A9">' . $mode . "</span>",          // Title menu
            'administrator',            // Rol access
            'sentry-configuration',    // Id page Options
            'SentrySettings',          // function configuration plugin
            'dashicons-admin-generic'  // Icon menu

      );
    }

    /**
     * Configuration form for the plugin
     * @return void
     */
    function SentrySettings()
    {
        ?>
      <div class="wrap">
        <h2>Sentry Settings</h2>
        <form method="POST" action="options.php">
          <?php
          settings_fields('sentry_group');
        do_settings_sections('sentry_group'); ?>
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
          <input type="checkbox" <?php echo $isChecked; ?>
                  name="sentry_test"
                  id="sentry_test" >
          <?php submit_button(); ?>
         </form>
      </div>
    <?php
    }


    /**
     * Store data
     * @return void
     */
    function sentry_content_settings()
    {
        register_setting('sentry_group', 'dsn', 'stringval');
        register_setting('sentry_group', 'path_ca', 'stringval');
        register_setting('sentry_group', 'sentry_test', 'booleanval');
    }



    /**
     * Activation and configuration of Sentry
     * @return void
     */
   function sentry()
   {
       require_once 'sentry-php-master/lib/Raven/Autoloader.php';
       Raven_Autoloader::register();

       $dsn    = get_option('dsn');
       $pathCa = get_option('path_ca');
       $sentryTest = get_option('sentry_test');

       if ($pathCa != '') {
           $client = new Raven_Client($dsn, array( 'ca_cert' => $pathCA));
       } else {
           $client = new Raven_Client($dsn);
       }

       $error_handler = new Raven_ErrorHandler($client);
       $error_handler->registerExceptionHandler();
       $error_handler->registerErrorHandler();
       $error_handler->registerShutdownFunction();

       if ($sentryTest) {
           $ex = new \Exception("Activated the Sentry test in Wordpress. [Sentry ESYS]");
           $client->captureException($ex);
       }
   }

   /**
    * Testing parameters
    * @return string The Parameters
    */
   function sentryTesting()
   {
       require_once 'sentry-php-master/lib/Raven/Autoloader.php';
       Raven_Autoloader::register();

       $dsn    = get_option('dsn');
       $pathCa = get_option('path_ca');
       $sentryTest = get_option('sentry_test');
       $client = new Raven_Client($dsn, array( 'ca_cert' => $pathCA));
       $error_handler = new Raven_ErrorHandler($client);
       $error_handler->registerExceptionHandler();
       $error_handler->registerErrorHandler();
       $error_handler->registerShutdownFunction();

       $ex = new \Exception("Test Parameters Sentry ESYS");
       $client->captureException($ex);

       return $dsn ." - " ." - ".$pathCa." - ".$sentryTest. " ".$client->captureException($ex);
   }


add_shortcode('sentry', 'sentryTesting');
add_action('admin_menu', 'sentry_plugin_menu');
add_action('admin_init', 'sentry_content_settings');
add_action('init', 'sentry');
