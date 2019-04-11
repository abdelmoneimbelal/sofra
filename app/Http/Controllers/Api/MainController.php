<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\city;
use App\Item;
use App\Product;
use App\Setting;
use App\Region;
use App\Order;
use App\Offer;
use App\Resturant;
use App\Payment_method;
use App\Contact;
use Validator;
class MainController extends Controller
{
    public function cities()
    {
    	$data = City::all();
    	return responseJson(1,'success',$data);
    }
    public function regions(Request $request)
    {
    	$regions = Region::where(function($query) use ($request){
    	if($request->has('city_id'))
    	{
    		$query->where('city_id',$request->city_id);
    	   
    	}
    	})->get();
    	return responseJson(1,'success',$regions);
    }
     public function setting(){
      
    $setting = Setting::all();

    return responseJson(1,'success',$setting);
   
   }

   public function createorder(Request $request)
   {
   	$validator = Validator::make($request->all(),[
   		'title' => 'required',
   		'description' => 'required',
   		'rate' => 'required',
   		'status' => 'required',
   		'less_order' => 'required',
   		'delivery_value' => 'required',
   		'resturant_id' => 'required',
   		
   		'city_id' => 'required',
   		'payment_method_id' => 'required',
   		'notification_id' => 'required'
   	]);
   	$data = $validator->errors();
   	if($validator->fails())
   	{
   		return responseJson(0,$validator->errors()->first(),$data);
   	}else
   	{
   		$order = $request->user()->orders()->create($request->all());
   	}
   	return responseJson(1,'تم الطلب بنجاح',$order);

   }

    /*public function showorder(Request $request)
 {
    $order = Order::all();

        return responseJson(1,'success',$order);
    
   }
   */

   public function item()
   {
   	$item = Item::all();
   	return responseJson(1,'success',$item);
   }

   public function products(Request $request)
   {
   	$products = Product::where(function($query) use($request){
   		if($request->has('item_id')){
   			$query->where('item_id',$request->item_id);


   		}
   	})->get();
   	return responseJson(1,'done',$products);

   }
   public function resturant()
   {
   	$resturant = Resturant::all();
   	return responseJson(1,'done',$resturant);
   }
    public function offers()
   {
   	$resturant = Offer::all();
   	return responseJson(1,'done',$resturant);
   }

   public function resturantoffers(Request $request)
   {
   	$RestOffer = Offer::where(function($query) use($request){
   		if($request->has('resturant_id'));
   		{
   			$query->where('resturant_id',$request->returant_id);
   		}
   	})->get();
   	return responseJson(1,'done',$RestOffer);
   }

    public function payment(Request $request)
   {
   	$resturant = Payment_method::all();
   	return responseJson(1,'done',$resturant);
   }

   public function contacts(Request $request)
   {
   	$validator = Validator::make($request->all(),[
   		'name' => 'required',
   		'email' => 'required',
   		'phone' => 'required',
   		'content' => 'required',
   		'type' => 'required|in:complaint,enquiry,suggestion'
   	]);
   	$data = $validator->errors();
   	if($validator->fails())
   	{
   		return responseJson(0,$validator->errors()->first(),$data);
   	}
   	else{
   	// $contact = $request->user()->contacts()->create($request->all());
   	}
   //	return responseJson(1,'done',$contact);
   	
   	$contact = Contact::create($request->all());
   	
    return responseJson(1,'done',$contact);
    
   }


}
