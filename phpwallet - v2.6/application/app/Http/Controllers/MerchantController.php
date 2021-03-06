<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request; 

class MerchantController extends Controller
{
    public function index(Request $request){
    	$merchants = Merchant::where('user_id', Auth::user()->id)->orderby('created_at', 'desc')->paginate(5);
    	return 	view('merchant.index')
    			->with('merchants', $merchants);
    }

    public function new(Request $request){
        $currencies = Currency::all();
    	return 	view('merchant.new')
        ->with('currencies', $currencies);
    }

    public function integration(Request $request, Merchant $merchant){
        if ( $merchant and $merchant->user_id == Auth::user()->id) {
            return view('merchant.docs')
            ->with('merchant', $merchant)
            ->with('merchantArray', $merchant->toArray());
        }
        return back();
    }

    public function add(Request $request){

    	$this->validate($request, [
    		'merchant_name'	=> 'required|unique:merchants,name',
    		'merchant_site_url'	=>	'required|url',
            'merchant_currency' =>  'required|exists:currencies,id',
            'merchant_logo' =>  'nullable|image',
    		'merchant_success_link'	=>	'required|url',
    		'merchant_fail_link'	=>	'required|url',
    		'merchant_description'	=>	'required'
    	]);

        $currency = Currency::findorFail($request->merchant_currency);


    	$merchant = new Merchant();
    	$merchant->user_id = Auth::user()->id;
    	$merchant->name = $request->merchant_name;
        $merchant->currency_id = $currency->id;
    	$merchant->site_url = $request->merchant_site_url;
    	$merchant->success_link = $request->merchant_success_link;
    	$merchant->fail_link = $request->merchant_fail_link;
    	$merchant->description = $request->merchant_description;
    	$merchant->merchant_key = bcrypt(env('APP_KEY').now().Auth::user()->id);
    	$merchant->save();

    	return redirect(route('mymerchants'));
    }

    public function storefront(Request $request){
        
        if(Auth::check())
            Auth::logout();

        if ($request->has('merchant_key') and $request->has('invoice')) {

            $invoice = json_decode($request->invoice , true);

            dd($invoice);

            $merchant = Merchant::where('merchant_key', $request->merchant_key)->first();

            session()->put('merchant_key', $request->merchant_key);
            session()->put('merchant_key', $request->merchant_key);
            session()->put('sumary', $request->sumary);
            session()->put('item_name', $request->item_name);
            session()->put('amount', $request->amount);
            session()->put('invoice', $invoice);

            if($merchant){
                return  
                    view('merchant.storefront')
                    ->with('merchant', $merchant);   
            }

        }

        abort(404);
    }

    public function getStoreFront(Request $request, $ref){

        if(Auth::check())
            Auth::logout();

        $PurchaseRequest = PurchaseRequest::with('Transaction')->with('Currency')->where('ref', $ref)->first();

        if($PurchaseRequest == null)
        return abort(404); 

        if($PurchaseRequest->attempts >= 5 )
        return abort(404); 

        if ( ( $PurchaseRequest != null and $PurchaseRequest->is_expired == false )or session()->has('PurchaseRequest')) {
            $total = 0;

            $merchant = Merchant::where('merchant_key', $PurchaseRequest->merchant_key)->first();
            
            if($merchant == null)
            return abort(404);
            
            foreach ($PurchaseRequest->data->items as $item) {
                $total += ( $item->price * $item->qty );
            }
            session()->put('PurchaseRequest', $PurchaseRequest);
            session()->put('PurchaseRequestTotal', $total);

            if( $PurchaseRequest->is_expired == false ){
                $PurchaseRequest->is_expired = true ;
                $PurchaseRequest->save();
            }
        }
        
        $PurchaseRequest->attempts ++;
        $PurchaseRequest->save();

        return view('merchant.storefront')
        ->with('ref', $ref)
        ->with('merchant', $merchant);
    }
}
