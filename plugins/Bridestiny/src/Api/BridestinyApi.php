<?php

namespace Bridestiny\Api;

use Cake\Http\Client;
use Cake\Log\Log;
use App\Purple\PurpleProjectGlobal;

class BridestinyApi
{
    private function apiPath() 
	{
		$purpleGlobal = new PurpleProjectGlobal();
		$apiPath      = $purpleGlobal->apiDomain;
		return $apiPath;
	} 
    public function sendEmailCustomerVerification($key, $userData, $siteData, $senderData)
	{	
		$purpleGlobal = new PurpleProjectGlobal();
		$checkConnection = $purpleGlobal->isConnected();

		if ($checkConnection == true) {
			$http         = new Client();
			$response     = $http->post($this->apiPath() . '/bridestiny/customer-verification', 
								[
									'key'			=> $key,
                                    'userData'      => $userData,
                                    'siteData'      => $siteData,
									'senderData'    => $senderData
								]
							);
			$verifyResult = $response->body();
	        $decodeResult = json_decode($verifyResult, true);

	        Log::write('debug', $decodeResult);

	        if ($decodeResult['message'] == 'success') {
	        	return true;
	        }
	        else {
	        	return false;
	        }
		}
	    else {
	    	return true;
	    }
    }
    public function sendEmailVendorVerification($key, $userData, $siteData, $senderData)
	{	
		$purpleGlobal = new PurpleProjectGlobal();
		$checkConnection = $purpleGlobal->isConnected();

		if ($checkConnection == true) {
			$http         = new Client();
			$response     = $http->post($this->apiPath() . '/bridestiny/vendor-verification', 
								[
									'key'			=> $key,
                                    'userData'      => $userData,
                                    'siteData'      => $siteData,
									'senderData'    => $senderData
								]
							);
			$verifyResult = $response->body();
	        $decodeResult = json_decode($verifyResult, true);

	        Log::write('debug', $decodeResult);

	        if ($decodeResult['message'] == 'success') {
	        	return true;
	        }
	        else {
	        	return false;
	        }
		}
	    else {
	    	return true;
	    }
	}
}