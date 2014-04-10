Plugin Developer : HikaShop Dump Events
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
- JDump : use a third-part extension called Jdump to popup debug informations in a separate popup

Vous pouvez cumuler les choix, toutefois sachez que les choix de debug vont du plus simple (echo) au plus élaboré (JDump, avec affichage du contenu des variables)


## Rendering on the Website screen
Les 2 méthodes 'Echo' et 'Message' sont directement intégrées à l'écran de la boutique :

![alt text](/docs/captures/debug1.png "Rendu avec debug simple")


## Rendering in the System Debug
La méthode 'debug Systeme' est intégrée dans la position 'debug' du site :

![alt text](/docs/captures/debug2.png "Rendu avec debug systeme")


Note : Pensez à activer le 'debogage systeme' dans la configuration générale de Joomla :

![alt text](/docs/captures/debug2b.png "configuration du debug systeme")


## Rendering with JDump extension
La méthode 'JDump' est la plus avancée. Elle propose une popup dédiée à l'affichage des messages de debug, ainsi que les variables HikaShop associées :

![alt text](/docs/captures/debug3.png "Rendu avec JDump")


Note : il faut installer l'extension JDump (composant + plugin systeme)
