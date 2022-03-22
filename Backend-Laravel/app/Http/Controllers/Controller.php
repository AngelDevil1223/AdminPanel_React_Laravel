<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAuthUserRequest;
use App\Http\Requests\UpdateAuthUserRequest;
use Illuminate\Support\Facades\Storage;


use App\Models\userrequests;
use App\Models\vehicles;
use App\Models\rental;
use App\Models\updatelocations;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getRequests() {
    	$result = userrequests::all();
    	return response($result, 200);
    }

    public function userPermission(Request $request) {

    	$value = $request->formdata['value'];
    	$id = $request->formdata['id'];
    	$result = userrequests::where('id', $id)->update(['status'=>$value]);
    	$user = userrequests::where('id', $id)->first();
    	$user = $user->userid;
    	$carid = userrequests::where('id', $id)->first();
    	$carid = $carid->carid;
    	if($value == "True")
    		$result = Cars::where('id', $carid)->update(['user_id' => $user, 'car_is_active' => 'Yes']);
    	else
    		$result = Cars::where('id', $carid)->update(['user_id' => "" , 'car_is_active' => 'No']);
    	return response($result, 200);
    }

    public function postRequest(Request $request) {
        $userrequest = new userrequests;
        $userrequest->userid = $request->userid;
        $userrequest->carid = $request->carid;
        $userrequest->status = "False";
        $userrequest->save();
        return response("success", 200);
    }

    //add vehicle
    public function addVehicle(Request $request) {
        $newvehicle = new vehicles;
        $newvehicle->ownerIdNum = $request->ownerIdentifyNumber;
        $newvehicle->ownerbirthhij = $request->ownerDateOfBirthHijri;
        $newvehicle->ownerbirthgre = $request->ownerDateOfBirthGregorian;
        $newvehicle->seqnum = $request->sequenceNumber;
        $newvehicle->rplateletter = $request->plateLetterRight;
        $newvehicle->mplateletter = $request->plateLetterMiddle;
        $newvehicle->lplateletter = $request->plateLetterLeft;
        $newvehicle->platenum = $request->plateNumber;
        $newvehicle->platetype = $request->plateType;
        $newvehicle->currentlessor = "";
        $newvehicle->status = "None";
        $newvehicle->save();

        return response()->json([
            "success"=>true,
            "resultCode"=>"success",
            "result" => [
                "eligibility" => "VALID",
            ],
        ], 200);
    }

    // get All vehicles
    public function getAllVehicles() {
        $result = vehicles::all();

        return response($result , 200);
    }

    // post rentle
    public function addRentle(Request $request) {
        $addrentle = new rental;
        $addrentle->seqnum = $request->sequenceNumber;
        $addrentle->comproperid = $request->companyRentalOperationId;
        $addrentle->pickuplatitude = $request->pickupLatitude;
        $addrentle->pickuplongitude = $request->pickupLongitude;
        $addrentle->dropofflatitude = $request->dropoffLatitude;
        $addrentle->dropofflongitude = $request->dropoffLongitude;
        $addrentle->pickuptimestamp = $request->pickupTimeStamp;
        $addrentle->dropofftimestamp = $request->dropoffTimeStamp;
        $addrentle->rentalperiodmins = $request->rentalVehicleperiodmins;
        $addrentle->customervehiclerating = $request->customerVehicleRating;
        $addrentle->customerservicerating = $request->customerServiceRating;
        $addrentle->save();

        return response()->json([
            "success"=>true,
            "resultCode"=>"success",
        ], 200);
    }

    // post update current location
    public function postLocation(Request $request) {
        //  IF from react then $request[$i]->... or $request[$i]['']...
        // POSTMAN => return response($request->locations[0]['vehicleSequenceNumber'], 200);
        $length = count($request->locations);
        $j = 0;
        $temp = [];
        for($i = 0 ; $i < $length ; $i++) {
            if(!vehicles::where('seqnum' , $request->locations[$i]['vehicleSequenceNumber'])->exists()) {
                $temp[$j] = $request->locations[$i]['vehicleSequenceNumber'];
                $j ++;
                continue;
            }
            $data = new updatelocations;
            $data->vehicleseqnum = $request->locations[$i]['vehicleSequenceNumber'];
            $data->latitude = $request->locations[$i]['latitude'];
            $data->longitude = $request->locations[$i]['longitude'];
            $data->updatewhen = $request->locations[$i]['updatedWhen'];
            $data->hascustomer = $request->locations[$i]['hasCustomer'];
            if($request->locations[$i]['hasCustomer'] == "0")
                $data->cuslocation = "vacant";
            else
                $data->cuslocation = "occupied";
            $data->save();
        }
        if($j == 0)
        {
            return response()->json([
                "success" => true,
                "resultCode" => "success",
                "result" => [
                    "failedVehicles" => [
                        "sequenceNumber" => "None",
                        "reason" => "vehicle_all_found"
                    ]
                ]
            ]);
        }
        else {
            $resultstring = "";
            for($i = 0; $i < $j ; $i ++) {
                $resultstring = $resultstring . $temp[$i] . ",";
            }

            return response()->json([
                "success" => true,
                "resultCode" => "fail",
                "result" => [
                    "failedVehicles" => substr_replace($resultstring, "", -1),
                    "reason" => "vehicle_not_found",
                ]
            ]);
        }
    }

    // Get All rentals
    public function getRentels() {
        $data = rental::all();

        return response($data , 200);
    }

    // Get All update current locations
    public function getUpdatelocations() {
        $data = updatelocations::all();

        return response($data, 200);
    }
}