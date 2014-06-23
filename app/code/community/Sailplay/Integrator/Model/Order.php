<?php
class Sailplay_Integrator_Model_Order extends Mage_Core_Model_Abstract{
	
	protected $api_model = null;
	
	
	public function __construct()
    {
		$this->api_model =  Mage::getModel('sailplay_integrator/api');
    }
	
	public function placeRemote() {
		//get last order		
		$orders = Mage::getModel('sales/order')->getCollection()
					->setOrder('created_at','DESC')
					->setPageSize(1)
					->setCurPage(1);
		$orderId = $orders->getFirstItem()->getEntityId();
		
		$order = Mage::getModel('sales/order')->load($orderId);
		$user_data = $order->getBillingAddress();

		$user_phone = $user_data->getTelephone();
		$user_email = $user_data->getEmail();
		$first_name = $user_data->getFirstname();
		$last_name = $user_data->getLastname();
		$middle_name = $user_data->getMiddlename();
		$birth_date = '';
		$sex = '';
				
		//check user if exist
		$sp_user = $this->api_model->getUserByPhone($user_phone);
		
		
		if(!$sp_user)
			$sp_user = $this->api_model->getUserByEmail($user_email);
		
		//create user if not exist
		if(!$sp_user){
			$sp_user = $this->api_model->createUserByPhone($user_phone, $first_name, $last_name, $middle_name, $birth_date, $sex);
		}
		
		//set order to sailplay
		$_orderId = $order->getIncrementId();
	    $_amount = $order->getGrandTotal() - $order->getShippingAmount();
		
		$result  = $this->api_model->purchases($user_phone, $_orderId, $_amount);		

		return $result['purchase']['public_key'];		
	}
}