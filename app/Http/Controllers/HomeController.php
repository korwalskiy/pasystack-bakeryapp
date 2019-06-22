<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class HomeController extends Controller
{
    public function index()
    {
        $allcustomers = Customer::all();
        return view('welcome', compact('allcustomers'));
    }
}
