<?php
/**
 * @package	HikaShop for Joomla!
 * @version	2.3.0
 * @author	garstud
 * @copyright	(C) 2010-2014 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Plugin to check HikaShop plugins events
 * to prepare your own HikaShop plugin
 * 
 * Le plugin propose 1 paramètre 'mode Debug' (avec 4 choix cumulables (checkbox)) :
 * 	- simple echo html (basic)
 * 	- message information dans la position 'message' du template Joomla (basic)
 * 	- trace de debug system dans le profil d'information du debogage Joomla (avancé)
 *  - affichage détaillé des variable grace a l'extension JDump (recommandé, le plus complet)
 * 
 * For more informations, see : 
 * 		http://www.hikashop.com/support/documentation/62-hikashop-developer-documentation.html
 */

/**
 * TODO RAF
 * 	- ajouter des fichiers de lang FR et GB (params, err config msg, debug msg ...)
 * 
 * TODO : parler des params &$do pour valider la continuité ou pas !
 * 
 * TODO : trigger puissant sur les vues et extradata ?
 * dasn le helper Hikashop : hikashop view
 * trigger_view a false
 * 		-> true
 * 		si display()
 * 				onHikashopAfterDiplayView et onHikashop...DisplayView
 */		
 
class plgHikashopDump_Events extends JPlugin
{
	private $context = "dump_events";
	private $hikaDocRootUrl = "http://www.hikashop.com/support/documentation/62-hikashop-developer-documentation.html#";
	private $debugEvents = null;
	private $debugModes = null;
	private $Events = null;

