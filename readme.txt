=== Error tracking with SENTRY (including on-premise) ===
Contributors: elementsystems
Tags: monitoring, api, sentry, error, tracking
Requires at least: 4.x
Tested up to: 4.9.5
Stable tag: trunk
Requires PHP: 5.2.4
License: GNU General Public License 3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Inofficial plugin for integrate SENTRY error tracking software (including self-hosted version) in WordPress

== Description ==

SENTRY is an open-source error tracking system which can help developers to quickly respond to crashes. This plugin will integrate SENTRY in your WordPress application. You can
either use the official SENTRY server or your own self-hosted version. This plugin allows you to configure CA certifcate (required especially in on-premise environment of SENTRY)
even on hosted versions of your WordPress installation.

This is NOT an official plugin.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Go to the WordPress administration panel in the Plugins section and activate it.
3. In the WordPress administration menu (settings), a new option called ```Sentry Settings``` appears. Enter in this section to configure.

Within the ```Sentry Settings``` section you have four settings:

- **Token** :  The Token of the Api of Sentry server. It is necessary to perform the function tests of the plugin itself. With it we can make sure that the plugin is working correctly.
- **DSN** :  It is the DSN provided by Sentry. It has the following format: ``` https://xxx...@sentry.io/xxx..```
- **Environment** :  It is a parameter that you can configure to identify the procedure of the incidents. For example: "production", "testing", "dev", etc.
- **Certificat CA** : Here you have to paste the text of your Certificate CA (The CA of your servant Sentry). This option will create the Rave Client with or without the ```ca_cert``` attribute, in case of not specifying the CA Certificate, the Rave Client will be created without the ```ca_cert``` attribute.

== Screenshots ==

1. Available settings
2. Connection testing

== Changelog ==

= 1.0.0 =
* Initial Release