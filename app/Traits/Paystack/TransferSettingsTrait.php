<?php

namespace App\Traits\Paystack;

use Log;

trait TransferSettingsTrait
{
    private $recipient;


    /**
	 * Perform the actual curl call
	 *
	 * @param ClassProperty $this->curlvalues contains all required curl paramters for the paystack API call
	 * @return Response response || false
	 **/
	private function callCurl()
	{
		$curl = curl_init();
		curl_setopt_array($curl, $this->curlvalues);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			Log::info("Paystack API Error - calling transfer recipient API #:" . json_encode($err));
		 	return false;
		}
		return $response;
	}
}
