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
	public function logoutRemote(Varien_Event_Observer $observer) {	
	
		$result = $this->api_model->logout();

	}

	public function newUser(Varien_Event_Observer $observer) {		
	
		$customer = $observer->getCustomer();	
		
		$result = $this->api_model->createUser(
			$customer->getData('entity_id'),
			$customer->getData('firstname'), 
			$customer->getData('lastname')
			);
			
		$result = $this->api_model->updateUser(
			$customer->getData('entity_id'),
			$customer->getData('email'), 
			null, 
			$customer->getData('firstname'), 
			$customer->getData('lastname'),
			'', '', ''
			);
		
	}
	
	public function updateUser(Varien_Event_Observer $observer) {	
		
		$customerAddressId = $observer->getCustomer()->getDefaultBilling();		
		if($customerAddressId){
			$customer = Mage::getModel('customer/address')->load($customerAddressId);
		
			$result = $this->api_model->updateUser(
					$observer->getCustomer()->getData('entity_id'),
					null, 
					$customer->getdata('telephone'), 
					$customer->getData('firstname'), 
					$customer->getData('lastname'),
					'', '', ''
				);

		}
		
	}
}