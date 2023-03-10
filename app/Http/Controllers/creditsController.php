<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Parameter;
class creditsController extends Controller
{
    public function creditWorthiness(Request $request){
        $parameters = Parameter::where('client_id', $request->client_id)->first();
        
        $worthiness = json_decode($parameters->worthiness);
        
        $sum = 0;
        $cutoff = $parameters->worthiness_cutoff;

        $sum += $this->businessExperienceScore(Carbon::parse($request->created_at),$worthiness->created_at);//var_dump($this->businessExperienceScore(Carbon::parse($request->created_at)));
        $sum += $this->preSaleEstimationScore($request->presale_estimation,$worthiness->presale_estimation);//var_dump($this->preSaleEstimationScore($request->presale_estimation));
        $sum += $this->businessActivityScore(Carbon::parse($request->last_order_date),$worthiness->last_order_date);//var_dump($this->businessActivityScore(Carbon::parse($request->last_order_date)));
        $sum += $this->businessTypeScore($request->business_type, $worthiness->business_type);//var_dump($this->businessTypeScore($request->business_type));

        
        return $sum >= $cutoff;

    }

    public function businessExperienceScore($created_at, $worthiness){
        $weight = $worthiness->weight;
        if(Carbon::now()->diffInDays($created_at) < 180){
            return $worthiness->values->new*$weight;
        }
        elseif(Carbon::now()->diffInDays($created_at) >= 180 && Carbon::now()->diffInDays($created_at) < 210){
            return $worthiness->values->six*$weight;
        }
        elseif(Carbon::now()->diffInDays($created_at) >= 210 && Carbon::now()->diffInDays($created_at) < 366){
            return $worthiness->values->six_to_twelve*$weight;
        }
        elseif(Carbon::now()->diffInDays($created_at) >= 366){
            return $worthiness->values->one_and_up*$weight;
        }

    }

    public function preSaleEstimationScore($estimation, $worthiness){
        $weight = $worthiness->weight;

        if($estimation == 'BAD'){
            return $worthiness->values->BAD * $weight;
        }
        elseif($estimation == 'MEDIUM'){
            return $worthiness->values->MEDIUM * $weight;
        }
        elseif($estimation == 'GOOD'){
            return $worthiness->values->GOOD * $weight;
        }
        elseif($estimation == 'EXCELLENT'){
            return $worthiness->values->EXCELLENT * $weight;
        }
    }

    public function businessActivityScore($latest_order_date, $worthiness){
        $weight = $worthiness->weight;

        if(Carbon::now()->diffInDays($latest_order_date) >= 90){
            return $worthiness->values->three_and_up*$weight;
        }
        elseif(Carbon::now()->diffInDays($latest_order_date) >= 60 && Carbon::now()->diffInDays($latest_order_date) < 90){
            return $worthiness->values->two*$weight;
        }
        elseif(Carbon::now()->diffInDays($latest_order_date) >= 30 && Carbon::now()->diffInDays($latest_order_date) < 60){
            return $worthiness->values->one*$weight;
        }
        elseif(Carbon::now()->diffInDays($latest_order_date) < 30){
            return $worthiness->values->one_less*$weight;
        }
    }

    public function businessTypeScore($business_type, $worthiness){
        $weight = $worthiness->weight;
        if($business_type == 'KIOSK'){
            return $worthiness->values->KIOSK*$weight;
        }
        elseif($business_type == 'OUTLET'){
            return $worthiness->values->OUTLET*$weight;
        }
        elseif($business_type == 'MINIMARKET'){
            return $worthiness->values->MINIMARKET*$weight;
        }
        elseif($business_type == 'SUPERMARKET'){
            return $worthiness->values->SUPERMARKET*$weight;
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
            "unpaid_credit" => "required",
            "credit_coeficient" => "required",
            "past_month_orders" => "required",
            "client_id" => "required",
            "credit_payment" => "required"
        ]);
        $data = [];
        $parameters = Parameter::where('client_id', $request->client_id)->first();
        if(!$parameters){
            return response("Parameters are not initialized!", 422);
        }
        $sum = 0;
        $cutoff = 2;
        if(!$this->creditWorthiness($request)){
            return response("Credit can not be issued.", 422);
        }
        $creditScore = json_decode($parameters->credit_score);


