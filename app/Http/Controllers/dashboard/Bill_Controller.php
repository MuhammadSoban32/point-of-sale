<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class Bill_Controller extends Controller
{
    public function bills(){
        return view("dashboard.bills");
    }
    public function get_item_unit(Request $request){
        $unit = DB::table('products')
        ->where("is_delete",0)
        ->where("id",$request->id)
        ->first();
        // dd($unit);
      if ($unit) {
        return response()->json([
           "status"=>true, 
           "unit"=>$unit 
        ]);
      }else{
        return response()->json([
            "status"=>false, 
            "message"=>"No Unit Found" 
         ]);
      }
    }
    public function index(){
        return view("dashboard.bills");
    }
    public function search_by(Request $request){
        $validator = Validator::make($request->all(), [
            'search_by'=>'required',
            'date'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>false,"errors" => $validator->errors()->all()]);
        }
        
        if ($request->search_by === "date") {
            // Search bills by date
            $searchResults = DB::table('bills')
            ->whereDate('date', $request->date)
            ->where('is_delete', 0)
            ->get();
        }else{
             // Search bills by created_at date
             $searchResults = DB::table('bills')
             ->whereDate('created_at', $request->date)
             ->where('is_delete', 0)
             ->get();
        }
        // dd($searchResults);

      if ($searchResults->isNotEmpty()) {
        return response()->json([
           "status"=>true, 
           "data"=>$searchResults
        ]);
      }else{
        return response()->json([
            "status"=>true, 
            "message"=>"No records found" 
         ]);
      }
    }
    public function fetch(){
        $product_sales = DB::table('products_sales')
        ->join("products as products", "products.id", "=", "products_sales.product_id")
        ->select("products_sales.*", "products.name as product_name")
        ->get();
      if ($product_sales->isNotEmpty()) {
        return response()->json([
           "status"=>true, 
           "data"=>$product_sales 
        ]);
      }else{
        return response()->json([
            "status"=>false, 
            "message"=>"No Found" 
         ]);
      }
    }
    public function fetch_bills_items(Request $request){
        $product_sales = DB::table('bills_items')
        ->join("products as products", "products.id", "=", "bills_items.product_id")
        ->select("bills_items.*", "products.name as product_name")
        ->where("bills_items.bills_id",$request->id)
        ->get();
      if ($product_sales) {
        return response()->json([
           "status"=>true, 
           "data"=>$product_sales 
        ]);
      }else{
        return response()->json([
            "status"=>false, 
            "message"=>"No Found" 
         ]);
      }
    }
    public function fetch_bills(Request $request){
        // $product_sales = DB::table('bills')->get();
        $product_sales = DB::table('bills')
        ->select('id', 'supplier_name', 'total_amount', DB::raw('DATE(date) as date_only'), DB::raw('DATE(created_at) as created_at_date'))
        ->where("is_delete",0)
        ->get();
        // dd($product_sales->toArray());
        if ($product_sales->isNotEmpty()) {   
            return response()->json([
                "status" => true, 
                "data" => $product_sales 
            ]);
        } else {
            return response()->json([
                "status" => false, 
                "message" => "Not Found",
                "data" => $product_sales 
            ]);
        }
    }
    public function delete_bills(Request $request){
         // Perform the update to mark the bill as deleted
                $delete = DB::table('bills')
                ->where('id', $request->id)
                ->update(['is_delete' => 1]);

            // Check if the update was successful and return the appropriate response
            if ($delete) {
                return response()->json([
                    'status' => true,
                    'message' => 'Bill Deleted'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Bill Not Deleted'
                ]);
            }
    }
    public function bills_edit(Request $request){
         // Perform the update to mark the bill as deleted
                $delete = DB::table('bills')
                ->where('id', $request->bill_id)
                ->update([
                    "supplier_name"=>$request->supplier_name,
                    "total_amount"=>$request->total_amount,
                    "date"=>$request->date,
                    "created_at" => Carbon::today() 

                ]);
                $delete = DB::table('bills_items')
                ->where('bills_id', $request->bill_id)
                ->delete();


                foreach ($request->product_name as $key => $value) {
                    $insert = DB::table("bills_items")->insert([
                        "product_id" => $request->product_name[$key],
                        "bills_id" => $request->bill_id, // Use the retrieved bill ID
                        "product_price" => $request->price[$key], // Corrected
                        "unit" => $request->product_unit[$key], // Corrected
                        "qty" => $request->qty[$key], // Corrected
                        "sub_total" => $request->sub_total[$key], // Corrected
                        "created_at" => Carbon::today() ,
                    ]);
                }

            // Check if the update was successful and return the appropriate response
            if ($insert) {
                return response()->json([
                    'status' => true,
                    'message' => 'Bill Deleted'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Bill Not Deleted'
                ]);
            }
    }
    public function bills_create_page(){
        $products = DB::table("products")->where("is_delete",0)->get();
        return view('dashboard.bills-create-page',['products' => $products]);
    }
    public function bills_edit_page($id){
        $products = DB::table("products")->get();
        $bills = DB::table("bills")->where("id",$id)->get();
        $bills_items = DB::table("bills_items")->where("bills_id",$bills[0]->id)->get();
        // dd($bills_items->toArray());
        return view('dashboard.bills-edit-page', [
            'products' => $products,
            'bills' => $bills,
            'bills_items' => $bills_items
        ]);
    }
    public function bill_create(Request $request){

        // $validator = Validator::make($request->all(), [
        //     'supplier_name' => 'required|string',
        //     'date' => 'required',
        //     'product_name.*' => 'required|string',
        //     'price.*' => 'required|numeric',
        //     'qty.*' => 'required|numeric',
        //     'sub_total.*' => 'required|numeric',
        // ]);

        $validator = Validator::make($request->all(), [
            'supplier_name' => 'required|string',
            'date' => 'required',
            'product_name.*' => 'required|string',
            'price.*' => 'required|numeric',
            'qty.*' => 'required|numeric',
            'sub_total.*' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $formattedErrors = [];
            // CORRECT ERROR MESSAGE FORMAT
            foreach ($errors as $field => $messages) {
                // Extract the base field name without array indices
                $fieldBaseName = preg_replace('/\.\d+/', '', $field);
                foreach ($messages as $message) {
                    // Customize the message to remove the array index
                    $cleanedMessage = preg_replace('/' . preg_quote($field) . '/', $fieldBaseName, $message);
                    $formattedErrors[] = $cleanedMessage;
                }
            }
        
            return response()->json(['status' => false, 'errors' => $formattedErrors]);
        }
        
        
        


        // Insert bill and get its ID
        $insertId = DB::table("bills")->insertGetId([
            "supplier_name" => $request->supplier_name,
            "total_amount" => $request->total_amount,
            "date" => $request->date,
            // "created_at" => Carbon::today(),
            'created_at' => Carbon::today()->toDateString(), // Store only the date
        ]);
    
        // Check if bill insertion was successful
        if ($insertId) {
            // Loop through product details and insert into bills_items table
            foreach ($request->product_name as $key => $value) {
                $insert = DB::table("bills_items")->insert([
                    "product_id" => $request->product_name[$key],
                    "bills_id" => $insertId, // Use the retrieved bill ID
                    "product_price" => $request->price[$key], // Corrected
                    "unit" => $request->product_unit[$key], // Corrected
                    "qty" => $request->qty[$key], // Corrected
                    "sub_total" => $request->sub_total[$key], // Corrected
                    "created_at" => Carbon::today()->toDateString(),
                ]);
            }
    
            // Check if all product items were inserted successfully
            if ($insert) {   
                return response()->json([
                    "status" => true, 
                    "message" => "Bills created successfully" 
                ]);
            } else {
                return response()->json([
                    "status" => false, 
                    "message" => "Failed to create bills items" 
                ]);
            }
        } else {
            return response()->json([
                "status" => false, 
                "message" => "Failed to create bill" 
            ]);
        }
    }
}
