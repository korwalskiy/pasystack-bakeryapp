<?php

namespace App\Traits\Paystack;

use Log;

trait TransfersTrait
{
    private $curlvalues;
	private $recipient;
	private $finalise;

	/**
	 * Entry function for initiating transfers via paystack API
	 *
	 * @param Object $rx name, email, account_number, bank_code, description for paystack API call
	 * @return Response recipient_ref || false
	 **/
	public function makeTransfer($rx)
	{
        $this->recipient = ['source' => $rx->source, 'reason' => $rx->reason, 'amount' => $rx->amount, 'recipient' => $rx->recipient];
		return $this->initiateTransfer();
	}

	public function completeTransfer($tx_data)
	{
        $this->finalise = ['transfer_code' => $rx->tx_code, 'otp' => $rx->otp];
		return $this->finaliseTransfer();
	}

	/**
	 * Initiate Transfer via paystack API
	 *
	 * @param ClassProperty $this->source, reason, amount, recipient for post to paystack API
	 * @return Response Object || false
	 **/
	private function initiateTransfer()
	{
		$this->curlvalues = array(
			CURLOPT_URL => 'https://api.paystack.co/transfer',
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
				return ['recipient_number' => $resp->data->recipient_code, 'transfer_code' => $resp->data->transfer_code];
			}
		}
		Log::error("Paystack cURL Error - initiate transfer #:" . json_encode($resp));
		return $resp;
	}

	/**
	 * Fina Transfer via paystack API
	 *
	 * @param ClassProperty $this->transfer_code, otp for post to paystack API
	 * @return Response recipient_ref || false
	 **/
	private function finaliseTransfer()
	{
		$this->curlvalues = array(
			CURLOPT_URL => 'https://api.paystack.co/transfer/finalize_transfer',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($this->finalise),
			CURLOPT_HTTPHEADER => array(
			 "Authorization: Bearer ".env('PAYSTACK_SECRET'),
			 "Cache-Control: no-cache",
			 "Content-Type: application/json"
			)
		);

		//	return code on success
		//	return and log error on failure
		return($this->callCurl());
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
			Log::info("Paystack API Error - calling transfers API #:" . json_encode($err));
		 	return false;
		}
		return $response;
	}
}
