<?php

namespace App\Http\Controllers;

use App\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ComplainController extends Controller
{
    public function newComplain(Request $request){

        $image = $request->file('image');
        $directory = "image/";
        $imageName = $image->getClientOriginalName();
        $image->move($directory,$imageName);
        $imageUrl = $directory.$imageName;



        $complain = new Complain();

        $complain->first_name = $request->first_name;
        $complain->last_name = $request->last_name;
        $complain->email = $request->email;
        $complain->mobile = $request->mobile;
        $complain->message = $request->message;
        $complain->image = $imageUrl;
        $complain->verification = 0;

        $complain->save();

        return redirect('/')->with('massage', 'Complain send Successfully');


    }

    public function approveComplain($id){

        $complain = Complain::find($id);
        $complain->verification = 1;

        $complain->save();


//        $data = $complain->toArray();
//        Mail::send('comfirmation-mail', $data, function ($message) use ($data){
//            $message->to($data['email']);
//            $message->subject('Verification Message');
//        });

        return redirect('/home')->with('massage', 'Complain Approved');

    }

    public function deleteComplain($id){

        $complain = Complain::find($id);

        $complain->delete();

        return redirect('/home')->with('massage', 'Complain Deleted Successfully');
    }

    public function history(){

        $complain= Complain::where('verification', 1)->get();


        return view('admin.history.history',[
            'complains'=>$complain
        ]);
    }
}
