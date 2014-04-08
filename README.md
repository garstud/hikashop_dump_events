hikashop_debug_events
=====================

Plugin to help developers to debug and understand eCommerce HikaShop plugins events for Joomla (onProductBlocksDisplay, onAfterCheckoutStep ...)


## DEbug plugin installation

- `1` : choose the "Download Zip" button, on the right of this screen
- `2` : install the ZIP of this hikashop plugin on your Joomla Web site
- `3` : set parameters of this plugin
- `4` : activate the plugin
- `5` : and browse to your HikaShop menu to see debug messages

Note : the current event list of this v1.0.0 is not complete!


## Paramétrage du Plugin

Ce plugin HikaShop, une fois installé, propose 2 types de paramètres :
- `1` : choix (cumulables) du type de debug (rendu)
- `2` : l'inclusion du nom du plugin qui affiche la trace de debug

![alt text](/docs/captures/debug0.png "Paramétrage du Plugin HikaShop")

- Echo : affichage basique du msg de debug directement dans l'écran
- Message : utilisation de la file d'attente des messages de Joomla
- debug Système : utilisation du moteur de debug de Joomla
- JDump : utilisation de l'extension de debug additionnelle

Vous pouvez cumuler les choix, toutefois sachez que les choix de debug vont du plus simple (echo) au plus élaboré (JDump, avec affichage du contenu des variables)


### Rendu sur l'écran de la boutique
Les 2 méthodes 'Echo' et 'Message' sont directement intégrées à l'écran de la boutique :

![alt text](/docs/captures/debug1.png "Rendu avec debug simple")


### Rendu debug systeme
La méthode 'debug Systeme' est intégrée dans la position 'debug' du site :

![alt text](/docs/captures/debug2.png "Rendu avec debug systeme")


Note : Pensez à activer le 'debogage systeme' dans la configuration générale de Joomla :

![alt text](/docs/captures/debug2b.png "configuration du debug systeme")


### Rendu JDump
La méthode 'JDump' est la plus avancée. Elle propose une popup dédiée à l'affichage des messages de debug, ainsi que les variables HikaShop associées :

![alt text](/docs/captures/debug3.png "Rendu avec JDump")


Note : il faut installer l'extension JDump (composant + plugin systeme)
