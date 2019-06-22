<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Traits\Paystack\BanksTrait;
use App\Bank;

class BankController extends Controller
{
    use BanksTrait;

    // Landing Page
    public function index()
    {
        $banks = Bank::all();
        return view('bank', compact('banks'));
    }

    // Fetch from Paystack API
    public function fetch()
    {
        $banks = $this->getBanks();

        $banks_array = [];

        foreach ($banks as $bank) {
            array_push($banks_array, [
                'name' => $bank->name,
                'code' => $bank->code,
            ]);
        }

        DB::table('banks')->truncate();
        DB::table('banks')->insert($banks_array);

        return redirect(route('bank'));
    }
}
