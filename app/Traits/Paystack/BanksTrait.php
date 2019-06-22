<?php

namespace App\Traits\Paystack;

use Log;

trait BanksTrait
{
    private $curlvalues;

    /**
	 * Fetch banks list via paystack API
	 *
	 * @return JSON bank list
	 **/
	public function getBanks()
	{
		$this->curlvalues = array(
			CURLOPT_URL => 'https://api.paystack.co/bank',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
			    "Authorization: Bearer ".env('PAYSTACK_SECRET'),
			    "Cache-Control: no-cache"
			)
		);

        $resp = $this->callCurl();

		$resp = json_decode($resp);

		if ($resp->status) {
			return $resp->data;
		}
		Log::error("Paystack cURL Error - fetching banks list #:" . json_encode($resp->message));
		return false;
    }

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
			Log::info("Paystack API Error - calling bank API #:" . json_encode($err));
		 	return false;
		}
		return $response;
	}
}
