<?php
class Sailplay_Integrator_Model_Observer extends Mage_Core_Model_Abstract{
	
	protected $api_model = null;
	
	
	public function __construct()
    {
		$this->api_model =  Mage::getModel('sailplay_integrator/api');
    }
	
	public function orderPlace() {
	
	}
  
	public function orderConfirm(Varien_Event_Observer $observer) {	
	
		$_event = $observer->getEvent();
		$_invoice = $_event->getInvoice();
		if($_invoice)
			$_order = $_invoice->getOrder();
		else
			$_order = $_event->getShipment()->getOrder();		
		
		$_orderId = $_order->getIncrementId();
	    $_amount = $_order->getGrandTotal() - $_order->getShippingAmount();
		$result = $this->api_model->purchaseConfirm($_orderId, $_amount);
		
	}
}

