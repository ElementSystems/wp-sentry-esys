<?php
    /*
    Plugin Name: Wp Sentry ESYS
    Plugin URI: https://github.com/ElementSystems/wp-sentry-esys
    Description: Activation Sentry in Wordpress.
    Author: ElementSystems.de
    Version: 0.1
    Autor URI: http://www.elementsystems.de
     */

     define('NAME_PLUGIN', "Wp Sentry On-Premise");

    /**
     * Data for the wordpress administration menu
     * @return void
     */
    function sentry_plugin_menu()
    {
        add_options_page(
            'Sentry',                // Title Page
            'Sentry',                // Title menu
            'administrator',         // Rol access
            'sentry_configuration',  // Id page Options
            'SentryOptions'          // function configuration plugin
      );
    }



    /**
     * testing connection plugin with Sentry
     * @param  string $dsn The DSN provided by Sentry
     * @return void
     */
    function testConection($dsn = '')
    {
        $buttonRunTest = '<br><a href="?page=sentry_configuration&testing=on&tab=display_testing" class="button button-primary">Run test</a>';
        // Parse DSN as a test
        try {
            if (empty(Raven_Client::parseDSN($dsn))) {
                exit("<div class='error notice'><span class='dashicons dashicons-no' style='color:red;'></span> ERROR: Missing DSN value</div>"
                  .$buttonRunTest);
            }
        } catch (InvalidArgumentException $ex) {
            exit("<span class='dashicons dashicons-no' style='color:red;'></span> ERROR: There was an error parsing your DSN:<br>  <div class='error notice'>" . $ex->getMessage()."</div>"
            .$buttonRunTest);
        }

        $client = new Raven_Client($dsn, array(
          'trace' => true,
          'curl_method' => 'sync',
          'app_path' => realpath(__DIR__ . '/..'),
          'base_path' => realpath(__DIR__ . '/..'),
      ));

        $config = get_object_vars($client);
        $required_keys = array('server', 'project',  'public_key', 'secret_key');

        echo "<h3 style='color:gray;'>Client configuration: </h3>";
        foreach ($required_keys as $key) {
            if (empty($config[$key])) {
                exit("<div class='error notice'><span class='dashicons dashicons-no' style='color:red;'></span> ERROR: Missing configuration for $key </div>");
            }
            if (is_array($config[$key])) {
                echo "<span class='dashicons dashicons-yes' style='color:green;'></span> $key: <b>[".implode(", ", $config[$key])."]</b> <br>";
            } else {
                $value = ($key == 'secret_key')? '******************************': $config[$key];

                echo "<span class='dashicons dashicons-yes' style='color:green;'></span> $key: <b>$value</b> <br>";
            }
        }
        echo "<br>";
        echo "<h3 style='color:gray;'>Sending a test event:</h3>";

        $ex = new \Exception("Test Exception Connection ".NAME_PLUGIN);
        $event_id = $client->captureException($ex);

        echo "<span class='dashicons dashicons-yes' style='color:green;'></span> event ID: <b>$event_id</b> <br>";

        $last_error = $client->getLastError();
        if (!empty($last_error)) {
            exit("<div class='error notice'><span class='dashicons dashicons-no' style='color:red;'></span> ERROR: There was an error sending the test event: "
            . $last_error. "</div>");
        }

        echo "<br>";
        echo '<h3 style="color:green;">Done!</h3><br>';
    }



    /**
     * We load the template with options and testing.
     */
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
        register_setting('display_settings', '_sentry_dsn', 'stringval');
        register_setting('display_settings', '_sentry_certificate', 'stringval');
    }



    /**
     * Activation and configuration of Sentry
     * @return void
     */
   function sentry()
   {
       require_once 'sentry-php-master/lib/Raven/Autoloader.php';
       Raven_Autoloader::register();

       // We collect the data stored in the database of our wordpress.
       $dsn    = get_option('dsn');
       $certificate = get_option('_sentry_certificate');

       // Creation of the temporary file.
       $temp = tmpfile();
       fwrite($temp, $certificate);
       fseek($temp, 0);

       // We create the Rave client with or without the path of the certificate.
       if ($certificate != '') {
           $client = new Raven_Client($dsn, array( 'ca_cert' => $temp));
       } else {
           $client = new Raven_Client($dsn);
       }

       $error_handler = new Raven_ErrorHandler($client);
       $error_handler->registerExceptionHandler();
       $error_handler->registerErrorHandler();
       $error_handler->registerShutdownFunction();


       fclose($temp);
   }



add_shortcode('sentryTesting', 'sentryTesting');
add_action('admin_menu', 'sentry_plugin_menu');
add_action('admin_init', 'sentry_content_settings');
add_action('init', 'sentry');
