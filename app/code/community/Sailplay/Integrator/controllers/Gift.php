<?php

class Sailplay_Integrator_GiftController extends Mage_Core_Controller_Front_Action
{
	 /**
     * Index action
     */
    public function indexAction()
    {
		echo 'index';
    }
	
    //GET
    public function getAction()
    {
		$params = $_GET;
		var_dump($params);
    }
	
	//POST
	public function postAction()
    {
		$params = $_POST;
		var_dump($params);
    }

}
