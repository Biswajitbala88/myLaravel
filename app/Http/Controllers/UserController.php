<?php

namespace App\Http\Controllers;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemoMail;

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

    // fileUplaod
    public function fileUploadForm(){
        $data = [
            'title' => 'File Upload Demo',
            'created_at' => dateYmdToMdy('2024-06-30')
        ];
        return view('fileUpload', $data);
    }
    public function fileUpload(Request $request){
        // echo '<pre>'; print_r($request->all()); exit;
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $file = $request->file('file');
        $fileName = time().'-'.$file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);
        // $file->storeAs('uploads', $fileName, 'public');
        return back()->with('success', 'File uploaded successfully')->with('file', $fileName);
    }

    // send demo mail
    public function sendDemoMail(){
        $mailData = [
            'title' => 'Mail from MyLaravelApp',
            'body' => 'This is for testing email using smtp'
        ];
        Mail::to('biswajitbala88@gmail.com')->send(new DemoMail($mailData));
        echo 'send demo mail';

    }
}
