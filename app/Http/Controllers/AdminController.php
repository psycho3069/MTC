<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use DB;
use PDF;
use Auth;
use Session;
use Exception;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //MAINTENANCE
    public function maintenance(){
        return view('admin.maintenance');
    }

    // ----- METHODS FOR USER ----- //
    //USER
    public function user(){
        $all_users_info=DB::table('users')
                          ->orderBy('id', 'desc')
                          ->get();
        $role_info=DB::table('roles')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_users=view('admin.admin.user.user')
                          ->with('all_users_info',$all_users_info)
                          ->with('role_info',$role_info);
        return view('admin.master')
                          ->with('admin.admin.user.user',$manage_users);
    }
    //ADD USER
    public function adduser(){

        $role_info=DB::table('roles')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_role=view('admin.admin.user.adduser')
                          ->with('role_info',$role_info);

        return view('admin.master')
                          ->with('admin.admin.user.adduser',$manage_role);;
    }
    //ADD USER TO DATABASE
    public function saveuser(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:255'],
          'email'  => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'role_id'  => ['required', 'integer'],
          'password'  => ['required', 'string', 'min:6', 'confirmed']
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role_id'] = $request->role_id;
        $data['password'] = Hash::make($request->password);
        $data['created_at'] = now();


        DB::table('users')->insert($data);
        Session::put('message','User is Added Successfully');
        return Redirect::to('/admin/user/adduser');
    }
    //EDIT USER IN DATABASE
    public function edit_user($id)
    {
        $user_info=DB::table('users')
                            ->where('id',$id)
                            ->first();
        $role_info=DB::table('roles')
                            ->get();

        $manage_user=view('admin.admin.user.edituser')
                          ->with('all_users_info',$user_info)
                          ->with('role_info',$role_info);
        return view('admin.master')
                         ->with('admin.admin.user.edituser',$manage_user);
    }
    //UPDATE USER IN DATABASE
    public function update_user(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:255'],
          'email'  => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'role'  => ['required']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role_id'] = $request->role;

        DB::table('users')
             ->where('id',$id)
             ->update($data);
        Session::put('message','User has been updated Successfully');
        return Redirect::to('/admin/user/user');
    }
    //DELETE USER FROM DATABASE
    public function delete_user($id)
    {
        DB::table('users')
                ->where('id',$id)
                ->delete();
        Session::put('message', 'User has been deleted Successfully');
        return Redirect::to('/admin/user/user');
    }


    // ----- METHODS FOR USERROLE ----- //
    //USERROLE
    public function userrole(){
        $all_userrole_info=DB::table('roles')
                           ->orderBy('id', 'desc')
                           ->get();
        $manage_userrole=view('admin.admin.user_role.userrole')
                         ->with('all_userrole_info',$all_userrole_info);
        return view('admin.master')
                         ->with('admin.admin.user_role.userrole',$manage_userrole);
    }
    //ADD USERROLE
    public function addrole(){
        return view('admin.admin.user_role.adduserrole');
    }
    //ADD USERROLE IN DATABASE
    public function saverole(Request $request)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100', 'unique:roles'],
          'description'  => ['required', 'string', 'max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('roles')->insert($data);
        Session::put('message','User Role is Added Successfully');
        return Redirect::to('/admin/user_role/adduserrole');
    }
    //EDIT USERROLE IN DATABASE
    public function edit_user_role($id)
    {
        $userrole_info=DB::table('roles')
                           ->where('id',$id)
                           ->first();

        $manage_user_role=view('admin.admin.user_role.edituserrole')
                         ->with('all_userrole_info',$userrole_info);
        return view('admin.master')
                         ->with('admin.admin.user_role.edituserrole',$manage_user_role);
    }
    //UPDATE USERROLE IN DATABASE
    public function update_user_role(Request $request, $id)
    {
        $this->validate($request, [
          'name'  => ['required', 'string', 'max:100', 'unique:roles'],
          'description'  => ['required', 'string', 'max:255']
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        DB::table('roles')
             ->where('id',$id)
             ->update($data);
        Session::put('message','User Role has been updated Successfully');
        return Redirect::to('/admin/user_role/userrole');
    }
    //DELETE USERROLE FROM DATABASE
    public function delete_user_role($id)
    {
        try {
            DB::table('roles')
                    ->where('id',$id)
                    ->delete();
            Session::put('message', 'User Role has been deleted Successfully');
            return Redirect::to('/admin/user_role/userrole');
        } catch (Exception $e) {
            return back()->withError('This User Role cannot be deleted because other User/Users depend on it. To delete this User Role, delete dependent User/Users first, only then you can delete it.');
        }
    }

    // -----METHODS FOR ROLEWISEPERMISSION

    //ROLE-WISE-PERMISSION
    public function role_wise_permission(){
        return view('admin.admin.role_wise_permission/rolewisepermission');
    }

    //CHANGE-PASSWORD
    public function change_password(){
        return view('admin.admin.change_password/changepassword');
    }

    //SAVE-PASSWORD
    public function save_password(Request $request, $id){
        $this->validate($request, [
          'email'  => ['required', 'email', 'max:100'],
          'password'  => ['required', 'string','password', 'min:6','confirmed']
        ]);

        $data = array();
        $data['email'] = $request->email;
        $data['password'] = $request->password;

        DB::table('users')
             ->where('id',$id)
             ->update($data);
        Session::put('message','User Password has been changed Successfully');
        return Redirect::to('/admin/change_password/changepassword');
    }
}
