<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Resturant;
use App\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validater = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:clients',
            'phone' => 'required',
            'image' => 'required',
            'description' => 'required',
            'city_id' => 'required',
            'region_id' => 'required',
            'password' => 'required|confirmed',
        ]);
        if ($validater->fails()) {
            return responseJson(0, $validater->errors()->first(), $validater->errors());
        }

        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = str_random(60);
        $client->save();
        return responseJson(1, 'done', [
            'api_token' => $client->api_token,
            'client' => $client
        ]);
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'required',
            'password' => 'required',


        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $client = Client::where('email', $request->email)->first();

        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                return responseJson(1, 'تم تسجيل الدخول بنجاح', [
                    'api_token' => $client->api_token,
                    'client' => $client
                ]);
            } else {
                return responseJson(0, 'خطا فى تسجيل الدخول');
            }

        } else {
            return responseJson(0, 'خطا فى تسجيل الدخول');
        }
    }

    public function reset(Request $request)
    {
        $validator = validator::make($request->all(), [
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            $data = $validator->errors();
            return responseJson(0, $validator->errors()->first(), $data);
        }
        $user = Client::where('phone', $request->phone)->first();
        if ($user) {
            $code = rand(1111, 9999);
            $update = $user->update(['pin_code' => $code]);
            if ($update) {
                //send email
                Mail::to($user->email)
                    // ->cc($moreUsers)
                    ->cc("abdobelal069@gmail.com")
                    //->bcc(["abdobelal069@gmail.com"])
                    ->send(new ResetPassword($user));

                return responseJson(1, 'برجاء فحص هاتفك', [
                    'pin_code_for_test' => $code
                ]);

            } else {
                return responseJson(0, 'حاول مره اخرى');

            }
        } else {
            return responseJson(0, 'حاول مره اخرى');
        }
    }

    public function password(Request $request)
    {
        $validator = validator::make($request->all(), [
            'pin_code' => 'required',
            'password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            $date = $validator->errors();

            return responseJson(0, $validator->errors()->first(), $date);
        }
        $user = Client::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)
            ->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;
            if ($user->save()) {
                return responseJson(1, 'تم تغيير كلمه المرور بنجاح');
            } else {
                return responseJson(0, 'حدث خطا حاول مره آخرى');
            }

        } else {
            return responseJson(0, 'هذا الكود غير صالح');
        }

    }

    public function profile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id)

        ]);
        if ($validator->fails()) {
            $data = $validator->errors();
            return responseJson(0, $validator->errors()->first(), $data);
        }
        $LoginUser = $request->user();
        $LoginUser->update($request->all());
        if ($request->has('password')) {
            $LoginUser->password = bcrypt($request->password);
            $LoginUser->save();
        }
        $data = ['user' => $request->user()->fresh()];
        return responseJson(1, 'تم التعديل بنجح', $data);
    }

    public function restregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'region_id' => 'required',
            'password' => 'required',
            'email' => 'required',
            'status' => 'required|in:open,close',
            'image' => 'required',
            'less_order' => 'required',
            'delivery_value' => 'required',
            'phone' => 'required',
            'whatsapp' => 'required'

        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $resturant = Resturant::create($request->all());
        $resturant->api_token = str_random(60);
        $resturant->save();
        return responseJson(1, 'done', [
            'api_token' => $resturant->api_token,
            'resturant' => $resturant
        ]);
    }

    public function resturantlogin(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'required',
            'password' => 'required',


        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $resturant = Resturant::where('email', $request->email)->first();

        if ($resturant) {
            if (Hash::check($request->password, $resturant->password)) {
                return responseJson(1, 'تم تسجيل الدخول بمجاح', [
                    'api_token' => $resturant->api_token,
                    'resturant' => $resturant

                ]);
            } else {
                return responseJson(0, 'خطا فى تسجيل الدخول');
            }

        } else {
            return responseJson(0, 'خطا فى تسجيل الدخول');
        }
    }

    public function resturantreset(Request $request)
    {
        $validator = validator::make($request->all(), [
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            $data = $validator->errors();
            return responseJson(0, $validator->errors()->first(), $data);
        }
        $user = Resturant::where('phone', $request->phone)->first();
        if ($user) {
            $code = rand(1111, 9999);
            $update = $user->update(['pin_code' => $code]);
            if ($update) {
                //send email
                Mail::to($user->email)
                    // ->cc($moreUsers)
                    ->cc('abdobelal069@gmail.com')
                    //->bcc("abdobelal069@gmail.com")
                    ->send(new ResetPassword($user));

                return responseJson(1, 'برجاء فحص هاتفك', [
                    'pin_code_for_test' => $code
                ]);

            } else {
                return responseJson(0, 'حاول مره اخرى');

            }
        } else {
            return responseJson(0, 'حاول مره اخرى');
        }
    }

    public function resturantpassword(Request $request)
    {
        $validator = validator::make($request->all(), [
            'pin_code' => 'required',
            'password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            $date = $validator->errors();

            return responseJson(0, $validator->errors()->first(), $date);
        }
        $user = Resturant::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)
            ->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;
            if ($user->save()) {
                return responseJson(1, 'تم تغيير كلمه المرور بنجاح');
            } else {
                return responseJson(0, 'حدث خطا حاول مره آخرى');
            }

        } else {
            return responseJson(0, 'هذا الكود غير صالح');
        }
    }

    public function reProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('resturants')->ignore($request->user()->id),
            'phone' => Rule::unique('resturants')->ignore($request->user()->id)

        ]);
        if ($validator->fails()) {
            $data = $validator->errors();
            return responseJson(0, $validator->errors()->first(), $data);
        }
        $LoginUser = $request->user();
        $LoginUser->update($request->all());
        if ($request->has('password')) {
            $LoginUser->password = bcrypt($request->password);
            $LoginUser->save();
        }
        $data = ['user' => $request->user()->fresh()];
        return responseJson(1, 'تم التعديل بنجح', $data);
    }

    public function registerToken(Request $request)
    {
        $validation = validator::make($request->all(), [

            'token' => 'required',
            'type' => 'required|in:android,ios'
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson(1, 'تم التسجيل بنجاح');
    }

    public function removeToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        Token::where('token', $request->token)->delete();
        return responseJson('token', 'تم الحذف بنجاح');
    }

    public function reregisterToken(Request $request)
    {
        $validation = validator::make($request->all(), [

            'token' => 'required',
            'type' => 'required|in:android,ios'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson(1, 'تم التسجيل بنجاح');
    }

    public function reremoveToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        Token::where('token', $request->token)->delete();
        return responseJson('token', 'تم الحذف بنجاح');
    }

    public function newOrder(Request $request){
        $validator = validator::make($request->all() ,[
            'resturant_id' => 'required',
            'products.*.product_id' => 'required',
            'products.*.quantity' => 'required',
            'address' => 'required',
            'payment_method_id' => 'required',
        ]);
        if($validator->fails()){
            $data = $validator->errors();
            return responseJson(0 , $validator->errors()->first() , $data);
        }
        $resturants = Resturant::find($request->resturant_id);
        if($resturants->status  == 'closed'){
            return responseJson(0,'errors');
        }

        $orders = $request->user()->orders()->create([
            'resturant_id' => $request->resturant_id,
            'note' => $request->note,
            'status' => $request->status,
            'address' => $request->address,
            'payment_method_id' => $request->payment_method_id,
        ]);
        $cost = 0 ;
        $delivery_cost = $resturants->delivery_cost;
        foreach($request->products as $prod){
            $product = Product::find($prod['product_id']);
            $readyProduct = [
                $prod['product_id'] => [
                    'quantity' => $prod['quantity'],
                    'price' => $product->price,
                    'note' => (isset($prod['note'])) ? $prod['note']: ''
                ]
            ];
            $orders->products()->attach($readyProduct);
            $cost += ($product->price * $prod['quantity']);
        }
        if($cost >= $resturants->minimum_charger){
            $total = $cost + $delivery_cost;
            $commission = settings()->commisson * $cost;
            $net = $total - settings()->commission;
            $update = $orders->update([
                'cost' => $cost,
                'delivery_cost' => $delivery_cost,
                'total' => $total,
                'commission' => $commission,
                'net' => $net,
            ]);
            //Notificatios
            $resturants->notifications()->create([
                'title' =>'لديك طلب جديد',
                'body' => 'hi mahdy',
                'action' =>  'new-order',
                'order_id' => $orders->id,
            ]);
            $send ="";
            $tokens = $resturants->tokens()->where('token', '!=' ,'')->pluck('token')->toArray();
            info("tokens result: " . json_encode($tokens));
            if(count($tokens))
            {
                public_path();
                $title = $resturants->title;
                $body = $resturants->body;
                $data =[
                    'order_id' => $orders->id,
                    'user_type' => 'resturant',

                ];
                $send = notifyByFirebase($title  ,$body  ,$tokens , $data);
                info("firebase result: " . $send);


            }

            $data =[
                'orders' =>$orders->fresh()->load('products'),
            ];
            return responseJson(1 , 'تم الطلب بنجاح', $data);
        }else{
            $orders->products()->delete();
            $orders->delete();
            return responseJson(0 , 'الطلب لابد ان يكون اقل من '.$resturants->minimum_charger. 'ريال');
        }
    }//

}

