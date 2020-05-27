<?php

namespace App\Http\Controllers\dashboard;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\validation\Rule;

class userController extends Controller
{
    public function __construct(){

        $this->middleware(['permission:create-users'])->only('create');
        $this->middleware(['permission:read-users'])->only('index');
        $this->middleware(['permission:update-users'])->only('edit');
        $this->middleware(['permission:delete-users'])->only('destroy');
    }
    public function index(Request $request){
        $users = User::whereRoleIs('admin')->where(function($query) use ($request){

         return $query->when($request->search,function($q) use ($request){

            return $q->where("first_name",'like','%'."$request->search".'%')
            ->orWhere("last_name",'like','%'."$request->search".'%');
        });
     })->paginate(10);

        return view("dashboard.users.index",['users'=>$users]);
    }
    public function create(){

        return view("dashboard.users.create");
    }

    public function store(Request $request){


        $data  = $request->validate($this->VaidationOfNewUser());
        $data['password'] = bcrypt($request->password);
        if($request->image)
        {

            \Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path("/uploads/user_image/".$request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }

        $user = User::create($data);
        $user->attachRole("admin");
        $user->syncPermissions( $request->permissions);
        $request->session()->flash("success",__("site.add_successfully"));
        return redirect()->route('dashboard.user.index');
    }
    public function edit(User $user){

     return view("dashboard.users.edit",['user'=>$user]);
 }
 public function update(Request $request,User $user){

    $data  = $request->validate($this->validationOnUpdateUser($user));
    if($request->image)
    {
       if($user->image != "default.jpg")
       {
        \Storage::disk("public_uploads")->delete('/user_image/'.$user->image);
    }
    \Image::make($request->image)->resize(300, null, function ($constraint) {
        $constraint->aspectRatio();
    })->save(public_path("/uploads/user_image/".$request->image->hashName()));
    $data['image'] = $request->image->hashName();
}

$user->update($data);
($request->permissions)? $user->syncPermissions($request->permissions): $user->detachPermissions($this->permissions());
$request->session()->flash("success",__("site.add_successfully"));
return redirect()->route('dashboard.user.index');

}
public function destroy(Request $request,User $user){
    if($user->image != "default.png")
    {
        \Storage::disk("public_uploads")->delete('/user_image/'.$user->image);
    }
    $user->delete();
    $request->session()->flash("success",__("site.delete_successfully"));
    return redirect()->route('dashboard.user.index');
}

public function VaidationOfNewUser(){

    return [
        "first_name"=>"required|min:2",
        "last_name"=>"required|min:2",
        "email"=>"required|unique:users",
        "password"=>"required|confirmed",
        "image"=>"image",
        "permissions"=>"required|min:1",
    ];

}
public function validationOnUpdateUser($user){
    return [
        "first_name"=>"required|min:2",
        "last_name"=>"required|min:2",
        "email"=>["required",Rule::unique('users')->ignore($user->id)],
    ];
    
}
public function permissions(){

    return ['create-users','read-users','update-users','delete-users'];
}
}
