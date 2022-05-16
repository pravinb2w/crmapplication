<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySettings;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\LandingPages;
use CommonHelper;

use Illuminate\Support\Facades\Validator;

class LandingController extends Controller
{
    public function index($permalink=null)
    {
        $info           = CompanySettings::find(1);
        $params['info'] = $info;
        if($permalink  != null) {
            $result   = LandingPages::where('permalink', '=', $permalink)->first();
            if(empty($result)) {
                $result   = LandingPages::latest()->first();
            }
        }else {
            $result   = LandingPages::latest()->first();
        }
        return view('landing.landing', $params, compact('result'));
    } 
    public function enquiry_save(Request $request) {
        $id = $request->id;
        
        $role_validator = [
            'fullname'  => [ 'required', 'string', 'max:255'],
            'email'     => [ 'required', 'string','email', 'max:255'],
            'mobile_no' => [ 'required', 'string', 'digits:10'],
            'subject'   => [ 'required', 'string', 'max:255'],
            'message'   => [ 'required', 'string', 'max:255'],
        ];
        //Validate the product
        $validator      =   Validator::make( $request->all(), $role_validator );
        
        if ($validator->passes()) {
            $customer = Customer::where('email',$request->email)->first();

            if( isset($customer) && !empty($customer)) {
                $customer_id = $customer->id;
            } else {
                $ins['status'] = 1;
                $ins['first_name'] = $request->fullname;
                $ins['email'] = $request->email;
                $ins['mobile_no'] = $request->mobile_no;
                $ins['added_by'] = 1;
                $customer_id = Customer::create($ins)->id;
            }
            //get assigned user id 
            $assigned_to = CommonHelper::getLeadAssigner();
            $lea['assigned_to'] = $assigned_to;

            $lea['customer_id'] = $customer_id;
            $lea['status'] = 1;
            $lea['added_by'] = 1;
            $lea['lead_subject'] = $request->subject;
            $lea['lead_description'] = $request->message;
            $lead_id = Lead::create($lea)->id;
            //insert in notification
            CommonHelper::send_lead_notification($lead_id, $assigned_to);
            $success = 'Enquiry has been sent';
            return response()->json(['error'=>[$success], 'status' => '0']);
        }
        return response()->json(['error'=>$validator->errors()->all(), 'status' => '1']);
    } 
}