<?php
class Sailplay_Integrator_Model_Observer_User extends Mage_Core_Model_Abstract{
	
	protected $api_model = null;
	
	
	public function __construct()
    {
		$this->api_model =  Mage::getModel('sailplay_integrator/api');
    }
	
	public function checkUser(Varien_Event_Observer $observer) {
		
		$customer = $observer->getCustomer();
	
	}
  
	public function newUser(Varien_Event_Observer $observer) {	
	
		$customer = $observer->getCustomer();
		
	}
	
	public function updateUser(Varien_Event_Observer $observer) {	
	
		$customer = $observer->getCustomer();
		
	}
}