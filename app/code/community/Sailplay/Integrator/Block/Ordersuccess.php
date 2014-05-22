<?php

class Sailplay_Integrator_Block_Ordersuccess extends Mage_Core_Block_Template
{
	protected $publicKey = '';
	
	
	public function _construct()
    {	
		parent::_construct();
		$_order =  Mage::getModel('sailplay_integrator/order');
		$this->publicKey = $_order->placeRemote();
	}	

}