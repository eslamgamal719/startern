<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SecondController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('showString3');
    }

    public function showString1() {
        return "static String1";
    }

    public function showString2() {
        return "static String2";
    }

    public function showString3() {
        return "static String3";
    }
}
