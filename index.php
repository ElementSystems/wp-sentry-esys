<?php
    /*
    Plugin Name: WP Sentry On-Premise
    Plugin URI: https://github.com/ElementSystems/wp-sentry-on-premise
    Description: Activation Sentry in Wordpress.
    Author: ElementSystems.de
    Version: 0.1
    Autor URI: http://www.elementsystems.de
     */

     define('NAME_PLUGIN', "WP Sentry On-Premise");
     define('PATH_CERTIFICATE', __DIR__ . '/../../../wp-includes/certificates/ce-sentry.ca.pem');



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
        $buttonRunTest = '<br><p>The test for <b>PHP</b> has produced an <b style="color:red;">error</b>.<br>
                                  The test for <b>JavaScript</b> <b style="color:red;">could not be done</b>.</p>
                                  <a href="?page=sentry_configuration&testing=on&tab=display_testing" class="button button-primary">Run test</a>';

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
        $certificate = get_option('_sentry_certificate');


        $client = new Raven_Client($dsn, array(
                  'trace' => true,
                  'curl_method' => 'sync',
                  'app_path' => realpath(__DIR__ . '/..'),
                  'base_path' => realpath(__DIR__ . '/..'),
                  'ca_cert' => PATH_CERTIFICATE
              ));

        $config = get_object_vars($client);
        $required_keys = array('server', 'project',  'public_key', 'secret_key');

        echo "<h3 style='color:gray;'>Client configuration: </h3>";
        foreach ($required_keys as $key) {
            if (empty($config[$key])) {
                exit("<div class='error notice'><span class='dashicons dashicons-no' style='color:red;'></span> ERROR: Missing configuration for $key </div>"
                    .$buttonRunTest);
            }
            if (is_array($config[$key])) {
                echo "<span class='dashicons dashicons-yes' style='color:green;'></span> $key: <b>[".implode(", ", $config[$key])."]</b> <br>";
            } else {
                $stars = str_repeat('*', count($config[$key]));
                $value = ($key == 'secret_key')? $stars : $config[$key];

                echo "<span class='dashicons dashicons-yes' style='color:green;'></span> $key: <b>$value</b> <br>";
            }
        }
        echo "<br>";
        echo "<h3 style='color:gray;'>Sending a test event:</h3>";

        $ex = new \Exception("Test [PHP] Exception Connection ".NAME_PLUGIN);
        $event_id = $client->captureException($ex);

        echo "<span class='dashicons dashicons-yes' style='color:green;'></span>Created the event ID: <b>$event_id</b> <br>";

        $last_error = $client->getLastError();
        if (!empty($last_error)) {
            exit("<div class='error notice'><span class='dashicons dashicons-no' style='color:red;'></span> ERROR: There was an error sending the test event: "
            . $last_error. "</div>".$buttonRunTest);
        }

        // Get nameOrganitation and Project
        $result_organitation = json_decode(checkReceipt('/api/0/organizations/'));
        $result_project = json_decode(checkReceipt('/api/0/projects/'));

        $slug_organitation = $result_organitation[0]->slug;
        $slug_project = $result_project[0]->slug;

        $result = json_decode(checkReceipt('/api/0/projects/'.$slug_organitation.'/'.$slug_project.'/events/'));


        if ($result[0]->eventID == $event_id) {
            echo "<span class='dashicons dashicons-yes' style='color:green;'></span> The event ID: <b>$event_id</b> has been successfully sent to Sentry-server.  <br>";
        } else {
            exit("<div class='error notice'><span class='dashicons dashicons-no' style='color:red;'></span> ERROR: The event <b>$event_id</b>  has not been received by Sentry-server. "
          . $last_error. "</div>".$buttonRunTest);
        }


        echo '<h3 style="color:green;">Test Sentry-PHP Done!</h3><br>';
        echo "<hr><div id='requestJS' ><h2>Test JavaScript: </h2></div>";
        completTestJS();
    }



    /**
     * We generate an error and check if the error was generated and if it has
     * been received in Sentry server.
     * @return void
     */
    function completTestJS()
    {
        ?>
        <script>
      (function($) {

            // We provoke an exception to try
            try {
              throw new Error('Test [JavaScript] Excpetion <?php echo NAME_PLUGIN; ?>');
               } catch (e) {
              Raven.captureException(e);
              }
          lastEventJS = Raven.lastEventId();
          // We check if the error has been generated.
          if(lastEventJS == null ) {
            $('#requestJS').append('<span class=\"error-notification\"><span class=\"dashicons dashicons-yes\" style=\"color:red;\"></span>  ERROR: The event could not be executed. The error occurred when creating the event. Event ID: <b>' +  lastEventJS + '</b></span>');
            $('#requestJS').append('<br><p>The test for <b>JavaScript</b> has produced an <b style="color:red;">error</b>.</p><a href="?page=sentry_configuration&testing=on&tab=display_testing" class="button button-primary">Run test</a>');
          } else {
            $('#requestJS').append('<span class=\"dashicons dashicons-yes\" style=\"color:green;\"></span>Created the event ID: <b><span id=\"lastEventID\">' +  lastEventJS + '</span></b> <br>');
          }
          // We save the ID of the event to check if the Sentry Server has received it.



            var data = {
              'action': 'my_action',
              'lastEventIdJS': lastEventJS
            };
$('#requestJS').append('<div id=\"loader_gif\" style="width=100%; text-align:centre;"><img style="width: 20px; height:20px;" src=\"/wordpress/wp-content/plugins/wp-sentry-on-premise/throbber_12.gif\"></div>');
              jQuery.post(ajaxurl, data, function(response) {

                if(response == 1) {
                  $('#requestJS').append('<span class=\"dashicons dashicons-yes\" style=\"color:green;\"></span>The event ID: <b><span id=\"lastEventID\">' +  lastEventJS + '</span></b> has been successfully sent to Sentry-server. <br>');
                  $('#requestJS').append('<h3 style="color:green;">Test Sentry-JavaScript Done!</h3><br><a href="?page=sentry_configuration&testing=on&tab=display_testing" class="button button-primary">Run test</a>');

                } else {
                  $('#requestJS').append('<div class=\"error notice\"><span class=\"dashicons dashicons-no\" style=\"color:red;\"></span>event ID: <b><span id=\"lastEventID\">' +  lastEventJS + '</span></b> has not been received by Sentry-server.  </div>');
                  $('#requestJS').append('<br><p>The test for <b>JavaScript</b> has produced an <b style="color:red;">error</b>.</p><a href=\"?page=sentry_configuration&testing=on&tab=display_testing\" class=\"button button-primary\">Run test</a>');

                }
                $('#loader_gif').html('');
              });

    })(jQuery);
    </script>
    <?php
    }



    /**
     * We check if we have received the latest JavaScript event or not.
     * @return void
     */
    function my_action()
    {
        $lastEventIdJS = $_POST['lastEventIdJS'];

        // Get nameOrganitation and Project
        $result_organitation = json_decode(checkReceipt('/api/0/organizations/'));
        $result_project = json_decode(checkReceipt('/api/0/projects/'));

        $slug_organitation = $result_organitation[0]->slug;
        $slug_project = $result_project[0]->slug;
        $result = json_decode(checkReceipt('/api/0/projects/'.$slug_organitation.'/'.$slug_project.'/events/'));
        $result_query =  ($result[0]->eventID == $lastEventIdJS)? 1:0;

        wp_die($result_query); // this is required to terminate immediately and return a proper response
    }



    /**
     * Action cURL PHP
     * @param  string $url Destination
     * @return string   Result of the curl
     */
    function checkReceipt($url)
    {
        $host = getHost();
        $_url = $host.$url;

        $headers = array(
            'Content-Type:application/json',
            'Authorization: Bearer '.get_option('_sentry_token'), //'a69385b07bed49189b8b06d2a509fb9895e964dc811c42baaf1febe729cf8598' // <---
            );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close($ch);


        return $result;
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
        register_setting('display_settings', '_sentry_token', 'stringval');
        register_setting('display_settings', '_sentry_certificate', 'stringval');

        $certificate = get_option('_sentry_certificate');

        $file = fopen(PATH_CERTIFICATE, "w+");
        fwrite($file, $certificate);
        fclose($file);
    }



    /**
     * Activation and configuration of Sentry
     * @return voidcheckLastIdInJS
     */
   function sentry()
   {
       require_once 'sentry-php-master/lib/Raven/Autoloader.php';
       Raven_Autoloader::register();

       // We collect the data stored in the database of our wordpress.
       $dsn    = get_option('dsn');
       $certificate = get_option('_sentry_certificate');



       // We create the Rave client with or without the path of the certificate.
       if ($certificate != '') {
           $client = new Raven_Client($dsn, array( 'ca_cert' => PATH_CERTIFICATE));
       } else {
           $client = new Raven_Client($dsn);
       }

       $error_handler = new Raven_ErrorHandler($client);
       $error_handler->registerExceptionHandler();
       $error_handler->registerErrorHandler();
       $error_handler->registerShutdownFunction();
   }



   /**
    * Integrate Sentry in the head
    * @return void
    */
   function sentryJS()
   {
       $value_dsn_public = dsn_public();

       echo "<script src='https://cdn.ravenjs.com/3.23.1/raven.min.js' crossorigin='anonymous'></script>
            <script>
            try {
                Raven.config('".$value_dsn_public."').install();
            }
            catch(e) {
            }

            </script>";
   }


   function dsn_public()
   {
       $value_dsn        = get_option('_sentry_dsn');
       $value_dsn_split  = preg_split("/[:]+/", $value_dsn);
       $value_dsn_public = $value_dsn_split[0].":".$value_dsn_split[1]. preg_replace('/([^\s]+@)/', '@', $value_dsn_split[2]);

       return $value_dsn_public;
   }

   function getHost()
   {
       $value_dsn        = get_option('_sentry_dsn');
       $value_dsn_split  =  preg_split("/[:]+/", $value_dsn);
       $host = preg_replace('/([^\s]+@)/', '', $value_dsn_split[2]);

       $host_clean = preg_replace('/(\/+[^\s]*)/', '', $host);

       $host = $value_dsn_split[0]."://".$host_clean;
       return $host;
   }

// Hook Admin menu Plugin
add_action('admin_menu', 'sentry_plugin_menu');

// Hook Admin save data in DB
add_action('admin_init', 'sentry_content_settings');

// Hook PHP-Sentry in throughout the application
add_action('init', 'sentry');

// Hook JavaScript-Sentry in Head Frontend and Backend
add_action('wp_head', 'sentryJS');
add_action('admin_head', 'sentryJS');

// Hook testing Javascript
add_action('wp_ajax_my_action', 'my_action');
