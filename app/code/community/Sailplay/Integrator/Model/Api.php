<?php
class Sailplay_Integrator_Model_API extends Mage_Core_Model_Abstract{
  
	protected $api_url = 'http://sailplay.ru/api';
	protected $store_department_id = '';
	protected $store_department_key = '';
	protected $pin_code = '';
	protected $token = '';
	
	
	public function __construct()
    {
		$this->store_department_id =  Mage::getStoreConfig('sailplay_integrator/general/store_department_id');
		$this->store_department_key =  Mage::getStoreConfig('sailplay_integrator/general/store_department_key');
		$this->pin_code =  Mage::getStoreConfig('sailplay_integrator/general/pin_code');
		$this->token =  Mage::getStoreConfig('sailplay_integrator/general/token');
    }
	
	//Авторизация приложения
	public function getTokenRemote(){
		
		$api_params = null;
		
		$api_params['store_department_id'] = $this->store_department_id;
		$api_params['store_department_key'] = $this->store_department_key;
		$api_params['pin_code'] = $this->pin_code;
				
		$result = $this->getRequestV1('login', $api_params);									
		
		return $result['token'];
	}
	
	//Метод получения auth_hash
	public function getAuthHash(){
		
		/*
		http://sailplay.ru/api/v1/users/points-info/?token=1acdad937c27516e06a2ba0eee4de246836756f1&store_department_id=621&user_phone=37379133978
		extra_fields=auth_hash
		*/
		
		
		$api_params = null;
		
		$api_params['store_department_id'] = $this->store_department_id;
		$api_params['store_department_key'] = $this->store_department_key;
		$api_params['pin_code'] = $this->pin_code;
				
		$result = $this->getRequestV1('login', $api_params);									
		
		return $result['token'];
	}
	
	//Метод создания покупки	
	public function purchases($user_phone, $order_num, $price){
	
		$api_params = null;
		
		$api_params['token'] = $this->token;
		$api_params['store_department_id'] = $this->store_department_id;
		$api_params['pin_code'] = $this->pin_code;
		$api_params['user_phone'] = $user_phone;
		$api_params['order_num'] = $order_num;
		$api_params['price'] = $price;
		$api_params['fields'] = 'public_key';
		
		$result = $this->getRequestV1('purchases/new', $api_params);		
		
		return $result;
	}
	
	//Метод получения информации о клиенте
	//user_idnt = user_phone||email
	public function getUserByPhone($user_phone){
		
		$api_params = null;	
	
		/*
		http://sailplay.ru/api/v2/users/info/?
		user_phone=37379133978&
		token=1acdad937c27516e06a2ba0eee4de246836756f1&store_department_id=621&
		history=1&
		extra_fields=auth_hash		
		*/
		
		$api_params['token'] = $this->token;
		$api_params['store_department_id'] = $this->store_department_id;
		$api_params['user_phone'] = $user_phone;
		
		$api_params['history'] = '1';
		$api_params['extra_fields'] = 'auth_hash';
		
		$result = $this->getRequestV2('users/info', $api_params);	
		if($result['status']!='ok')
			return null;
		
		return $result;
		
		
	}
	
	public function getUserByEmail($email){
		
		$api_params = null;	
		
		$api_params['token'] = $this->token;
		$api_params['store_department_id'] = $this->store_department_id;
		$api_params['email'] = $email;
		
		$api_params['history'] = '1';
		$api_params['xtra_fields'] = 'auth_hash';
		
		$result = $this->getRequestV2('users/info', $api_params);		
		if($result['status']!='ok')
			return null;
		
		return $result;
	}
	
	//Cоздание пользователя
	public function createUserByPhone($phone, $first_name, $last_name, $middle_name, $birth_date, $sex){
		
		$api_params = null;	
		
		$api_params['token'] = $this->token;
		$api_params['store_department_id'] = $this->store_department_id;
		
		$api_params['phone'] = $phone;
		$api_params['first_name'] = $first_name;
		$api_params['last_name'] = $last_name;
		$api_params['middle_name'] = $middle_name;
		$api_params['birth_date'] = $birth_date;
		$api_params['sex'] = $sex;	
		
		$api_params['extra_fields'] = 'auth_hash';
		
		$result = $this->getRequestV2('users/add', $api_params);		
		
		return $result;
	}
	
	public function createUserByEmail($email, $first_name, $last_name, $middle_name, $birth_date, $sex){
		
		$api_params = null;	
		
		$api_params['token'] = $this->token;
		$api_params['store_department_id'] = $this->store_department_id;
		
		$api_params['email'] = $email;
		$api_params['first_name'] = $first_name;
		$api_params['last_name'] = $last_name;
		$api_params['middle_name'] = $middle_name;
		$api_params['birth_date'] = $birth_date;
		$api_params['sex'] = $sex;	
		
		$api_params['extra_fields'] = 'auth_hash';
		
		$result = $this->getRequestV2('users/add', $api_params);		
		
		return $result;
	}
	
	
	//Метод изменения пользователя
	//http://docs.sailplay.ru/ru/page/api-user-update/
	public function updateUser($phone, $first_name, $last_name, $middle_name, $birth_date, $sex){
		
		$api_params = null;	
		
		$api_params['token'] = $this->token;
		$api_params['store_department_id'] = $this->store_department_id;
		
		$api_params['phone'] = $phone;
		$api_params['first_name'] = $first_name;
		$api_params['last_name'] = $last_name;
		$api_params['middle_name'] = $middle_name;
		$api_params['birth_date'] = $birth_date;
		$api_params['sex'] = $sex;	
		
		$api_params['extra_fields'] = 'auth_hash';
		
		$result = $this->getRequestV2('users/update', $api_params);		
		
		return $result;
	}
	
	
	//Метод подтверждения покупки
	//http://docs.sailplay.ru/ru/page/api-purchase-confirm/
	public function purchaseConfirm($order_num, $new_price){
		
		$api_params = null;	
		
		$api_params['token'] = $this->token;
		$api_params['store_department_id'] = $this->store_department_id;
		
		$api_params['order_num'] = $order_num;
		$api_params['new_price'] = $new_price;
		
		
		$result = $this->getRequestV1('purchases/confirm', $api_params);		
		
		return $result;
	}
	
	public function getRequestV1($api_action, $api_params){
		
		$params = '';
		foreach ($api_params as $key => $value){		
			$params .='&'.$key.'='.$value;
		}
		$params = substr($params, 1);		
		$url = $this->api_url.'/v1/'.$api_action.'/?'.$params;		
		
		$result = Mage::helper('sailplay_integrator')->getRequest($url);	
		$rs_arr = json_decode($result, true);
		
		return $rs_arr;
	}
	
	public function getRequestV2($api_action, $api_params){
		
		$params = '';
		foreach ($api_params as $key => $value){		
			$params .='&'.$key.'='.$value;
		}
		$params = substr($params, 1);		
		$url = $this->api_url.'/v2/'.$api_action.'/?'.$params;		
		
		$result = Mage::helper('sailplay_integrator')->getRequest($url);	
		$rs_arr = json_decode($result, true);
		
		return $rs_arr;
	}
}