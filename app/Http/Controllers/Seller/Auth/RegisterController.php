<?php

namespace App\Http\Controllers\Seller\Auth;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use App\Model\DayShop;
use App\Model\Day;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CPU\Helpers;

class RegisterController extends Controller
{
    public function create()
    {
        return view('seller-views.auth.register');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|unique:sellers',
            'shop_address' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'shop_name' => 'required',
            'phone' => 'required',
            'password' => 'required|min:8',
        ]);

        DB::transaction(function ($r) use ($request) {
            $seller = new Seller();
            $seller->f_name = $request->f_name;
            $seller->l_name = $request->l_name;
            $seller->phone = $request->phone;
            $seller->email = $request->email;
            $seller->brand_id = $request->brand_id;
            $seller->image = ImageManager::upload('seller/', 'png', $request->file('image'));
            $seller->password = bcrypt($request->password);
            $seller->status =  $request->status == 'approved'?'approved': "pending";
            $seller->save();

            $shop = new Shop();
            $shop->seller_id = $seller->id;
            $shop->name = $request->shop_name;
            $shop->address = $request->shop_address;
            $shop->contact = $request->phone;
            $shop->image = ImageManager::upload('shop/', 'png', $request->file('logo'));
            $shop->banner = ImageManager::upload('shop/banner/', 'png', $request->file('banner'));
            $shop->save();

            DB::table('seller_wallets')->insert([
                'seller_id' => $seller['id'],
                'withdrawn' => 0,
                'commission_given' => 0,
                'total_earning' => 0,
                'pending_withdraw' => 0,
                'delivery_charge_earned' => 0,
                'collected_cash' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
        
        for($j=1; $j<8 ;$j++)
        {
            $shop_day = new DayShop();
            $shop_day->day_id = $j;
            $shop_day->shop_id = $shop->id;
            $shop_day->from_hours = '8';
            $shop_day->am_pm = "????????????";
            $shop_day->from_minutes = '00';
            $shop_day->to_hours = '08';
            $shop_day->to_minutes = '00';
            $shop_day->pm_am = "??????????";
            $shop_day->save();
        }
        });
        
        //from_hours_add($seller->id);

        
        if($request->status == 'approved'){
            Toastr::success('Shop apply successfully!');
            return back();
        }else{
            Toastr::success('Shop apply successfully!');
            return redirect()->route('seller.auth.login');
        }
        

    }
}
