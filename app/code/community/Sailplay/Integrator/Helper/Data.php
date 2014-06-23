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
		//$url = $this->fullescape($url);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($ch); 
		curl_close($ch);
		return $result;
	}
	
	public function fullescape($in) 
	{ 
		$out = ''; 
		for ($i=0;$i<strlen($in);$i++) 
		{ 
			$hex = dechex(ord($in[$i])); 
			if ($hex=='') 
				$out = $out.urlencode($in[$i]); 
			else 
				$out = $out .'%'.((strlen($hex)==1) ? ('0'.strtoupper($hex)):(strtoupper($hex))); 
		} 
		$out = str_replace('+','%20',$out); 
		$out = str_replace('_','%5F',$out); 
		$out = str_replace('.','%2E',$out); 
		$out = str_replace('-','%2D',$out); 
		
		return $out; 
	}	 
}