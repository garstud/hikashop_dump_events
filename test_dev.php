<?php
/**
 * @package	HikaShop for Joomla!
 * @version	2.3.0
 * @author	garstud
 * @copyright	(C) 2010-2014 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php
/**
 * Plugin pour tester différents evenements de HikaSHop
 * afin de concevoir son propre plugin
 * 
 * Le plugin propose 1 paramètre 'mode Debug' (avec 4 choix cumulables (checkbox)) :
 * 	- simple echo html (basic)
 * 	- message information dans la position 'message' du template Joomla (basic)
 * 	- trace de debug system dans le profil d'information du debogage Joomla (avancé)
 *  - affichage détaillé des variable grace a l'extension JDump (recommandé, le plus complet)
 */
class plgHikashopTest_Dev extends JPlugin
{
	private $debugMode = 0;

	function plgHikashopTest_Dev(&$subject, $config){
		parent::__construct($subject, $config);

		$conf = JFactory::getConfig();
		$isDebugSystem = $conf->get('debug');

		$this->debugMode = $this->params->get('debug_mode',0);
		foreach($this->debugMode as $modeDebug) {
			switch($modeDebug) {
				case "SYST" : if(!$isDebugSystem) {
							$link = "<a href='".JUri::base(true)."/administrator/index.php?option=com_config' target='_blank'>debug 'Syteme' de la configuration Joomla</a>";
							JError::raiseNotice(301, "Vous devez activer le ".$link." pour utiliser le mode de Debug Systeme du plugin 'test_dev' !");
						 }
						 break;
				case "JDUMP" : if(!function_exists("dump")) {
							$link = "<a href='http://extensions.joomla.org/extensions/miscellaneous/development/1509' target='_blank'>extension JDump</a>";
							JError::raiseNotice(302, "L'".$link." n'est pas installée. Le plugin de Test Dev Hikashop ne peut pas fonctionner en mode JDump !");
							$modeDebug = 0;
						 }
						 break;
			}
		}
	}

	function onProductBlocksDisplay(&$product, &$html) {
		$this->_traceDebug(__FUNCTION__, "Affichage Block produit", $product);
		//$html[] = "ajout de code HTML a l'ecran";
	}

	function onProductFormDisplay(&$product, &$html) {
		$this->_traceDebug(__FUNCTION__, "formulaire produit", $product);
		//$html[] = "ajout de code HTML a l'ecran";
	}

	function onProductDisplay(&$product, &$html) {
		$this->_traceDebug(__FUNCTION__, "affichage produit", $product);
		//$html[] = "ajout de code HTML a l'ecran";
	}

	function onBeforeProductListingLoad(&$filters, &$order, &$product, &$select, &$select2, &$a, &$b, &$on) {
		$this->_traceDebug(__FUNCTION__, "Charge une liste de Products : SQL", $select." ".$select2." FROM ".$a.($b?", ":"").$b.$on.$order);
		$this->_traceDebug(__FUNCTION__, "Charge une liste de Products : WHERE", $filters);
	}

	function onAfterOrderProductsListingDisplay(&$order, $order_front_show) {
		$this->_traceDebug(__FUNCTION__, "apres création de commande", $order);
	}

	function onAfterProductUpdate(&$product) {
		$app = JFactory::getApplication();
		// ne pas traiter cette event si on est sur le site (admin uniquement)
		if(!$app->isAdmin())
			return;
		$this->_traceDebug(__FUNCTION__, "apres modification de produit", $order);
	}
	
	function onInitCheckoutStep($layout, &$checkout) {
		$this->_traceDebug(__FUNCTION__, "Lors de l'init du processus d'achat", $layout);
	}

	function onBeforeCheckoutStep($controller, &$go_back, $original_go_back, &$step) {
		$this->_traceDebug(__FUNCTION__, "avant une étape d'achat", $step);
	}

	function onAfterCheckoutStep($controller, &$go_back, $original_go_back, &$step) {
		$this->_traceDebug(__FUNCTION__, "apres une étape d'achat", $step);
	}

	function onCheckoutStepDisplay($layout, &$html, &$checkout) {
		$this->_traceDebug(__FUNCTION__, "affichage d'une étape d'achat", $checkout);
		//$html[] = "ajout de code HTML a l'ecran";
	}

	function onAfterProcessShippings(&$usable_rates){
		$this->_traceDebug(__FUNCTION__, "apres calcul du mode de livraison", $step);
	}
	
	function onAfterCartProductsLoad(&$cart){
		$this->_traceDebug(__FUNCTION__, "apres chargt produit du panier", $cart);
	}

	function onBeforeOrderCreate(&$order,&$send_email){
		$this->_traceDebug(__FUNCTION__, "avant création de commande", $order);
	}

	function onAfterOrderCreate(&$order){
		$this->_traceDebug(__FUNCTION__, "apres création de commande", $order);
	}

	
	/**
	 * Methode d'affichage contextuel du debug
	 */
	function _traceDebug($event, $msg, $var=""){
		$dispClass = $this->params->get('disp_class', 1);
		$msgEvent = "[<b>".($dispClass?__CLASS__."::":"").$event."</b>] ".$msg;
		if(in_array("ECHO", $this->debugMode)) echo "<br />".$msgEvent;
		if(in_array("MSG", $this->debugMode))	JError::raiseNotice(200, $msgEvent);
		if(in_array("SYST", $this->debugMode)) JProfiler::getInstance('Application')->mark($msgEvent);
		if(in_array("JDUMP", $this->debugMode)) dump($var, $msgEvent);
	}
	
	
	
}
