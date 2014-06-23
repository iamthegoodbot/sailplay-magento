<?php

class Sailplay_Integrator_Block_Logout extends Mage_Core_Block_Template
{
	protected $partner_id= '';
	
	
	public function _construct()
    {	
                $this->partner_id = Mage::getStoreConfig('sailplay_integrator/general/store_department_id');
		parent::_construct();

	}	

}