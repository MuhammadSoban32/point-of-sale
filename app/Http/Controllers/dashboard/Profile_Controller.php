<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

class Profile_Controller extends Controller
{
    public function view_testing(Request $request){
        return view("dashboard.testing_view");
    }
    public function profile(Request $request){
        return view("dashboard.profile");
    }
    
    public function update_profile(Request $request){
         $validator = Validator::make($request->all(),[
                'user_name' => 'required',
            ]);
        if ($validator->fails()) {
            return response()->json(["status"=>false,"errors"=> $validator->errors()->all()]);
        }

        if ($request->user_name !== Auth::user()->name && $request->hasFile('profile_image') ) {
           // Update the profile image and name
           // Generate a unique filename
           $image = $request->file('profile_image');
           $imageName = time().'.'.$image->getClientOriginalExtension();
           $image->move(public_path('dashboard/profile_images'), $imageName);
           
            $update = DB::table('users')
            ->where('email', Auth::user()->email)
            ->update([
                'name' => $request->user_name,
                'profile_image' => $imageName 
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated'
            ]);
        } else {
            if ($request->hasFile('profile_image') ) {
                $image = $request->file('profile_image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('dashboard/profile_images'), $imageName);
                
                 $update = DB::table('users')
                 ->where('email', Auth::user()->email)
                 ->update([
                     'profile_image' => $imageName,
                 ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Profile Updated'
                ]);
            }else if($request->user_name === Auth::user()->name){
                return response()->json([
                    'status' => true,
                    'message' => 'Profile Updated'
                ]);
            }else if($request->user_name !== Auth::user()->name){
                $update = DB::table('users')
                ->where('email', Auth::user()->email)
                ->update([
                    'name' => $request->user_name,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Profile Updated'
                ]);
            }
        }
    }
    public function update_password(Request $request){
        // dd($request->toArray());
        $validator = Validator::make($request->all(),[
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(["status"=>false,"errors"=>$validator->errors()->all()]);
        }

        $currentPassword = DB::table('users')
            ->where('email', Auth::user()->email)
            ->pluck("password")->first();
            // dd($password);
         // Check if the provided current password matches the stored password
    if (!Hash::check($request->current_password, $currentPassword)) {
        return response()->json([
            'status' => false,
            'message' => 'Current password does not match',
        ]);
    };
    // Update the user's password
    $update = DB::table('users')
        ->where('email', Auth::user()->email)
        ->update(['password' => Hash::make($request->new_password)]);

    if ($update) {
        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully',
        ]);
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Failed to update password',
        ]);
    }

    }
}
