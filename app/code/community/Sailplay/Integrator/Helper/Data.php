<?php

class Sailplay_Integrator_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function timeDiff($firstTime,$lastTime)
	{
		// convert to unix timestamps
		$firstTime = strtotime($firstTime);
		$lastTime = strtotime($lastTime);

		// perform subtraction to get the difference (in seconds) between times
		$difference = $lastTime-$firstTime;
		
		$hours = abs(floor(($difference-($years * 31536000)-($days * 86400))/3600));
		
		// return the difference
		return $hours;
	}	
	
	public function getRequest($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($ch); 
		curl_close($ch);
		return $result;
	}
}