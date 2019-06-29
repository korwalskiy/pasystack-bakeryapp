<?php

namespace App\Traits\Paystack;

use Log;

trait TransferRecipientTrait
{
    private $curlvalues;
    private $recipient;

	/**
	 * Entry function for fetching recipient code via paystack API
	 *
	 * @param Object $rx name, email, account_number, bank_code, description for paystack API call
	 * @return Response recipient_ref || false
	 **/
	public function getRecipientRef($rx)
	{
        $this->recipient = ['type' => 'nuban', 'name' => $rx->name, 'email' => $rx->email, 'account_number' => $rx->account_number, 'bank_code' => $rx->bank_code, 'description' => $rx->description];
		return $this->createRecipient();
	}

	/**
	 * Entry function for updating customer info via paystack API
	 *
	 * @param Object $rx recipient_ref, name, email for paystack API call
	 * @return Response recipient_ref || false
	 **/
	public function updateRecipientRef($rx)
	{
		$this->recipient = ['recipient_ref' => $rx->recipient_code, 'name' => $rx->name, 'email' => $rx->email];
		return $this->updateRecipientInfo();
	}

	/**
	 * Create Transfer Recipient via paystack API
	 *
	 * @param ClassProperty $this->recipient name, account_number, bank_code, description for post to paystack API
	 * @return Response recipient_ref || false
	 **/
	private function createRecipient()
	{
		$this->curlvalues = array(
			CURLOPT_URL => 'https://api.paystack.co/transferrecipient',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($this->recipient),
			CURLOPT_HTTPHEADER => array(
			 "Authorization: Bearer ".env('PAYSTACK_SECRET'),
			 "Cache-Control: no-cache",
			 "Content-Type: application/json"
			)
		);

		//	return code on success
		//	return and log error on failure
		$resp = $this->callCurl();
		if ($resp) {
			$resp = json_decode($resp);
			if ($resp->status && $resp->data) {
				return $resp->data->recipient_code;
			}
		}
		Log::error("Paystack cURL Error - create transfer recipient #:" . json_encode($resp));
		return $resp;
	}

	/**
	 * Update transfer recipient info via paystack API
	 *
	 * @param ClassProperty $this->recipient recipient_code, name, email for post to paystack API
	 * @return Response recipient_code || false
	 **/
	private function updateRecipientInfo()
	{
		$this->curlvalues = array(
			CURLOPT_URL => 'https://api.paystack.co/transferrecipient/'.$this->recipient->recipient_code,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PUT',
			CURLOPT_POSTFIELDS => json_encode($this->recipient->only(['name', 'email'])),
			CURLOPT_HTTPHEADER => array(
			 "Authorization: Bearer ".env('PAYSTACK_SECRET'),
			 "Cache-Control: no-cache",
			 "Content-Type: application/json"
			)
		);

		//	return code on success
		//	return and log error on failure
		$resp = $this->callCurl();
		if ($resp) {
			$resp = json_decode($resp);
			if ($resp->status && $resp->data) {
				return $resp->data->recipient_code;
			}
		}
		Log::error("Paystack cURL Error - update transfer recipient #:" . json_encode($resp));
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
			Log::info("Paystack API Error - calling transfer recipient API #:" . json_encode($err));
		 	return false;
		}
		return $response;
	}
}
