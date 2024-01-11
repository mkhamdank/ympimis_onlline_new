<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Database\QueryException;
use App\Role;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      $this->middleware('auth');
    }
    
    public function index()
    {
      $created_by = User::orderBy('name', 'ASC')
      ->get();

      $users = User::orderBy('name', 'ASC')
      ->where('role_code', '<>', 'S')
      ->get();

      return view('users.index', array(
        'users' => $users,
        'created_by' => $created_by
      ))->with('page', 'User');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $roles = Role::orderBy('role_name', 'ASC')
      ->where('role_code', '<>', 'S')
      ->get();
      return view('users.create', array(
        'roles' => $roles,
      ))->with('page', 'User');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requesst
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
      try{
        if($request->get('password') == $request->get('password_confirmation')){
          $id = Auth::id();
          $user = new User([
            'name' => ucwords($request->get('name')),
            'username' => strtolower($request->get('username')),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'role_code' => $request->get('role_code'),
            'avatar' => 'image-user.png',
            'created_by' => $id
          ]);

          $user->save();
          return redirect('/index/user')->with('status', 'New user has been created.')->with('page', 'User');
        }
        else{
          return back()->withErrors(['password' => ['Password confirmation is invalid.']])->with('page', 'User'); 
        }  
      }
      catch (QueryException $e){
        $error_code = $e->errorInfo[1];
        if($error_code == 1062){
          return back()->with('error', 'Username or e-mail already exist.')->with('page', 'User');
        }
        else{
          return back()->with('error', $e->getMessage())->with('page', 'User');
        }
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $created_bys = User::orderBy('name', 'ASC')->get();
      $user = User::find($id);

      return view('users.show', array(
        'user' => $user,
        'created_bys' => $created_bys
      ))->with('page', 'User');
        //
    }

    public function index_setting(){
      $user = User::find(Auth::id());

      return view('auth.setting', array(
        'user' => $user,
      ))->with('page', 'Setting');
    }

    public function setting(Request $request){
      try{
        $user = User::find(Auth::id());
        if(strlen($request->get('oldPassword'))>0 && strlen($request->get('newPassword'))>0 && strlen($request->get('confirmPassword'))>0){
          if(Hash::check($request->get('oldPassword'), Auth::user()->password)){
            if($request->get('newPassword') == $request->get('confirmPassword')){
              $user->name = ucwords($request->get('name'));
              $mail_to = $user->email;
              $user->phone_number = $request->get('phone_number');
              $user->remark = $request->get('company');
              $user->email = $request->get('email');
              $user->password = bcrypt($request->get('newPassword'));
              $user->save();

              // if (str_contains($mail_to, '@music.yamaha.com')) {
                $full_name = "";
                $contactList = [];
                $contactList[0] = 'mokhamad.khamdan.khabibi@music.yamaha.com';
                $contactList[1] = 'rio.irvansyah@music.yamaha.com';
                Mail::to($mail_to)->bcc($contactList,'BCC')->send(new SendEmail($full_name, 'change_password'));
              // }
              return redirect('/setting/user')->with('status', 'User data has been edited.')->with('page', 'Setting');
            }
            else{
              return redirect('/setting/user')->with('error', 'Password confirmation did not match.')->with('page', 'Setting');
            }
          }
          else{
            return redirect('/setting/user')->with('error', 'Old Password did not match.')->with('page', 'Setting');
          }
        }
        else{
          $user->name = ucwords($request->get('name'));
          $user->email = $request->get('email');
          $user->phone_number = $request->get('phone_number');
          $user->remark = $request->get('company');
          $user->save();
          return redirect('/setting/user')->with('status', 'User data has been edited.')->with('page', 'User');
        }
      }
      catch (QueryException $e){
        $error_code = $e->errorInfo[1];
        if($error_code == 1062){
          return redirect('/setting/user')->with('error', 'Username or e-mail already exist.')->with('page', 'User');
        }
        else{
          return redirect('/setting/user')->with('error', $e->getMessage().'asdasdsa')->with('page', 'User');
        }

      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $roles = Role::orderBy('role_name', 'ASC')
      ->where('role_code', '<>', 'S')
      ->get();
      
      $user = User::find($id);
      return view('users.edit', array(
        'user' => $user,
        'roles' => $roles,
      ))->with('page', 'User');
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
      $user = User::find($id);
      if($request->get('password') != "" || $request->get('password_confirmation') != ""){
        if($request->get('password') == $request->get('password_confirmation')){
          try{
            $user->name = ucwords($request->get('name'));
            $user->username = strtolower($request->get('username'));
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $user->role_code = $request->get('role_code');
            $user->save();
            return redirect('/index/user')->with('status', 'User data has been edited.')->with('page', 'User');
          }
          catch (QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
              return back()->with('error', 'Username or e-mail already exist.')->with('page', 'User');
            }
            else{
              return back()->with('error', $e->getMessage())->with('page', 'User');
            }
          }
        }
        else{
          return back()->withErrors(['password' => ['Password confirmation is invalid.']])->with('page', 'User');          
        }
      }
      else{
        try{
          $user->name = ucwords($request->get('name'));
          $user->username = strtolower($request->get('username'));
          $user->email = $request->get('email');
          $user->role_code = $request->get('role_code');
          $user->save();
          return redirect('/index/user')->with('status', 'User data has been edited.')->with('page', 'User');
        }
        catch (QueryException $e){
          $error_code = $e->errorInfo[1];
          if($error_code == 1062){
            return back()->with('error', 'Username or e-mail already exist.')->with('page', 'User');
          }
          else{
            return back()->with('error', $e->getMessage())->with('page', 'User');
          }
        }
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::find($id);
      $user->delete();

      return redirect('/index/user')->with('status', 'User has been deleted.')->with('page', 'User');
        //
    }
  }
