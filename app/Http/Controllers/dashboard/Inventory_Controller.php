<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
class Inventory_Controller extends Controller
{
    public function index(){
        return view("dashboard.inventory");
    }
    
    public function add_item(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'measurement_unit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }
        $check = DB::table("products")
        ->where("name", $request->product_name)
        ->where("is_delete", 0)
        ->first();

    if (is_null($check)) {
        // Insert the new product
        $insert = DB::table("products")->insert([
            "name" => $request->product_name,
            "unit" => $request->measurement_unit,
        ]);

        // Check if insertion was successful
        if ($insert) {
            return response()->json([
                "status" => true,
                "message" => "Product Added"
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Failed to add product"
            ]);
        }
    } else {
        return response()->json([
            "status" => false,
            "errors" => ["The name has already been taken."]
        ]);
    }
    }
    public function fetch_items(Request $request){
        $items = DB::table('products')
        ->where("is_delete",0)
        ->get();
      if ($items) {
        return response()->json([
           "status"=>true, 
           "items"=>$items 
        ]);
      }else{
        return response()->json([
            "status"=>false, 
            "message"=>"The product name has already been taken." 
         ]);
      }
    }
    
    public function delete_item(Request $request){
        $delete = DB::table('products')
        ->where('id', $request->id)
        ->update(['is_delete' => 1]);

        if ($delete) {
            return response()->json([
                "status" => true, 
                "message" => "Product Deleted"
            ]);
        } else {
            return response()->json([
                "status" => false, 
                "message" => "Product Not Deleted"
            ]);
        }
    }

    public function edit_item_modal(Request $request){
         $items = DB::table('products')
        ->where([["is_delete",0],["id",$request->id]])
        ->first();
      if ($items) {
        return response()->json([
           "status"=>true, 
           "items"=>$items 
        ]);
      }else{
        return response()->json([
            "status"=>false, 
            "message"=>"No Found" 
         ]);
      }
    }
    
    public function edit_item(Request $request){
        $validator = Validator::make($request->all(),[
            'product_name' => 'required',
            'measurement_unit' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["status"=>false,"errors"=> $validator->errors()->all()]);
        }
        $check = DB::table("products")->where("name",$request->product_name)->where("is_delete",0)->first();
        if (is_null($check)) {
                $edit = DB::table('products')
                ->where([['id', $request->product_id],['is_delete', 0]])
                ->update([
                    'name' => $request->product_name,
                    'unit' => $request->measurement_unit
                ]);

                if ($edit) {
                    return response()->json([
                        "status" => true, 
                        "message" => "Product Edited"
                    ]);
                } else {
                    return response()->json([
                        "status" => false, 
                        "message" => "Product Not Edited"
                    ]);
                }
            }else{
                return response()->json([
                    "status" => false,
                    "errors" => ["The name has already been taken."]
                ]);
            }
    }
}
