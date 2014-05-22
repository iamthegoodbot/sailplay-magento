<?php

class Sailplay_Integrator_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
		echo 'index';
    }		
	
	//GET
    public function setgiftAction()
    {
		$product_model = Mage::getModel('catalog/product');
    
		$_product_sku = $_GET['sku'];//'n2610';        
		$_product_id  = $product_model->getIdBySku($_product_sku);
		$_product     = $product_model->load($_product_id);
		
		
		/*
		//check found item in cart
		$quote = Mage::getSingleton('checkout/session')->getQuote();		
		$items = $quote->getAllItems();		
		foreach($items as $item) {	
			if($item->getProduct()->getId() == $_product_id)
				$this->_redirect('checkout/cart');
		}
		*/
		
		$qty_value = 1;
    
		$cart = Mage::getModel('checkout/cart');
		$cart->init();
		
		$cart->addProduct($_product, array('gift_message_id' => $_product_id, 'qty' => $qty_value, 'options' => array(
			3 => "Gift"
		)));
		
		$cart->save();
		$messages = Mage::getSingleton('core/session')->getMessages(true);
		
		Mage::getSingleton('catalog/session')->addSuccess($this->__('Подарок '.$_product->getName().''));
		
		
		$this->_redirect('checkout/cart');
		
    }
	
	//POST
	public function postgiftAction()
    {
		$params = $_POST;
		var_dump($params);
    }
	
}
