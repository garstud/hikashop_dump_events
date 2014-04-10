HikaShop Dump Events for Joomla Developers
=====================

Plugin to help developers to debug and understand eCommerce HikaShop plugins events for Joomla (onProductBlocksDisplay, onAfterCheckoutStep ...) by dumping events when they are called!

> Joomla developers, did you know! ECommerce shop HikaShop has nearly **100 events plugins!**

> Light core, almost endless possibilities plugins! HikaShop is a successful extension that has successfully implemented the Joomla Framework to become an eCommerce "Extensible" solution! 

For a developer, it is not easy to look at all this mass of information? 
You want to develop a plugin to extend HikaShop? Then the plugin "HikaShop Dump events" is the tool you need!


## Plugin installation

- `1` : choose the "Download Zip" button, on the right of this screen
- `2` : install the ZIP of this hikashop plugin on your Joomla Web site (Joomla 2.5 only, J3.x is comming !)
- `3` : set parameters of this plugin
- `4` : activate the plugin
- `5` : and browse to your HikaShop menu to see debug messages


## Plugin configuration

You can set the way the plugin will dump HikaShop informations :
- `1` : choose 'events types' you want to observe
- `2` : choose 'debug modes' you want to use
- `3` : set the information you want to display

![Parameters of the plugin](/docs/captures/debug0.png "Parameters of the plugin")


### Debug modes
You can choose 1 or more debug modes. The rendering will depend of the choosen mode : from the most basic (echo) to the most advandced (JDump) that will also display datas form events parameter.

- Echo : Write the message in the web page, where the event is called (it can be everywhere !)
- Enqueued Message : write in Joomla messages queue (and display in the Jdoc type=message tag)
- System debug : use the Joomla debug that display information in the 'debug' position
- JDump : use a third-part extension called <a href='http://extensions.joomla.org/extensions/miscellaneous/development/1509' target='_blank'>JDump</a> to popup debug informations in a separate popup


## 4 Rendering Dump Modes

You can choose from 4 Debug modes.
It is possible to add an automatic link to the <a href='http://www.hikashop.com/support/documentation/62-hikashop-developer-documentation.html' target='_blank'>HikaShop Dev documentation</a> within each event. (set the last parameter called 'Link to HikaShop Doc')

### 1- Rendering on the Website screen
The 'Echo' mode writes directly the debug informations in the place they have been called :

![Rendering on the Website screen](/docs/captures/debug1.png "Rendering on the Website screen")

### 2- Rendering on the Message Queue
The 'Enqueued message' mode display all the debug informations in one place, the JDoc type=message dedicated position.


### 3- Rendering in the System Debug
The 'System debug' mode is integrated in the 'debug' position (generally at the bottom of the web page) :

![Rendering in the System Debug](/docs/captures/debug2.png "Rendering in the System Debug")



Note : Remember to activate the 'System Debug' in the **General configuration** of Joomla :

![System Debug in the Joomla General configuration](/docs/captures/debug2b.png "System Debug in the Joomla General configuration")


### 4- Rendering with JDump extension
The JDump solution is the most complete mode. It shows dump event in a popup window and permits to see data content of the event.

`Note :` You need to install the JDump Extension (component + system plugin) and activate it!

```
Warning : this mode is very verbose, it may block your web page with an error :
**"Error 325 (net::ERR_RESPONSE_HEADERS_TOO_BIG)"**
solution : You may select less Events types to display JDump with big amount of data !
```

![Rendering with JDump extension](/docs/captures/debug3.png "Rendering with JDump extension")

## FAQ / Problems & Answers

Q: When using the JDump Debug Mode, i'll get an Error 325 (net::ERR_RESPONSE_HEADERS_TOO_BIG) ?
> JDump permits to dump HikaShop datas (Products, Cart, Orders ...). if you use it on a page with a lot of data, The Server will not be able to transmit them to JDump tree.

`Solution` : try to **de-select some types**, or choose 'No' to the parameter `Display unlimited big data` (and set a lower bytes size limit ; 15 000 bytes per default)

***
Q: how can i use this plugin to make my own plugin ?
> After you have use the Dump Events plugin to determine the events you have to implement, then you just have to copy the code of the /plugins/hikashop/dump_events/dump_events.php file. Make some cleanning operations on the events you don't mind, and go ahead !