	function plgHikashopDump_Events(&$subject, $config){
		parent::__construct($subject, $config);

		$app = JFactory::getApplication();
		$conf = JFactory::getConfig();
		$isDebugSystem = $conf->get('debug');

		$this->debugEvents = $this->params->get('debug_events', null);
		$this->debugModes = $this->params->get('debug_modes', null);
		foreach($this->debugModes as $modeDebug) {
			switch($modeDebug) {
				case "SYST" : if(!$isDebugSystem) {
							if($app->isAdmin()) $preUrl = JUri::base(true);	else $preUrl = JUri::base(true)."/administrator";
							$link = "<a href='".$preUrl."/index.php?option=com_config' target='_blank'>'Debug System' in the Joomla global configuration</a>";
							$app->enqueueMessage("Warning : You must activate the ".$link." to see the 'Debug System' traces of the '".$this->context."' plugin!", 'notice');
						 }
						 break;
				case "JDUMP" : if(!function_exists("dump")) {
							$link = "<a href='http://extensions.joomla.org/extensions/miscellaneous/development/1509' target='_blank'>JDump extension</a>";
							$app->enqueueMessage("Warning : ".$link." is not installed/activated. The '".$this->context."' plugin could not work in 'JDump mode' without it!", 'notice');
							$modeDebug = 0;
						 }
						 break;
			}
		}
		if(in_array("QMSG", $this->debugModes)) $app->enqueueMessage("Debug mode : Enqueued message");
		
		if(in_array("JDUMP", $this->debugModes)) {
			$dispData = $this->params->get('disp_jdumpdata', 0);
			$limitSize = $this->params->get('size_jdumpdata', 500);
			if($dispData) 
				$firstmsg = " : dumping HikaShop events data";
			else
				$firstmsg = " : Big data (> ".$limitSize." bytes) not sent, see Plugin parameter to display big data";
			if(function_exists("dump")) dumpMessage("<font size='+1'>".$this->context."</font>".$firstmsg);
		}
		
		
/*
		//introspection des methodes
		$class = new ReflectionClass('plgHikashopDump_Events');
		$methods = $class->getMethods();
		//dump($methods, "Reflection getMethods");
		$parameters = $class->getMethod($methods[0]->name)->getParameters();
		//dump($parameters, "Reflection getParameters 0");
		$endLine = $class->getEndLine();
		dump($endLine, "Reflection getEndLine");
		//$traits = $class->getTraits(); //PHP 5.4 !
		//dump($traits, "Reflection getTraits");
*/

		$tEvents["product"][0] = "onBeforeProductCreate";
		$tEvents["product"][1] = "onAfterProductCreate";
		$tEvents["product"][2] = "onBeforeProductUpdate";
		$tEvents["product"][3] = "onAfterProductUpdate";
		$tEvents["product"][4] = "onBeforeProductCopy";
		$tEvents["product"][5] = "onAfterProductCopy";
		$tEvents["product"][6] = "onBeforeProductDelete";
		$tEvents["product"][7] = "onAfterProductDelete";
		$tEvents["product"][8] = "onBeforeProductListingLoad";
		$tEvents["product"][9] = "onBeforeProductExport";

		$tEvents["category"][0] = "onBeforeCategoryCreate";
		$tEvents["category"][1] = "onAfterCategoryCreate";
		$tEvents["category"][2] = "onBeforeCategoryUpdate";
		$tEvents["category"][3] = "onAfterCategoryUpdate";
		$tEvents["category"][4] = "onBeforeCategoryDelete";
		$tEvents["category"][5] = "onAfterCategoryDelete";
		$tEvents["category"][6] = "onBeforeCategoryListingLoad";

		$tEvents["order"][0] = "onBeforeOrderCreate";
		$tEvents["order"][1] = "onAfterOrderCreate";
		$tEvents["order"][2] = "onBeforeOrderUpdate";
		$tEvents["order"][3] = "onAfterOrderUpdate";
		$tEvents["order"][4] = "onAfterOrderConfirm";
		$tEvents["order"][5] = "onAfterOrderDelete";
		$tEvents["order"][6] = "onHistoryDisplay";
		$tEvents["order"][7] = "onBeforeOrderExport";

		$tEvents["address"][0] = "onBeforeAddressCreate";
		$tEvents["address"][1] = "onAfterAddressCreate";
		$tEvents["address"][2] = "onBeforeAddressUpdate";
		$tEvents["address"][3] = "onAfterAddressUpdate";
		$tEvents["address"][4] = "onBeforeAddressDelete";
		$tEvents["address"][5] = "onAfterAddressDelete";

		$tEvents["shipping"][0] = "onShippingDisplay";
		$tEvents["shipping"][1] = "onShippingSave";
		$tEvents["shipping"][2] = "onShippingConfiguration";
		$tEvents["shipping"][3] = "onShippingConfigurationSave";
		$tEvents["shipping"][4] = "shippingMethods";
		$tEvents["shipping"][5] = "onAfterProcessShippings";

		$tEvents["payment"][0] = "onPaymentDisplay";
		$tEvents["payment"][1] = "onPaymentSave";
		$tEvents["payment"][2] = "onPaymentConfiguration";
		$tEvents["payment"][3] = "onPaymentConfigurationSave";
		$tEvents["payment"][4] = "onAfterOrderConfirm";
		$tEvents["payment"][5] = "onPaymentNotification";

		$tEvents["vote"][0] = "onBeforeVoteCreate";
		$tEvents["vote"][1] = "onAfterVoteCreate";
		$tEvents["vote"][2] = "onBeforeVoteUpdate";
		$tEvents["vote"][3] = "onAfterVoteUpdate";
		$tEvents["vote"][4] = "onBeforeVoteDelete";
		$tEvents["vote"][5] = "onAfterVoteDelete";

		$tEvents["cart"][0] = "onBeforeCartUpdate";
		$tEvents["cart"][1] = "onAfterCartUpdate";
		$tEvents["cart"][2] = "onAfterCartProductsLoad";
		$tEvents["cart"][3] = "onAfterCartShippingLoad";

		$tEvents["checkout"][0] = "onCheckoutStepList";
		$tEvents["checkout"][1] = "onBeforeCheckoutStep";
		$tEvents["checkout"][2] = "onAfterCheckoutStep";
		$tEvents["checkout"][3] = "onCheckoutStepDisplay";

		$tEvents["display"][0] = "onDisplayImport";
		$tEvents["display"][1] = "onProductFormDisplay";
		$tEvents["display"][2] = "onProductDisplay";
		$tEvents["display"][3] = "onProductBlocksDisplay";
		$tEvents["display"][4] = "onAfterOrderProductsListingDisplay";
		$tEvents["display"][5] = "onHikashopBeforeDisplayView";
		$tEvents["display"][6] = "onHikashopAfterDisplayView";

		$tEvents["coupon"][0] = "onBeforeCouponLoad";
		$tEvents["coupon"][1] = "onBeforeCouponCheck";
		$tEvents["coupon"][2] = "onAfterCouponCheck";

		$tEvents["discount"][0] = "onBeforeDiscountCreate";
		$tEvents["discount"][1] = "onAfterDiscountCreate";
		$tEvents["discount"][2] = "onBeforeDiscountUpdate";
		$tEvents["discount"][3] = "onAfterDiscountUpdate";
		$tEvents["discount"][4] = "onBeforeDiscountDelete";
		$tEvents["discount"][5] = "onAfterDiscountDelete";

		$tEvents["user"][0] = "onBeforeUserCreate";
		$tEvents["user"][1] = "onAfterUserCreate";
		$tEvents["user"][2] = "onBeforeUserUpdate";
		$tEvents["user"][3] = "onAfterUserUpdate";
		$tEvents["user"][4] = "onBeforeUserDelete";
		$tEvents["user"][5] = "onAfterUserDelete";
		$tEvents["user"][6] = "onUserAccountDisplay";

		$tEvents["filter"][0] = "onFilterDisplay";
		$tEvents["filter"][1] = "onFilterAdd";
		$tEvents["filter"][2] = "onFilterToLoad";
		$tEvents["filter"][3] = "onFilterTypeDisplay";

		$tEvents["fields"][0] = "onFieldDateDisplay";
		$tEvents["fields"][1] = "onFieldDateCheckSelect";
		$tEvents["fields"][2] = "onFieldsLoad";

		$tEvents["other"][0] = "onBeforeCalculateProductPriceForQuantityInOrder";
		$tEvents["other"][1] = "onAfterCalculateProductPriceForQuantityInOrder";
		$tEvents["other"][2] = "onBeforeCalculateProductPriceForQuantity";
		$tEvents["other"][3] = "onAfterCalculateProductPriceForQuantity";
		$tEvents["other"][4] = "onBeforeDownloadFile";
		$tEvents["other"][5] = "onBeforeMailPrepare";
		$tEvents["other"][6] = "onBeforeMailSend";
		$tEvents["other"][7] = "onBeforeSendContactRequest";
		$tEvents["other"][8] = "onViewsListingFilter";
		$tEvents["other"][9] = "onHikashopCronTrigger";
		$tEvents["other"][10] = "onCheckSubscription";

//dump($tEvents, "events list");

		//init event classification
		$this->Events = array();
		$nb_event = 0;
		foreach($tEvents as $type => $eventInd) {
			foreach($eventInd as $eventName) {	
				$this->Events[$eventName] 	= new CheckHikaEvent($eventName, $type);
				$nb_event++;
			}
		}
//dump($nb_event, "nb total events");
		
/*foreach($this->Events as $event) { //DEBUG
	dump($event->__toString(), "Event stored");
}*/
	} //end constructor

