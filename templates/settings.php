<style>
.helpButton {
float: right;
background-color: #58ACFA;
color: #ffffff;
text-align: center;
font-weight: bold;
margin-top: 4px;
cursor: pointer;
border-radius: 50px;
   padding: 2px;
   width: 15px;
   height: 15px;
}

.help-display {
  display: none;
  background-color: #ffffff;
  padding: 5px;
  margin: 5px;
  border-left: 4px solid #58ACFA;
}

.help-display p {
  margin-top: -15px;
  padding-bottom: 20px;
}

.help-display h4 {
  color:#58ACFA;
}

#requestJS {
  clear:both;
  float:left;
  width: 100%;
}
.error-notification {
width: 100%;
  background-color: #ffffff;
  border-left: 5px solid red;
  padding: 3px;
}

</style>

    <script>
    var lastEventJS = '';
    jQuery(function ($) {

        $(".help").click(function () {

          var status = $('#' + $(this).data( "help" ) ).data( "status");

          if( status == 'close') {
            $('#' + $(this).data( "help" )  ).css( "display", 'block' );
            $('#' + $(this).data( "help" ) ).data( "status", 'open');

          } else if (status == 'open') {
                $('#' + $(this).data( "help" )  ).css( "display", 'none' );
                $('#' + $(this).data( "help" ) ).data( "status", 'close');
              };

           });

      });

    </script>

<div class="wrap">
<h2><?php echo NAME_PLUGIN;?></h2>
<p>Options for Sentry configuration in Wordpress.<br>
The Plugin can detect PHP and JavaScript failures.</p>
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

        if (isset($_GET['testing'])) {
            echo "<h2>Test PHP: </h2>";
            testConection(get_option('_sentry_dsn'));
        } else {
            ?>
          <p>- We will make a connection and we will receive some parameters in response. <br>
            - We will send an event (Exception) to Sentry, the event will be reflected in Sentry.</p>
          <p>Press the <b>Run test</b> button to execute the test.</p>
          <br>
          <a href="?page=sentry_configuration&testing=on&tab=display_testing" class="button button-primary">Run test</a>
          <?php
        }
    ?>



</div>
<form method="POST" action="options.php" style='<?php echo $active_tab == 'display_settings' ? 'display: block;' : 'display: none;'; ?>'>
  <?php
  settings_fields('display_settings');
  do_settings_sections('display_settings');
   ?>

   <br><label>Token API Sentry-Server: </label><div class="helpButton help" title="See help: Token" data-help="help-token"  id="help">?</div>
   <div id="help-token" class="help-display"  data-status="close">
   <h4>What is Token?</h4>
    <p>
    It is the necessary keyword to be able to communicate with Sentry Server.
    </p>
   <h4>What are we going to need in this Plugin?</h4>
    <p>
    It is necessary for the plugin testing process (Connection testing).
    We make a query to the Sentry-server API.
    <br>
    In this way we verify that the test created event has been correctly received
    in the sentry server.
    </p>
   <h4>Where can I find the Token of my Sentry API?</h4>
    <p>
    On your Sentry server you will create a section called API where you can
    create and modify the Token.
    </p>
   </div>

   <div>
     <?php
       if (get_option('_sentry_token') == '') {
           echo "<small style='color:#8A0808;'>No stored data</small>";
       }
     ?>
  </div>
   <input type="text" style="width:100%;"
          name="_sentry_token"
          id="token"
          value="<?php echo get_option('_sentry_token'); ?>" />
  <div>

<hr>
<br><label>DSN: </label><div class="helpButton help" title="See help: DSN" data-help="help-dsn"  id="help">?</div>
<div id="help-dsn" class="help-display"  data-status="close">
  <h4>What is DSN?</h4>
   <p>
     The DSN is the identifying url provided by Sentry to connect your wordpress
      with the Sentry server.
   </p>
  <h4>Where can I get my DSN?</h4>
    <p>
    You can find the DSN in your Servero Snetry Projects settings / Client
    Password (DSN).
    </p>
  <h4>What does a DSN look like?</h4>
    <p>
    It has a format similar to this ...
    <br>
    <b style="color:#848484;">https://abc123cde456@YOUR-SENTRY-SERVER-NAME.com/1234</b>
    </p>
</div>
   <div>
     <?php
       if (get_option('_sentry_dsn') == '') {
           echo "<small style='color:#8A0808;'>No stored data</small>";
       }
    ?>
  </div>
   <input type="text" style="width:100%;"
          name="_sentry_dsn"
          id="dsn"
          value="<?php echo get_option('_sentry_dsn'); ?>" />
  <div>

<hr>

  <br><label>CA Certificate: </label><div class="helpButton help" title="See help: CA Certificate" data-help="help-certificate" id="help" >?</div>
   <div id="help-certificate"  class="help-display" data-status="close">
     <h4>What is the CA certificate?</h4>
     <p>
      A CA acts as a trusted third party—trusted both by the subject (owner) of
      the certificate and by the party relying upon the certificate.
     </p>
     <h4>Do I need to fill in this information?</h4>
     <p>
      In the event that your server works with SSL, you will need to obtain the
      CA Certificate from your the SSL Sentry server.
     </p>
     <h4>How can I get the CA certificate?</h4>
     <p>In the event that the Sentry server works with SSL. You should request
       it from your provider or hosting administrator.
     </p>
     <h4>What does a CA certificate look like?</h4>
     <p><span style="color:#848484;">
       -----BEGIN CERTIFICATE-----<br>
      MIIE3DCCA8SgAwIBAgIQPiM0Wu0sClkyMzU5NTlaMGUxCzAJBgw0BAQsFADCBrjELMAkGA1UE<br>
      BhMCVVMxFTAsadasdasdasdwwwdmamreedklasmdklncjknjansjnsjnydGlmaWNhdGlvbiBTZXJ2<br>
      ...<br>
      ...<br>
      ...<br>
      9iDhjr+fCY7lCOiSk3c+SUScf+l5nf9Lr+A4VzQNXxEyEpKpYYiBpR74oPBFWoZxIIWF<br>
      -----END CERTIFICATE-----<br></span>
     </p>
   </div>
    <div>
      <?php
        if (get_option('_sentry_certificate') == '') {
            echo "<small style='color:#8A0808;'>No stored data</small>";
        }
        ?>
  </div>

  <textarea style="width:100%; height:500px; overflow:scroll;" name="_sentry_certificate"
            id="_sentry_certificate">
    <?php echo get_option('_sentry_certificate'); ?>
  </textarea>


  <?php submit_button(); ?>
 </form>

</div>
