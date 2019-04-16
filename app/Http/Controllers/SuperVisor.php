<?php

namespace App\Http\Controllers;

use App\Complain;
use Illuminate\Http\Request;



class SuperVisor extends Controller
{
    public function loginPage(){
        return view('supervisor.login');
    }

    public function regPage(){
        return view('supervisor.reg');
    }

    public function newSup(Request $request){
        $supervisor= new \App\Supervisor();

        $supervisor->name = $request->name;
        $supervisor->email = $request->email;
        $supervisor->password = bcrypt($request->password);

        $supervisor-> save();

    }

    public function loginSup(Request $request){

        $supervisor = \App\Supervisor::where('email', $request->email)->first();

        if($supervisor) {

            if (password_verify($request->password, $supervisor->password)) {









                return redirect('supHome');


            } else {
                return redirect('supervisor')->with('message', 'Opps! You have entered an wrong password. please insert valid password.' );
            }



        }

    }

    public function supHome(){
        $complain= Complain::where('verification', 1)->get();

        return view('supervisor.home',[
            'complains'=>$complain
        ]);

    }

    public function doneComplain($id){

        $complain = Complain::find($id);

        $complain->delete();

        return redirect('/supHome')->with('massage', 'Action taken against the complain Successfully');
    }
}
