<?php

class Sailplay_Integrator_Block_Spbody extends Mage_Core_Block_Template
{
	protected $store_department_id = '';
	protected $store_department_key = '';
	protected $pin_code = '';
	protected $token = '';
	
	const XML_PATH_ENABLED = 'sailplay_integrator/general/enabled';
	
	
	public function _construct()
    {	
		parent::_construct();
		if(Mage::getStoreConfig(self::XML_PATH_ENABLED)){
		
			$this->store_department_id =  Mage::getStoreConfig('sailplay_integrator/general/store_department_id');
			$this->store_department_key =  Mage::getStoreConfig('sailplay_integrator/general/store_department_key');
			$this->pin_code =  Mage::getStoreConfig('sailplay_integrator/general/pin_code');
			
			
			$lastupdate = Mage::getStoreConfig('sailplay_integrator/general/lastupdate');
			if(!$lastupdate)
				$lastupdate = '2014-01-01 01:00:00';
				
			$difference = Mage::helper('sailplay_integrator')->timeDiff($lastupdate, date("Y-m-d H:i:s"));
			if($difference >= 12){
				$cf = new Mage_Core_Model_Config();
				$cf->saveConfig('sailplay_integrator/general/lastupdate', date("Y-m-d H:i:s"),  'default', 0);
				$this->token = Mage::getModel('sailplay_integrator/api')->getTokenRemote();
				$cf->saveConfig('sailplay_integrator/general/token', $this->token,  'default', 0);
			}
			else
				$this->token =  Mage::getStoreConfig('sailplay_integrator/general/token');				
			
		}
	}
	
	
	public function isLoggedIn()     
	{
		$session = Mage::getSingleton('customer/session', array('name'=>'frontend'));
		//$customer_data = Mage::getModel('customer/customer')->$session->id;

		if($session->isLoggedIn()){
			return 'true';
		} else {
			return 'false';
		}
	}
	
	
	public function getAuthash()     
	{
		$authash =  Mage::getModel('sailplay_integrator/api')->getAuthHash();
		return $authash;
	}
	
	
	protected function _toHtml()
    {
		if (!Mage::getStoreConfig(self::XML_PATH_ENABLED))
			return '';
		
        return parent::_toHtml();
    }
}