        $sum += $this->payment_history($request->payment_history,$creditScore->payment_history);
        $sum += $this->credit_utilization($request->credit_utilization,$creditScore->credit_utilization);
        $sum += $this->item_type($request->item_type,$creditScore->item_type);
        $sum += $this->transaction_history($request->transaction_history,$creditScore->transaction_history);
        $sum += $this->last_order_score(Carbon::parse($request->last_order_date),$creditScore->last_order_date);

        if($sum < 0){
            return response("Credit can not be issued.", 422);
        }
        $maxScore = $this->getMaxScore($creditScore);
        $available_credit = round($sum/$maxScore * $request->past_month_orders * $request->credit_coeficient, 2) - round($request->unpaid_credit);

        if($available_credit < 0){
            return response("Credit can not be issued.", 422);
        }

        $data["max_score"] = round($maxScore,2);
        $data["credit_score"] = round($sum,2);
        $data["available_credit"] = $available_credit;
        $data["credit_payment"] = (float)$request->credit_payment;
        return $data;
    }

    public function payment_history($payment_history, $creditScore){

        $weight = $creditScore->weight;

        if($payment_history == 'NO_CREDIT'){
            return $creditScore->values->NO_CREDIT*$weight;
        }
        elseif($payment_history == 'PAID_ON_TIME'){
            return $creditScore->values->PAID_ON_TIME*$weight;
        }
        elseif($payment_history == 'PAID_LATE'){
            return $creditScore->values->PAID_LATE*$weight;
        }
        elseif($payment_history == 'DEFAULT'){
            return $creditScore->values->DEFAULT*$weight;
        }
    }

    public function credit_utilization($credit_utilization, $creditScore){

        $weight = $creditScore->weight;
        if($credit_utilization == 'NO_DEBT'){
            return $creditScore->values->NO_DEBT*$weight;
        }
        elseif($credit_utilization == 'HALF_PAID'){
            return $creditScore->values->HALF_PAID*$weight;
        }
        elseif($credit_utilization == 'UNPAID_BILL'){
            return $creditScore->values->UNPAID_BILL*$weight;
        }
        elseif($credit_utilization == 'EXCEED_LIMIT'){
            return $creditScore->values->EXCEED*$weight;
        }
    }

    public function item_type($item_type, $creditScore){

        $weight = $creditScore->weight;
        if($item_type == 'CATEGORY_A'){
            return $creditScore->values->CATEGORY_A*$weight;
        }
        elseif($item_type == 'CATEGORY_B'){
            return $creditScore->values->CATEGORY_B*$weight;
        }
        elseif($item_type == 'CATEGORY_C'){
            return $creditScore->values->CATEGORY_C*$weight;
        }
    }

    public function transaction_history($transaction, $creditScore){

        $weight = $creditScore->weight;
        if($transaction < 100000){
            return $creditScore->values->ONE_LESS*$weight;
        }
        elseif($transaction >= 100000 && $transaction < 200000){
            return $creditScore->values->ONE_TO_TWO*$weight;
        }
        elseif($transaction >= 200000 && $transaction < 300000){
            return $creditScore->values->TWO_TO_THREE*$weight;
        }
        elseif($transaction >= 300000){
            return $creditScore->values->THREE_ABOVE*$weight;
        }
    }

    public function last_order_score($latest_order_date, $creditScore){

        $weight = $creditScore->weight;
        
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

    public function getMaxScore($creditScore){
        $max_score = 0;
        
        $max_score += $creditScore->item_type->weight * collect($creditScore->item_type->values)->flatten()->max();
        $max_score += $creditScore->last_order_date->weight * collect($creditScore->last_order_date->values)->flatten()->max();
        $max_score += $creditScore->payment_history->weight * collect($creditScore->payment_history->values)->flatten()->max();
        $max_score += $creditScore->credit_utilization->weight * collect($creditScore->credit_utilization->values)->flatten()->max();
        $max_score += $creditScore->transaction_history->weight * collect($creditScore->transaction_history->values)->flatten()->max();

        
        return $max_score;
    }

    public function worthinessMaxScore($worthiness){
        $max_score = 0;

        $max_score += $worthiness->created_at->weight * collect($worthiness->created_at->values)->flatten()->max();
        $max_score += $worthiness->last_order_date->weight * collect($worthiness->last_order_date->values)->flatten()->max();
        $max_score += $worthiness->presale_estimation->weight * collect($worthiness->presale_estimation->values)->flatten()->max();
        $max_score += $worthiness->business_type->weight * collect($worthiness->business_type->values)->flatten()->max();

        return $max_score;
    }
}
