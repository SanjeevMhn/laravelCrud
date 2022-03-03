<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use LDAP\Result;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::all();
        //return view('user.index',compact('users'));
        return view('user.index');
    }

    public function search(Request $request){

        if($request->ajax()){
            $users = User::where('name','LIKE','%'.$request->query.'%')->get();
            echo '<pre>'.$users.'</pre>';
            $output = '';
            if(count($users) > 0){
                $output .= '
                    <div class="user-list grid-col-4 margin-top">';
                        foreach($users as $user){
                           $output.='<div class="user-card">
                        <div class="user-profile">
                            <img src="{{asset("storage/images/"'.$user->photo.'")}}">
                        </div>
                        <div class="user-details">
                            <h2 class="user-name">'.
                             $user->name.
                            '</h2>
                            <p class="user-email">'.
                                $user->email.
                            '</p>
                            <form action="{{route("user.destroy"'.$user->id.')}}" method="post" class="flex">
                                @csrf
                                @method("DELETE")
                                <a href="{{route("user.show"'.$user->id.')}}" class="btn-small blue">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{route("user.edit"'.$user->id.')}}" class="btn-small orange">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="submit" class="btn-small red">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>'; 
                }
            }else{
                $output .= '<p class="error-msg"> No matches found';
            }
            //return $output;
            return response()->json(['output'=>$output]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
           'name' => 'required',
           'email' => 'required',
           'photo' => 'required|file|mimes:png,jpg,jpeg,svg',
           'desc' => 'required'
       ]);

       $file = $request->file('photo');
       $ext = $request->file('photo')->getClientOriginalExtension();
       $fileNew = time().".".$ext;
       $file->storeAs('public/images',$fileNew);

       //$path = $file->storeAs('public/images',$fileNew);
       User::create([
           'name' => $request->name,
           'email' => $request->email,
           'photo' => $fileNew,
           'description' => $request->desc
       ]);

       return redirect()->route('user.index')->with('status','User record successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit',compact('user'));
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'desc' => 'required'
        ]);

        User::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->desc
        ]);

        return redirect()->route('user.index')->with('status','Successfully updated user');
        
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
        return redirect()->route('user.index')->with('status','Successfully deleted user record');
    }
}
