hikashop_debug_events
=====================

Plugin to help developers to debug and understand eCommerce HikaShop plugins events for Joomla (onProductBlocksDisplay, onAfterCheckoutStep ...)

Ce plugin permet de rapidement debogguer les evenements Joomla introduits dans HikaSHop.


## Installation de ce plugin

- `1` : Cliquez sur le bouton "Download Zip", à droite de cet écran
- `2` : installez le Zip de ce plugin HikaShop sur votre site Joomla
- `3` : réglez les paramètres du plugin
- `4` : activez le plugin
- `5` : puis naviguez sur votre boutique HikaShop pour voir les messages de debugs s'afficher

Note : la liste des evenements de cette v1.0.0 n'est pas exhaustive !


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
