<?php

namespace App\Http\Controllers;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


use Illuminate\Http\Request;
// use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemoMail;
use App\Rules\BirthYearRule;


class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
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

    public function generateQrCode(){
        $data = 'https://www.example.com';
        // return QrCode::size(300)->generate($data);
        return QrCode::size(500)
                 ->email('hardik@itsolutionstuff.com', 'Welcome to ItSolutionStuff.com!', 'This is !.');
    }

    public function ruleForm(){
        return view('rule-form');
    }
    public function ruleFormPost(Request $request){
        $validator = $request->validate([
                'name' => 'required',
                'birth_year' => new BirthYearRule(),
            ]);
        echo '<pre>'; print_r($validator); exit;
        
    }




}
