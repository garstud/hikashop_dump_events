HikaShop Dump Events for Joomla Developers
=====================

Plugin to help developers to debug and understand eCommerce HikaShop plugins events for Joomla (onProductBlocksDisplay, onAfterCheckoutStep ...) by dumping events when they are called!


## Plugin installation

- `1` : choose the "Download Zip" button, on the right of this screen
- `2` : install the ZIP of this hikashop plugin on your Joomla Web site
- `3` : set parameters of this plugin
- `4` : activate the plugin
- `5` : and browse to your HikaShop menu to see debug messages


## Plugin configuration

You can set the way the plugin will dump HikaShop informations :
- `1` : choose 'events types' you want to observe
- `2` : choose 'debug modes' you want to use
- `3` : set the information you want to display

![alt text](/docs/captures/debug0.png "Configuration of the plugin")


### Debug modes
- Echo : Write the message in the web page, where the event is called (it can be everywhere !)
- Enqueued Message : write in Joomla messages queue (and display in the Jdoc type=message tag)
- System debug : use the Joomla debug that display information in the 'debug' position
- JDump : use a third-part extension called [JDump](http://extensions.joomla.org/extensions/miscellaneous/development/1509) to popup debug informations in a separate popup

You can choose 1 or more debug modes. The rendering will depend of the choosen mode : from the most basic (echo) to the most advandced (JDump) that will also display datas form events parameter.


## 4 Rendering Dump Modes

You can choose from 4 Debug modes.
It is possible to add an automatic link to the [HikaShop Dev documentation](http://www.hikashop.com/support/documentation/62-hikashop-developer-documentation.html) within each event. (set the last parameter called 'Link to HikaShop Doc')

### 1- Rendering on the Website screen
Les 2 méthodes 'Echo' et 'Message' sont directement intégrées à l'écran de la boutique :

![alt text](/docs/captures/debug1.png "Rendu avec debug simple")

### 2- Rendering on the Website screen
Les 2 méthodes 'Echo' et 'Message' sont directement intégrées à l'écran de la boutique :


### 3- Rendering in the System Debug
La méthode 'debug Systeme' est intégrée dans la position 'debug' du site :

![alt text](/docs/captures/debug2.png "Rendu avec debug systeme")


Note : Pensez à activer le 'debogage systeme' dans la configuration générale de Joomla :

![alt text](/docs/captures/debug2b.png "configuration du debug systeme")


### 4- Rendering with JDump extension
The JDump solution is the most complete mode. It shows dump event in a popup window and permits to see data content of the event.

`Note :` You need to install the JDump Extension (component + system plugin) and activate it!

`Warning :` this mode is very verbose, it may block your web page with a n error :
"Error 325 (net::ERR_RESPONSE_HEADERS_TOO_BIG)".
solution : You may select less Events types to display JDump with big amount of data !

![alt text](/docs/captures/debug3.png "Rendu avec JDump")
