<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Paystack\TransferRecipientTrait;
use App\Recipient;
use App\Http\Requests\CustomerRequest;
use App\Customer;
use App\Bank;

class CustomerController extends Controller
{
    use TransferRecipientTrait;

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
    public function create(Request $request)
    {
        $banks = Bank::all();
        return view('customer-add', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        // Create customer info
        $customer = Customer::create([
            "name" => $request->name,
            "email" => $request->email
        ]);

        // Create recipient info
        $recipient = Recipient::create([
            "customer_id" => $customer->id,
            "account_number" => $request->account_number,
            "bank_code" => $request->bank_code,
            "description" => $request->description,
        ]);

        // Create recipient on Paystack
        $rx = (object) ['name' => $request->name, 'email' => $request->email, 'account_number' => $request->account_number, 'bank_code' => $request->bank_code, 'description' => $request->description];
        $pk_response = $this->getRecipientRef($rx);

        // Show message
        if (is_object($pk_response)) {
            $request->session()->flash('flash_notification.level', 'danger');
            $request->session()->flash('flash_notification.message', $pk_response->message);
        }
        else {
            $request->session()->flash('flash_notification.level', 'success');
            $request->session()->flash('flash_notification.message', 'Customer created successfully!');

            // Update recipient code
            $recipient->recipient_code = $pk_response;
            $recipient->save();
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
