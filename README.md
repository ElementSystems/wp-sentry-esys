# WP Sentry On-Premise

Plugin for the integration of Sentry in wordpress.

## Configuration

1. Download the code: [wp-Sentry On-Premise in GitHub](https://github.com/ElementSystems/wp-sentry-on-premise/archive/master.zip)
2. Put the folder inside the directory: ``` YOUR-WORDPRESS/PATH/TO/plugins/```
3. Go to the wordpress administration panel in the Plugins section and activate it.
4. In the wordpress administration menu, a new option called ```Sentry Settings ``` appears. Enter in this section to configure.

### Configuration options

Within the ```Sentry Settings``` section we have 3 options:

- **Token** :  The Token of the Api of Sentry server. It is necessary to perform the function tests of the plugin itself. With it we can make sure that the plugin is working correctly.
- **DSN** :  It is the DSN provided by Sentry. It has the following format: ``` https://xxx...@sentry.io/xxx..```
- **Certificat CA** : Here you have to paste the text of your Certificate CA (The CA of your servant Sentry). This option will create the Rave Client with or without the ```ca_cert``` attribute, in case of not specifying the CA Certificate, the Rave Client will be created without the ```ca_cert``` attribute.


### Testing

In the configuration of WP Sentry On-Premise there is a section called ```Connection testing```. Within this area, conduct a connectivity and operation test.

Within the section, you must simply press the ```Run test``` button.

If all goes well, you will receive the answer from a connection to your Sentry Server.

The process sends two events (exceptions), one generated with PHP and another with JavaScript. The events are sent to Sentry Server and the test verifies that they have been received correctly.

In case of error during the test, you will receive information about the error that has occurred.


## Author

- *Author*: ElementSystems.de
- *Autor URI*: [ElementSystems.de](https://www.elementsystems.de)
- *Plugin URL*: [GitHub ElementSystems](https://github.com/ElementSystems/wp-sentry-on-premise)
- *Download Plugin URI*:  [wp-Sentry ESYS in GitHub](https://github.com/ElementSystems/wp-sentry-on-premise/archive/master.zip)
