# WP Sentry On-Premise :gb:

Plugin for the integration of Sentry in WordPress.

## Configuration

1. Download the code: [wp-Sentry On-Premise in GitHub](https://github.com/ElementSystems/wp-sentry-on-premise/archive/master.zip)
2. Put the folder inside the directory: ``` YOUR-WORDPRESS/PATH/TO/plugins/```
3. Go to the WordPress administration panel in the Plugins section and activate it.
4. In the WordPress administration menu, a new option called ```Sentry Settings ``` appears. Enter in this section to configure.

### Configuration options

Within the ```Sentry Settings``` section we have 4 options:

- **Token** :  The Token of the Api of Sentry server. It is necessary to perform the function tests of the plugin itself. With it we can make sure that the plugin is working correctly.
- **DSN** :  It is the DSN provided by Sentry. It has the following format: ``` https://xxx...@sentry.io/xxx..```
- **Environment** :  It is a parameter that you can configure to identify the procedure of the incidents. For example: "production", "testing", "dev", etc.
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



----


#  WP Sentry On-Premise :de:

Plugin für Sentry Integration in WordPress.

## Konfiguration

1. Laden Sie den Code herunter: [wp-Sentry On-Premise in GitHub](https://github.com/ElementSystems/wp-sentry-on-premise/archive/master.zip)
2. Speichern Sie den Code in das entsprechende Verzeichnis von WordPress: ``` TU-WORDPRESS/PATH/TO/plugins/```
3. Gehen Sie im Bereich Plugins in das WordPress-Administrationsfenster. Durchsuchen Sie das Plugin und aktivieren Sie es.
4. Jetzt sehen Sie in WordPress im Administration Panel eine neue Option mit dem Namen ``` Sentry ``` im `` ` Konfiguration ``` Menü. Geben Sie den Abschnitt ein, um das Plugin zu konfigurieren.

### Konfigurationsoptionen

In ``` Sentry ``` gibt es 4 Optionen:

- **Token** :  Das Token der Sentry-API. Es ist notwendig, die Funktionstests des Plugins selbst ausführen zu können. Damit kann man sicherstellen, dass das Plugin korrekt funktioniert.
- **DSN** :  Der DSN wird von Sentry bereitgestellt. Es hat ein ähnliches Format: ``` https://xxx...@sentry.io/xxx..```
- **Environment** :  Es ist ein Parameter, der dabei behilflich ist, die Fehlerquelle zu identifizieren. Man kann damit in unterschiedlichen Umgebungen arbeiten. Zum Beispiel: "production", "testing", "dev" usw.
- **Certificat CA** : Wenn Sentry unter SSL arbeitet, muss hier das CA-Zertifikat des Sentry-Servers angegeben werden. Sobald diese Option aktiviert ist, kommuniziert die Anwendung mit dem Sentry Server ohne Zertifikat.

### Testing

In der Konfiguration von WP Sentry On-Premise gibt es einen Abschnitt mit dem Namen ``` Connection testing ```. In diesem Abschnitt kann getestet werden, ob eine korrekte Kommunikation mit dem Sentry-Server vorhanden ist und ob der Code korrekt ausgeführt wird.

Dazu klickt man einfach auf den Button ```Run test```.

Anschließend erhalten Sie eine Benachrichtigung darüber, dass die Konfiguration erfolgreich eingerichtet wurde.

Während des Testverfahrens werden 2 Ereignisse (Ausnahmen erstellt - eine mit PHP und eine mit JavaScript. Diese Ereignisse werden an den Sentry-Server gesendet. Wenn Sie diese Ereignisse im Administratorfenster Ihres Sentry-Servers sehen, ist alles korrekt gelaufen.

Im Falle eines Fehlers werden Sie während des Vorgangs benachrichtigt.


## Autor

- *Autor*: ElementSystems.de
- *Autor URI*: [ElementSystems.de](https://www.elementsystems.de)
- *Plugin URL*: [GitHub ElementSystems](https://github.com/ElementSystems/wp-sentry-on-premise)
- *Download Plugin URI*:  [wp-Sentry ESYS in GitHub](https://github.com/ElementSystems/wp-sentry-on-premise/archive/master.zip)


----


#  WP Sentry On-Premise :es:

Plugin para la integración de Sentry en WordPress.

## Configuración

1. Descargar el código: [wp-Sentry On-Premise in GitHub](https://github.com/ElementSystems/wp-sentry-on-premise/archive/master.zip)
2. Colocar el código en el directorio que corresponda de tu WordPress: ``` TU-WORDPRESS/PATH/TO/plugins/```
3. Ir al panel de administración de WordPress, en la sección Plugins. Buscar el plugin y activarlo.
4. Ahora tendremos en el Panel de administración de WordPress una nueva opción llamada ``` Sentry ``` dentro del menú ``` Configuraciones ```. Entra en al sección para configurar el plugin.

### Opciones de configuración

Dentro de ``` Sentry ``` encontramos 4 opciones:

- **Token** :  El Token del API de Sentry. Es necesario para poder ejecutar los test de funcionamiento del propio plugin. Con ello podremos comprobar que el plugin funciona de forma correcta.
- **DSN** :  El DSN nos lo proporciona Sentry. Tiene un formato similar a esto: ``` https://xxx...@sentry.io/xxx..```
- **Environment** :  Es un parámetro que nos ayudara a identificar el origen de la alerta. Es útil si estamos trabajando en diversos entornos. Por ejemplo: "producction", "testing", "dev", etc.
- **Certificat CA** : Si tenemos a Sentry trabajando bajo SSL, aquí debemos poner el Certificado CA del servidor de Sentry. EN caso de poner esta opción Nuestra aplicación se comunicara con el servidor de Sentry sin certificado.

### Testing

Dentro de la configuración de WP Sentry On-Premise tenemos una sección llamada ```Connection testing```. En esta sección podremos probar, si tenemos una correcta comunicación con el servidor Sentry y si el código se esta ejecutando de forma correcta.

Simplemente debemos pulsar sobre el botón ```Run test```.

Si todo fue bien recibirás una respuesta de que todo esta correcto.

El proceso de Testing, crea 2 eventos (excepciones), una generada con PHP y otra con JavaScript. Estos eventos son enviados a servidor de Sentry, si los puedes ver en el panel de administrador de tu servidor Sentry todo habrá ido correctamente.

En caso de que se produzca algún error seras notificado durante el proceso.


## Autor

- *Autor*: ElementSystems.de
- *Autor URI*: [ElementSystems.de](https://www.elementsystems.de)
- *Plugin URL*: [GitHub ElementSystems](https://github.com/ElementSystems/wp-sentry-on-premise)
- *Download Plugin URI*:  [wp-Sentry ESYS in GitHub](https://github.com/ElementSystems/wp-sentry-on-premise/archive/master.zip)