	/* ============ Orders events ================ */
	function onBeforeOrderCreate(&$order, &$do){
		$this->_traceDebug(__FUNCTION__, "Before creating a new Order", $order);
	}

	function onAfterOrderCreate(&$order, &$send_email){
		$this->_traceDebug(__FUNCTION__, "apres création de commande", $order);
	}

	function onBeforeOrderUpdate(&$order, &$do){
		$this->_traceDebug(__FUNCTION__, "avant modification de commande", $order);
	}

	function onAfterOrderUpdate(&$order, &$send_email){
		$this->_traceDebug(__FUNCTION__, "apres modification de commande", $order);
	}

	function onAfterOrderConfirm(&$order, &$methods, $method_id){
		$this->_traceDebug(__FUNCTION__, "apres confirmation de commande", $order);
	}

	function onAfterOrderDelete($elements){
		$this->_traceDebug(__FUNCTION__, "apres suppression de commande", $elements);
	}

	function onHistoryDisplay(&$history){
		$this->_traceDebug(__FUNCTION__, "lors de l'affichage de l'historique de commande", $history);
	}

	function onBeforeOrderExport(&$rows, &$current){
		$this->_traceDebug(__FUNCTION__, "avant export des commandes", $current);
	}

	/* ============ Product events ================ */
	function onBeforeProductCreate(&$element,&$do) {
		$this->_traceDebug(__FUNCTION__, "avant creation de produit", $element);
	}
	
