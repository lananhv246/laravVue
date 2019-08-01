<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class SinglePageController extends Controller
{
    public function index() {
        # id user login
        $id = Auth::id();
        # get mac IP address
        $MAC = exec('getmac');
        # get mac IP value
        $MAC = strtok($MAC, ' ');  
        $user = User::find($id);
        if($user->mac_ip_address === $MAC) {
            return view('app');
        } else {
            # code...
            return response(view('errors.403'), 403);
        }
    }
}
