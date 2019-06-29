<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransferSetting;
use App\Traits\Paystack\TransferSettingsTrait;
use App\Http\Requests\TransferRequest;

class TransferController extends Controller
{

    use TransferSettingsTrait;

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
}
