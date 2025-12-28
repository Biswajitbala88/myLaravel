<?php

namespace App\Http\Controllers;
use App\Models\User;
use PDF;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    public function index(){
        echo '<pre>'; print_r(App::environment()); exit;
        if (App::environment() == 'staginng'){
            echo 'test';
        }else{
            echo 'test 2';
        }
    }

    public function getPdf(){
        $users = User::get();
        $data = [
            'title' =>'Invoice',
            'sub_title' => 'invoice genetare',
            'users' => $users
        ];
        $pdf = PDF::loadView('mypdf', $data);
        // return view('mypdf', $pdf);
        return $pdf->download('inv.pdf');

    }
}
