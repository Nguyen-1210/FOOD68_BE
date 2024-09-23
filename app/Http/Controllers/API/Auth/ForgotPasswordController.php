<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    private int $otpExpiredTime = 5;  

    public function __construct() {
      $this->middleware('guest');
    }

    
}