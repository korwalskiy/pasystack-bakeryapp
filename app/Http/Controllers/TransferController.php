<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransferSetting;
use App\Transfer;
use App\Traits\Paystack\TransfersTrait;
use App\Recipient;
use App\Http\Requests\TransferRequest;
use App\Customer;

class TransferController extends Controller
{

    use TransfersTrait;

    public function getSettings()
    {
        $otp_setting = TransferSetting::where('name','require_otp')->first();
        return view('transfer-settings', compact('otp_setting'));
    }

    public function postSettings(Request $request)
    {
        $otpvalue = $request->require_otp ?? 'false';

        // Call Paystack API

        TransferSetting::where('name', 'require_otp')->update(["value" => $otpvalue]);
        $request->session()->flash('flash_notification.level', 'success');
        $request->session()->flash('flash_notification.message', 'OTP Updated successfully!');

        return redirect('transfer-settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $alltransfers = Transfer::all();
        $allsuppliers = Recipient::with('customer')->get();
        return view('transfer-add', compact('alltransfers', 'allsuppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create recipient info
        $tx = Transfer::create([
            "recipient_code" => $request->customer_id,
            "amount" => $request->amount,
            "reason" => $request->reason,
        ]);

        // Create recipient on Paystack
        $rx = (object) ['source' => 'balance', 'reason' => $request->reason, 'amount' => $request->amount, 'recipient' => $request->customer_id];
        $pk_response = $this->makeTransfer($rx);

        // Show message
        if (is_object($pk_response)) {
            $request->session()->flash('flash_notification.level', 'danger');
            $request->session()->flash('flash_notification.message', $pk_response->message);
        }
        else {
            $request->session()->flash('flash_notification.level', 'success');
            $request->session()->flash('flash_notification.message', 'Transfer Initiated successfully!');

            // Update TX data
            $tx->recipient_number = $pk_response->recipient_number;
            $tx->transfer_code = $pk_response->transfer_code;
            $tx->transfer_status = 'pending';
            $tx->save();
        }

        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
