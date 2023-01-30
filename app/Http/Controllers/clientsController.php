<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Parameter;
use App\Models\ParameterValue;
use App\Models\ParameterDetail;
class clientsController extends Controller
{
    public function getClients(Request $request){
        
        return $request->user()->clients->makeVisible([
            'secret'
        ]);
    }

    public function test(Request $request){
        $this->validate($request, [
            "test" => "required"
        ]);
        return "you posted ".$request->test;
    }

    public function showClient(Request $request, $id){
        $data = $request->user()->clients->toArray();
        
        $data = Arr::where($data, function($value, $key) use ($id){
            return $value['id'] == $id;
        });
        $data = array_values($data);
        return $data[0];
    }

    public function getParameters($id){
        $parameters = Parameter::where('client_id', $id)->first();
        if(!$parameters){
            return response("NOT INITIALIZED", 422);
        }

        return $parameters;
    }

    public function initializeParameters($id){

        $parameter = Parameter::where('client_id', $id)->first();
        if($parameter){
            return response("Already Initialized", 422);
        }
        if($this->initializeWorthiness($id)){
            $this->initializeCreditScore($id);
        }

        return response("Succussfully Initialized!", 200);
    }

    public function initializeWorthiness($id){
        $data = [];
        $data["payment_history"]["weight"] = 0.35;
        $value = [];
        $value["NO_CREDIT"] = 0;
        $value["PAID_ON_TIME"] = 1;
        $value["PAID_LATE"] = -1;
        $value["DEFAULT"] = -5;
        $data["payment_history"]["values"] = $value;
        
        $data["credit_utilization"]["weight"] = 0.30;
        $value = [];
        $value["NO_DEBT"] = 4;
        $value["HALF_PAID"] = 2;
        $value["UNPAID_BILL"] = -1;
        $value["EXCEED"] = -2;
        $data["credit_utilization"]["values"] = $value;
        
        $data["item_type"]["weight"] = 0.1;
        $value = [];
        $value["CATEGORY_A"] = 1;
        $value["CATEGORY_B"] = 3;
        $value["CATEGORY_C"] = 4;
        $data["item_type"]["values"] = $value;
        
        $data["transaction_history"]["weight"] = 0.15;
        $value = [];
        $value["ONE_LESS"] = 1;
        $value["ONE_TO_TWO"] = 2;
        $value["TWO_TO_THREE"] = 3;
        $value["THREE_ABOVE"] = 4;
        $data["transaction_history"]["values"] = $value;

        $data["last_order_date"]["weight"] = 0.1;
        $value = [];
        $value['three_and_up'] = 1;
        $value['two'] = 2;
        $value['one'] = 3;
        $value['one_less'] = 4;
        $data['last_order_date']['values'] = $value;

        $parameters = new Parameter;
        $parameters->client_id = $id;
        $parameters->credit_score = json_encode($data);
        $parameters->save();
        if($parameters){
            return true;
        }
        else{
            return false;
        }
        
    }

    public function initializeCreditScore($id){
        $data = [];
        $data["created_at"]["weight"] = 0.25;
        $value = [];
        $value["new"] = 1;
        $value["six"] = 2;
        $value["six_to_twelve"] = 3;
        $value["one_and_up"] = 4;
        $data["created_at"]["values"] = $value;

        $data['presale_estimation']["weight"] = 0.25;
        $value = [];
        $value["BAD"] = 1;
        $value["MEDIUM"] = 2;
        $value["GOOD"] = 3;
        $value["EXCELLENT"] = 4;
        $data["presale_estimation"]['values'] = $value;

        $data['last_order_date']["weight"] = 0.25;
        $value = [];
        $value['three_and_up'] = 1;
        $value['two'] = 2;
        $value['one'] = 3;
        $value['one_less'] = 4;
        $data['last_order_date']['values'] = $value;

        $data['business_type']['weight'] = 0.25;
        $value = [];
        $value['KIOSK'] = 1;
        $value['OUTLET'] = 2;
        $value['MINIMARKET'] = 3;
        $value['SUPERMARKET'] = 4;
        $data['business_type']['values'] = $value;

        $parameters = Parameter::where("client_id",$id)->first();
        $parameters->worthiness = json_encode($data);
        $parameters->save();

        return $parameters;
    }

    public function updateWorthiness(Request $request, $id){
        $parameters = Parameter::where('client_id', $id)->first();
        $parameters->worthiness = json_encode($request->data);
        $parameters->save();
    }

    public function updateCreditScore(Request $request, $id){
        $parameters = Parameter::where('client_id', $id)->first();
        $parameters->credit_score = json_encode($request->data);
        $parameters->save();
    }



    
}
