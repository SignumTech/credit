<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Parameter;
class creditsController extends Controller
{
    public function creditWorthiness(Request $request){
        $parameters = Parameter::where('client_id', $request->client_id)->first();
        $worthiness = json_decode($parameters);
        dd($worthiness);
        $sum = 0;
        $cutoff = 2;

        $sum += $this->businessExperienceScore(Carbon::parse($request->created_at));//var_dump($this->businessExperienceScore(Carbon::parse($request->created_at)));
        $sum += $this->preSaleEstimationScore($request->presale_estimation, );//var_dump($this->preSaleEstimationScore($request->presale_estimation));
        $sum += $this->businessActivityScore(Carbon::parse($request->last_order_date));//var_dump($this->businessActivityScore(Carbon::parse($request->last_order_date)));
        $sum += $this->businessTypeScore($request->business_type);//var_dump($this->businessTypeScore($request->business_type));

        return $sum >= $cutoff;

    }

    public function businessExperienceScore($created_at){
        
        if(Carbon::now()->diffInDays($created_at) < 180){
            return 1*0.25;
        }
        elseif(Carbon::now()->diffInDays($created_at) >= 180 && Carbon::now()->diffInDays($created_at) < 210){
            return 2*0.25;
        }
        elseif(Carbon::now()->diffInDays($created_at) >= 210 && Carbon::now()->diffInDays($created_at) < 366){
            return 3*0.25;
        }
        elseif(Carbon::now()->diffInDays($created_at) >= 366){
            return 4*0.25;
        }

    }

    public function preSaleEstimationScore($estimation){
        if($estimation == 'BAD'){
            return 1*0.25;
        }
        elseif($estimation == 'MEDIUM'){
            return 2*0.25;
        }
        elseif($estimation == 'GOOD'){
            return 3*0.25;
        }
        elseif($estimation == 'EXCELLENT'){
            return 4*0.25;
        }
    }

    public function businessActivityScore($latest_order_date){
        
        if(Carbon::now()->diffInDays($latest_order_date) >= 90){
            return 1*0.25;
        }
        elseif(Carbon::now()->diffInDays($latest_order_date) >= 60 && Carbon::now()->diffInDays($latest_order_date) < 90){
            return 2*0.25;
        }
        elseif(Carbon::now()->diffInDays($latest_order_date) >= 30 && Carbon::now()->diffInDays($latest_order_date) < 60){
            return 3*0.25;
        }
        elseif(Carbon::now()->diffInDays($latest_order_date) < 30){
            return 4*0.25;
        }
    }

    public function businessTypeScore($business_type){
        if($business_type == 'KIOSK'){
            return 1*0.25;
        }
        elseif($business_type == 'OUTLET'){
            return 2*0.25;
        }
        elseif($business_type == 'MINIMARKET'){
            return 3*0.25;
        }
        elseif($business_type == 'SUPERMARKET'){
            return 4*0.25;
        }
    }

    public function creditScore(Request $request){
        $this->validate($request, [
            "payment_history" => "required",
            "credit_utilization" => "required",
            "item_type" => "required",
            "transaction_history" => "required",
            "created_at" => "required",
            "presale_estimation"=> "required",
            "last_order_date" => "required",
            "business_type" => "required",
            "client_id" => "required"
        ]);
        
        $sum = 0;
        $cutoff = 2;
        if(!$this->creditWorthiness($request)){
            return response("Credit can not be issued.", 422);
        }
        $parameters = Parameter::where('client_id', $request->client_id)->first();


        $sum += $this->payment_history($request->payment_history);
        $sum += $this->credit_utilization($request->credit_utilization);
        $sum += $this->item_type($request->item_type);
        $sum += $this->transaction_history($request->transaction_history);
        $sum += $this->last_order_score(Carbon::parse($request->last_order_date));

        return $sum;
    }

    public function payment_history($payment_history){
        if($payment_history == 'NO_CREDIT'){
            return 0*0.35;
        }
        elseif($payment_history == 'PAID_ON_TIME'){
            return 1*0.35;
        }
        elseif($payment_history == 'PAID_LATE'){
            return -1*0.35;
        }
        elseif($payment_history == 'DEFAULT'){
            return -5*0.35;
        }
    }

    public function credit_utilization($credit_utilization){
        if($credit_utilization == 'NO_DEBT'){
            return 4*0.3;
        }
        elseif($credit_utilization == 'HALF_PAID'){
            return 2*0.3;
        }
        elseif($credit_utilization == 'UNPAID_BILL'){
            return -1*0.3;
        }
        elseif($credit_utilization == 'EXCEED_LIMIT'){
            return -2*0.3;
        }
    }

    public function item_type($item_type){
        if($item_type == 'BEVERAGE'){
            return 1*0.1;
        }
        elseif($item_type == 'HOUSEHOLD'){
            return 3*0.1;
        }
        elseif($item_type == 'FOOD'){
            return 4*0.1;
        }
    }

    public function transaction_history($transaction){
        if($transaction < 100000){
            return 1*0.15;
        }
        elseif($transaction >= 100000 && $transaction < 200000){
            return 2*0.15;
        }
        elseif($transaction >= 200000 && $transaction < 300000){
            return 3*0.15;
        }
        elseif($transaction >= 300000){
            return 4*0.15;
        }
    }

    public function last_order_score($latest_order_date){
        
        if(Carbon::now()->diffInDays($latest_order_date) >= 90){
            return 1*0.1;
        }
        elseif(Carbon::now()->diffInDays($latest_order_date) >= 60 && Carbon::now()->diffInDays($latest_order_date) < 90){
            return 2*0.1;
        }
        elseif(Carbon::now()->diffInDays($latest_order_date) >= 30 && Carbon::now()->diffInDays($latest_order_date) < 60){
            return 3*0.1;
        }
        elseif(Carbon::now()->diffInDays($latest_order_date) < 30){
            return 4*0.1;
        }
    }
}
