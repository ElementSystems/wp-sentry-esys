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
        add_options_page(
            'Sentry',                   // Title Page
            'Sentry Settings',          // Title menu
            'administrator',            // Rol access
            'sentry_configuration',    // Id page Options
            'SentryOptions'          // function configuration plugin



      );
    }


    function SentryOptions()
    {
        include_once('templates/settings.php');
    }


    
    /**
     * Store data
     * @return void
     */
    function sentry_content_settings()
    {
        register_setting('display_settings', 'dsn', 'stringval');
        register_setting('display_settings', 'path_ca', 'stringval');
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
           $client = new Raven_Client($dsn, array( 'ca_cert' => $pathCa));
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
    * Testing parameters with add_shortcode -> [sentryTesting]
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

       $result = "<b>DSN:</b> ".$dsn
                 ."<br> <b>PATH CA:</b> ".$pathCa
                 ."<br> <b>SentryTest:</b> ".$sentryTest
                 ."<br> <b>ID EXCEPTION:</b> ".$client->captureException($ex)
                 ."<br> <b>Exception Message:</b>".$ex->getMessage()
                 ."<br> <b>CA:</b> <br>" . file_get_contents($pathCa);
       return $result;
   }


add_shortcode('sentryTesting', 'sentryTesting');
add_action('admin_menu', 'sentry_plugin_menu');
add_action('admin_init', 'sentry_content_settings');
add_action('init', 'sentry');
