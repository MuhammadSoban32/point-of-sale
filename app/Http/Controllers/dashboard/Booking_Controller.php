<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Booking_Controller extends Controller
{
    public function booking(){
        return view("dashboard.booking");
    }
}
