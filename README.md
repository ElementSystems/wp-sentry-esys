# WP Sentry ESYS

Plugin for the integration of Sentry in wordpress.

## Configuration

1. Download the code: [wp-Sentry ESYS in GitHub](https://github.com/ElementSystems/wp-sentry-esys/archive/master.zip)
2. Put the folder inside the directory: ``` YOUR-WORDPRESS/PATH/TO/plugins/```
3. Go to the wordpress administration panel in the Plugins section and activate it.
4. In the wordpress administration menu, a new option called ```Sentry Settings ``` appears. Enter in this section to configure.

### Configuration options

Within the ```Sentry Settings``` section we have 3 options:

- **DSN** :  It is the DSN provided by Sentry. It has the following format: ``` https://xxx...@sentry.io/xxx..```
- **Path CA** : Here we must indicate the PATah of our CA Certificate file.
- **Activate test** : Activating this option generates an error. If everything went well in our Sentry, the generated error should appear with the following legend: ``` Activated the Sentry test in Wordpress. [Sentry ESYS] ```.
This function is simply to verify that we receive exceptions in our Sentry.

### Testing

#### Connection with Sentry
We can receive an Exception to check the Wordpress communication with Sentry by activating the "Activate test" option. This option executes an exption that may be visible in our Sentry.

#### Test Parameters and CA
We can also check if the parameters are coming right to our plugin. We can also view the CA Certification file, so we understand that the path to our CA is correct.

For this we must use the shortcode ```[sentryTesting]```. This shortcode will print the parameters and the CA file.

## Author

- *Author*: ElementSystems.de
- *Autor URI*: [ElementSystems.de](https://www.elementsystems.de)
- *Plugin URL*: [GitHub ElementSystems](https://github.com/ElementSystems/wp-sentry-esys)
- *Download Plugin URI*:  [wp-Sentry ESYS in GitHub](https://github.com/ElementSystems/wp-sentry-esys/archive/master.zip)