	function onAfterProductCreate(&$element) {
		$this->_traceDebug(__FUNCTION__, "apres creation de produit", $element);
	}
	
	function onBeforeProductUpdate(&$element,&$do) {
		$this->_traceDebug(__FUNCTION__, "avant modification de produit", $element);
	}

	function onAfterProductUpdate(&$element) {
		$app = JFactory::getApplication();
		// ne pas traiter cette event si on est sur le site (admin uniquement)
		if(!$app->isAdmin())
			return;
		$this->_traceDebug(__FUNCTION__, "apres modification de produit", $order);
	}

	function onBeforeProductCopy(&$template,&$product,&$do) {
		$this->_traceDebug(__FUNCTION__, "avant copie de produit", $product);
	}
	
	function onAfterProductCopy(&$template,&$product) {
		$this->_traceDebug(__FUNCTION__, "apres copie de produit", $product);
	}
	
	function onBeforeProductDelete(&$ids,&$do) {
		$this->_traceDebug(__FUNCTION__, "avant suppression de produit", $ids);
	}
	
	function onAfterProductDelete(&$ids) {
		$this->_traceDebug(__FUNCTION__, "apres suppression de produit", $ids);
	}
	
	function onBeforeProductListingLoad(&$filters, &$order, &$product, &$select, &$select2, &$a, &$b, &$on) {
		$this->_traceDebug(__FUNCTION__, "Charge une liste de Products 1/2 : SQL", $select." ".$select2." FROM ".$a.($b?", ":"").$b.$on.$order);
		$this->_traceDebug(__FUNCTION__, "Charge une liste de Products 2/2 : ... WHERE", $filters);
	}

	function onBeforeProductExport(&$products, &$categories, &$context) {
		$this->_traceDebug(__FUNCTION__, "avant export de produit", $products);
	}
	

		/* ============ Category events ================ */
	function onBeforeCategoryCreate(&$element,&$do) {
		$this->_traceDebug(__FUNCTION__, "avant creation categorie", $element);
	}

	function onAfterCategoryCreate(&$element) {
		$this->_traceDebug(__FUNCTION__, "apres creation categorie", $element);
	}

	function onBeforeCategoryUpdate(&$element,&$do) {
		$this->_traceDebug(__FUNCTION__, "avant modification categorie", $element);
	}

	function onAfterCategoryUpdate(&$element) {
		$this->_traceDebug(__FUNCTION__, "apres modification categorie", $element);
	}

	function onBeforeCategoryDelete(&$ids,&$do) {
		$this->_traceDebug(__FUNCTION__, "avant suppression categorie", $ids);
	}

	function onAfterCategoryDelete(&$ids) {
		$this->_traceDebug(__FUNCTION__, "apres suppression categorie", $ids);
	}

	function onBeforeCategoryListingLoad(&$filters, &$order, &$parentObject) {
		$this->_traceDebug(__FUNCTION__, "avant chargement du listing des catégories", $filters);
	}


	/* ============ Address events ================ */
	function onBeforeAddressCreate(&$element, &$do) {
		$this->_traceDebug(__FUNCTION__, "avant creation d'une adresse", $element);
	}

	function onAfterAddressCreate(&$element) {
		$this->_traceDebug(__FUNCTION__, "apres creation d'une adresse", $element);
	}

	function onBeforeAddressUpdate(&$element, &$do) {
		$this->_traceDebug(__FUNCTION__, "avant modification d'une adresse", $element);
	}

	function onAfterAddressUpdate(&$element) {
		$this->_traceDebug(__FUNCTION__, "apres modification d'une adresse", $element);
	}

