<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class UserController extends Controller
{
    public function showAdminName () {
        return "Eslam Gamal";
    }

    public function getIndex (){


        $obj =new \stdClass();
        $obj->name = "Ahmed";
        $obj->age = 25;

        $data = ['Ahmed', 'Ali', 'Eslam'];
        return view('welcome', compact('data'));
    }
}
