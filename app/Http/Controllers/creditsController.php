<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class creditsController extends Controller
{
    public function creditWorthiness(Request $request){
        $this->validate($request, [
            "created_at" => "required",
            "presale_estimation"=> "required",
            "last_order_date" => "required",
            "business_type" => "required"
        ]);
        $sum = 0;
        $cutoff = 2;
        $sum += $this->businessExperienceScore(Carbon::parse($request->created_at));
        $sum += $this->preSaleEstimationScore($request->presale_estimation);
        $sum += $this->businessActivityScore(Carbon::parse($request->last_order_date));
        $sum += $this->businessTypeScore($request->business_type);

        return $sum;

    }

    public function businessExperienceScore($created_at){

        if(Carbon::now()->greaterThan($created_at->addMonths(6))){
            return 1*0.25;
        }
        elseif(Carbon::now()->toDateString() == $created_at->addMonths(6)->toDateString()){
            return 2*0.25;
        }
        elseif(Carbon::now()->between($created_at->addMonths(6), $created_at->addMonths(12))){
            return 3*0.25;
        }
        else{
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
        
        if(Carbon::now()->lessThan($latest_order_date->addMonths(3))){
            return 1*0.25;
        }
        elseif(Carbon::now()->toDateString() == $latest_order_date->addMonths(2)->toDateString()){
            return 2*0.25;
        }
        elseif(Carbon::now()->toDateString() == $latest_order_date->addMonths(1)->toDateString()){
            return 3*0.25;
        }
        else{
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

    public function creditScore(){
        $this->validate($request, [
            "payment_history" => "required",
            "credit_utilization" => "required",
            "item_type" => "required",
            "transaction_history" => "required",
            "business_activity" => "required"
        ]);
    }
}