	function onBeforeAddressDelete($elements, $do) {
		$this->_traceDebug(__FUNCTION__, "avant suppression d'une adresse", $elements);
	}


	/* ============ Shipping events ================ */
	function onShippingDisplay(&$order,&$methods,&$usable_methods,&$messages) {
		$this->_traceDebug(__FUNCTION__, "", $order);
	}

	function onShippingSave(&$order,&$methods,&$shipping_id) {
		$this->_traceDebug(__FUNCTION__, "", $order);
	}

	function onShippingConfiguration(&$element) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onShippingConfigurationSave(&$element) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function shippingMethods(&$method) {
		$this->_traceDebug(__FUNCTION__, "", $method);
	}

	function onAfterProcessShippings(&$usable_rates){
		$this->_traceDebug(__FUNCTION__, "apres calcul du mode de livraison", $step);
	}
	


	/* ============ Payment events ================ */
	function onPaymentDisplay(&$order,&$methods,&$usable_methods) {
		$this->_traceDebug(__FUNCTION__, "", $order);
	}

	function onPaymentSave(&$order,&$methods,&$payment_id) {
		$this->_traceDebug(__FUNCTION__, "", $order);
	}

	function onPaymentConfiguration(&$element) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onPaymentConfigurationSave(&$element) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onPaymentNotification(&$statuses) {
		$this->_traceDebug(__FUNCTION__, "", $statuses);
	}



	/* ============ Vote events ================ */
	function onBeforeVoteCreate(&$element,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}
	
