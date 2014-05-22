<?php
class Sailplay_Integrator_Model_Observer_Cart extends Mage_Core_Model_Abstract{
	
	protected $api_model = null;
	
	
	public function __construct()
    {
		$this->api_model =  Mage::getModel('sailplay_integrator/api');
    }
	
	public function setFree(Varien_Event_Observer $observer) {
		
		if($_GET['remote']=='1'){
		
			$item = $observer->getQuoteItem();
			if ($item->getParentItem()) {
				$item = $item->getParentItem();
			}

			// Discounted 25% off
			$percentDiscount = 0.25; 

			
			$specialPrice = $item->getOriginalPrice() - ($item->getOriginalPrice() * $percentDiscount);
			$specialPrice = 0;
		
			
			$item->setCustomPrice($specialPrice);
			$item->setOriginalCustomPrice($specialPrice);
			$item->getProduct()->setIsSuperMode(true);			
		}	
		
		
		


		$quote = Mage::getSingleton('checkout/session')->getQuote();
		$quote->save();
		$items = $quote->getAllItems();
		$qty = 1;
		foreach($items as $item) {	
			
			if($item->getPrice()==0&&$item->getPrice()!=null){
				$item->setData('gift_message_id', $item->getId());
				$item->setQty(1);
				//$quote->getCart()->updateItem(array($item->getId()=>array('qty'=>$qty)));
				//exit;
			}
				//$item->setQty(1);
				//$quote->updateItem(array($item->getId()=>array('qty'=>1)));
		}
		
		$quote->save();

	}
  
}