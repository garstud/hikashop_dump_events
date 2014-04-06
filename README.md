hikashop_debug_events
=====================

Plugin to help developpers to debug and understand eCommerce HikaShop plugins events for Joomla (onProductBlocksDisplay, onAfterCheckoutStep ...)

Ce plugin permet de rapidement debogguer les evenements Joomla introduits dans HikaSHop.

## Paramétrage du Plugin

Ce plugin HikaShop, une fois installé, propose 2 types de paramètres :
- `1` : choix (cumulables) du type de debug (rendu)
- `2` : l'inclusion du nom du plugin qui affiche la trace de debug

![alt text](/docs/captures/debug0.png "Paramétrage du Plugin HikaShop")

- Echo : affichage basique du msg de debug directement dans l'écran
- Message : utilisation de la file d'attente des messages de Joomla
- debug Système : utilisation du moteur de debug de Joomla
- JDump : utilisation de l'extension de debug

Vous pouvez cumuler les choix, toutefois sachez que les choix de debug vont du plus simple (echo) au plus élaboré (JDump, avec affichage du contenu des variables)


### Rendu sur l'écran de la boutique
les 2 méthodes Echo et Message sont directement intégrées à l'écran affiché de la boutique :

![alt text](/docs/captures/debug1.png "Rendu avec debug simple")


### Rendu debug systeme
la méthode 'debug Systeme' est intégrée dans la poistion 'debug' du site. Pensez a l'activer dans la configuration générale de Joomla :

![alt text](/docs/captures/debug2.png "Rendu avec debug systeme")


### Rendu JDump
la méthode JDump est la plus avancée. Elle propose une popup dédié à l'affichage des messages de debug, ainsi que les variables HikaShop associées :

![alt text](/docs/captures/debug3.png "Rendu avec JDump")