	function onAfterVoteCreate(&$element) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}
	
	function onBeforeVoteUpdate(&$element,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}
	
	function onAfterVoteUpdate(&$element) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}
	
	function onBeforeVoteDelete(&$element,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}
	
	function onAfterVoteDelete(&$element) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}
	

	/* ============ Cart events ================ */
	function onBeforeCartUpdate(&$cartClass,&$cart,$product_id,$quantity,$add,$type,$resetCartWhenUpdate,$force,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $cart);
	}
	
	function onAfterCartUpdate(&$cartClass,&$cart,$product_id,$quantity,$add,$type,$resetCartWhenUpdate,$force) {
		$this->_traceDebug(__FUNCTION__, "", $cart);
	}
	
	function onAfterCartProductsLoad(&$cart) {
		$this->_traceDebug(__FUNCTION__, "apres chargt produit du panier", $cart);
	}
	
	function onAfterCartShippingLoad(&$cart) {
		$this->_traceDebug(__FUNCTION__, "", $cart);
	}
	
	
	/* ============ Checkout events ================ */
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


	/* ============ Display events ================ */
	function onDisplayImport(&$importData) {
		$this->_traceDebug(__FUNCTION__, "", $importData);
	}

	function onProductFormDisplay(&$product, &$html) {
		$this->_traceDebug(__FUNCTION__, "formulaire produit", $product);
		//$html[] = "ajout de code HTML a l'ecran";
	}

	function onProductDisplay(&$product, &$html) {
		$this->_traceDebug(__FUNCTION__, "affichage produit", $product);
		//$html[] = "ajout de code HTML a l'ecran";
	}

	function onProductBlocksDisplay(&$product, &$html) {
		$this->_traceDebug("PRD", __FUNCTION__, "Affichage Block produit", $product);
		//$html[] = "ajout de code HTML a l'ecran";
	}

	function onAfterOrderProductsListingDisplay(&$order,$mail) {
		$this->_traceDebug(__FUNCTION__, "apres affichage des produits de la commande", $order);
	}

	function onHikashopBeforeDisplayView(&$view) {
		$this->_traceDebug(__FUNCTION__, "", $view);
	}

	function onHikashopAfterDisplayView(&$view) {
		$this->_traceDebug(__FUNCTION__, "", $view);
	}

	/* ============ Coupon events ================ */
	function onBeforeCouponLoad(&$coupon,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $coupon);
	}

	function onBeforeCouponCheck(&$coupon,&$total,&$zones,&$products,&$display_error,&$error_message,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $coupon);
	}

	function onAfterCouponCheck(&$coupon,&$total,&$zones,&$products,&$display_error,&$error_message,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $coupon);
	}



	/* ============ Discount events ================ */
	function onBeforeDiscountCreate( &$discount, & $do) {
		$this->_traceDebug(__FUNCTION__, "", $discount);
	}

	function onAfterDiscountCreate( &$discount) {
		$this->_traceDebug(__FUNCTION__, "", $discount);
	}

	function onBeforeDiscountUpdate( &$discount, & $do) {
		$this->_traceDebug(__FUNCTION__, "", $discount);
	}

	function onAfterDiscountUpdate( &$discount) {
		$this->_traceDebug(__FUNCTION__, "", $discount);
	}

	function onBeforeDiscountDelete( & $elements, & $do) {
		$this->_traceDebug(__FUNCTION__, "", $discount);
	}

	function onAfterDiscountDelete( & $elements ) {
		$this->_traceDebug(__FUNCTION__, "", $discount);
	}


	/* ============ User events ================ */
	function onBeforeUserCreate(&$element,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onAfterUserCreate(&$element) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onBeforeUserUpdate(&$element,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onAfterUserUpdate(&$element) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onBeforeUserDelete(&$elements,&$do) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onAfterUserDelete($elements) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onUserAccountDisplay(&$buttons) {
		$this->_traceDebug(__FUNCTION__, "", $buttons);
	}



	/* ============ Filter events ================ */
	function onFilterDisplay(&$filter,&$html,&$divName,&$parent,&$datas) {
		$this->_traceDebug(__FUNCTION__, "", $filter);
	}

	function onFilterAdd(&$filter,&$filters,&$select,&$select2,&$a,&$b,&$on,&$order,&$divName,&$parent) {
		$this->_traceDebug(__FUNCTION__, "", $filter);
	}

	function onFilterToLoad(&$filter,&$html,&$divName,&$parent) {
		$this->_traceDebug(__FUNCTION__, "", $filter);
	}

	function onFilterTypeDisplay(&$allValues) {
		$this->_traceDebug(__FUNCTION__, "", $allValues);
	}



	/* ============ Field events ================ */
	function onFieldDateDisplay($field_namekey,$field,&$value,&$map,&$format,&$size) {
		$this->_traceDebug(__FUNCTION__, "", $field);
	}

	function onFieldDateCheckSelect(&$values) {
		$this->_traceDebug(__FUNCTION__, "", $values);
	}

	function onFieldsLoad(&$externalValues) {
		$this->_traceDebug(__FUNCTION__, "", $externalValues);
	}



	/* ============ Other events ================ */
	function onBeforeCalculateProductPriceForQuantityInOrder(&$products) {
		$this->_traceDebug(__FUNCTION__, "", $products);
	}

	function onAfterCalculateProductPriceForQuantityInOrder(&$products) {
		$this->_traceDebug(__FUNCTION__, "", $products);
	}

	function onBeforeCalculateProductPriceForQuantity(&$product) {
		$this->_traceDebug(__FUNCTION__, "", $product);
	}

	function onAfterCalculateProductPriceForQuantity(&$product) {
		$this->_traceDebug(__FUNCTION__, "", $product);
	}

	function onBeforeDownloadFile(&$filename,&$do, &$file) {
		$this->_traceDebug(__FUNCTION__, "", $filename);
	}

	function onBeforeMailPrepare(&$mail,&$mailer, &$do) {
		$this->_traceDebug(__FUNCTION__, "", $mail);
	}

	function onBeforeMailSend(&$mail,&$mailer) {
		$this->_traceDebug(__FUNCTION__, "", $mail);
	}

	function onBeforeSendContactRequest(&$element, &$send) {
		$this->_traceDebug(__FUNCTION__, "", $element);
	}

	function onViewsListingFilter(&$pluginViews, $client_id) {
		$this->_traceDebug(__FUNCTION__, "", $pluginViews);
	}

	function onHikashopCronTrigger(&$messages) {
		$this->_traceDebug(__FUNCTION__, "", $messages);
	}

	function onCheckSubscription($subscription_level, &$infos) {
		$this->_traceDebug(__FUNCTION__, "", $subscription_level);
	}

	
	/**
	 * Methode d'affichage contextuel du debug
	 */
	private function _traceDebug($eventName, $msg, $var=""){
		//dump($eventName, "eventName");
		if(!$this->_isEventAsked($eventName)) return;
		
		$dispClass = $this->params->get('disp_class', 1);
		$msgEventAdv = "[<b>".($dispClass?__CLASS__."::":"").$this->_dispEvtType($eventName).$this->_dispEvtName($eventName)."</b>] ".$this->_dispEvtMsg($msg);
		$msgEvent = "[<b>".($dispClass?__CLASS__."::":"").$this->_dispEvtType($eventName).$eventName."</b>] ".$this->_dispEvtMsg($msg);
		if(in_array("ECHO", $this->debugModes) && $msgEventAdv) echo "<br />".$msgEventAdv;
		if(in_array("QMSG", $this->debugModes) && $msgEventAdv) {
			$app = JFactory::getApplication();
			$app->enqueueMessage($msgEventAdv);
		}
		if(in_array("SYST", $this->debugModes) && $msgEvent) JProfiler::getInstance('Application')->mark($msgEvent);
		if(in_array("JDUMP", $this->debugModes) && $msgEvent) {
			$dispData = $this->params->get('disp_jdumpdata', 1);
			if(!$dispData) {
				$dispDataSize = $this->params->get('size_jdumpdata', 500);
				if(($sizev = $this->_sizeofvar($var)) > $dispDataSize)
					$var = "[Data too big (".$sizev." bytes), not sent!]";	
			}
			if(function_exists("dump")) dump($var, $msgEvent);
		}
	}

	private function _isEventAsked($currEventName) {
		if($this->Events[$currEventName]->isConfigured($this->debugEvents)) return true;
		return false;
	}

	private function _dispEvtType($currEventName) {
		$dispTypeParam = $this->params->get('disp_type', 1);
		$dispEvtParam = $this->params->get('disp_event', 1);
		if($dispTypeParam) {
			$typeVal = $this->Events[$currEventName]->getType();
			if ($typeVal) return $typeVal.($dispEvtParam?"::":"");		
		} 
		return "";
	}

	private function _dispEvtName($currEventName) {
		$dispParam = $this->params->get('disp_event', 1);
		$dispLinkParam = $this->params->get('disp_evtlink', 1);
		if($dispParam) {
			if($dispLinkParam)
				return $this->Events[$currEventName]->computeDocUrl($currEventName, $this->hikaDocRootUrl);
			else
				return $currEventName;
		} 
		return "";
	}

	private function _dispEvtMsg($msg) {
		$dispParam = $this->params->get('disp_evtmsg', 1);
		if($dispParam) {
			return $msg;
		} 
		return "";
	}
	
	private function _sizeofvar($var) {
		$start_memory = memory_get_usage();
		$tmp = unserialize(serialize($var));
		return memory_get_usage() - $start_memory;
	}	
}



/**
 * Storage and manipulation class of the HikaShop plugins events
 * 
 * params : 
 * 		event : HikaShop event name
 * 		type : type of the event (Products, Orders ...)
 * 
 */
class CheckHikaEvent extends JObject {
	private $event = null;
	private $type = null;
	
	public function __construct($event, $type) {
		$this->event = $event;
		$this->type = $type;
		
		return $this;
	}

	/**
	 * Check if a type of an event is setted in the plugin params
	 * if found, the event will have to be displayed.
	 */
	public function isConfigured($types) {
		foreach($types as $type) {
			if($this->_isAssociated($type)) {
				return true;
			}
		}
		return false;
	}

	public function getType() {
		return $this->type;
	}

	/**
	 * Check if the event is associated to a Debug type
	 */
	private function _isAssociated($type="ALL") {
		if($this->type==$type || $type=="ALL")
			return true;
		else
			return false;
	}

	/**
	 * add a link to the HikaSHop Documentation section
	 */
	public function computeDocUrl($event, $url) {
		$link = "<a href='".$url.$this->type."' target='_blank'>".$event."</a>";
		return $link;
	}

	public function __toString() {
		return $this->event." on ".$this->type;
	}
}
