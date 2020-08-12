<?php

namespace App\Http\Controllers\Relation;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Phone;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Patient;
use App\Models\Country;
use App\User;
use App\Models\Hospital;

class RelationsController extends Controller
{
    

    public function hasOneRelation() {

    	$user = User::with(['phone' => function($q) {
    		$q->select('code', 'phone', 'user_id');
    	}])->find(8);
    	// $phone = $user-> phone;
    	// $user->phone->code;	
		return response()->json($user);
    }



    public function hasOneRelationReverse() {

    	$phone = Phone::with(['user' => function($q) {
    		$q->select('id', 'age');
    	}])->find(1);
    	$phone->makeVisible('user_id');  // makeVisible(["", ""]);  male some attribute visible

    	//$phone->makeHidden(['code']);   Make Some Attribute Hidden

    	//return $phone->user->email;  return user of This Phone

    	return $phone;
    }



    public function getUserHasPhone() {
    	$user = User::whereHas('phone')->get();
    	return $user;
    }




    public function getUserNotHasPhone() {
    	$user = User::whereDoesntHave('phone')->get();
    	return $user;
    }




    public function getUserHasPhoneWithCondition() {
    	$user = User::whereHas('phone', function($q) {
    		$q-> where('code', 02);	
    	})->get();

    	return $user;
    }


 ###################################### One-To-Many RelationShip ####################################

    public function getHospitalDoctors() {
    // $hospital = Hospital::find(1);  //Hospital::where('id', 1)->first();   Hospital::first();
     
      $hospital = Hospital::with('Doctor')->find(1);
      //  return $hospital -> name;
   		//return $hospital-> Doctor;    return Doctors Of Hospital


      $doctors = $hospital->Doctor;

    /*  foreach($doctors as $doctor) {
      	echo $doctor->name . "<br>";
      }*/

      $doctor = Doctor::find(2);
     return $hospital = $doctor->hospital -> address;

    }


    public function hospitals() {
    	$hospitals = Hospital::select('id', 'name', 'address')->get();

    	return view('doctors.hospital', compact('hospitals'));
    }



    public function hospitalDoctors($hospital_id) {

    	$hospital = Hospital::find($hospital_id);
    	$doctors = $hospital-> doctor;

    	return view('doctors.doctors', compact('doctors'));
    }



//get all hospital which has doctors
    public function hospitalHasDoctors() {
    	  $hospital = Hospital::whereHas('Doctor')->get();
    	  return $hospital;
    }



    //get all hospital which has doctors 
    public function hospitalHasMaleDoctors() {
    	  $hospital = Hospital::with('doctor')->whereHas('Doctor', function($q) {
    	  		$q->where('gender', 1);
    	  })->get();
    	  return $hospital;
    }



    public function hospitalNotDoctors() {
    	$hospital = Hospital::whereDoesntHave('doctor')->get();
    	return $hospital;
    }



  public function deleteHospital($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        if (!$hospital)
            return abort('404');
        //delete doctors in this hospital
        $hospital->doctor()->delete();
        $hospital->delete();

        return redirect() -> route('all.hospital');
    }


 ###################################### One-To-Many RelationShip ####################################

 ###################################### Start Many-To-Many RelationShip #################################### 
 
    public function getDoctorsService() {
    	 $doctor = Doctor::with('services')->find('3');

    	 foreach($doctor->services as $service) {
    	 	echo $service->name . "<br>";
    	 }
    	
    }


    public function getServiceDoctors() {
    	$service = Service::with(['doctors' => function($q) {
    		$q->select('doctors.id', 'name', 'title');
    	}])->find(2);

    	return $service;
    }



    public function getDoctorServicesById($doctor_id) {
    	$doctor = Doctor::find($doctor_id);
    	$services = $doctor->services;

    	if(!$doctor)
    		return abort('404');

    	
    	$allServices = Service::select('id', 'name')->get(); 
    	$allDoctors  = Doctor::select('id', 'name')->get();

    	return view('doctors.services', compact('services', 'allServices', 'allDoctors'));
    }



    public function saveServicesToDoctor(Request $request) {

    		 $doctor = Doctor::find($request->doctor_id);

    		 if(!$doctor)
    		 	return abort('404');

    		 $doctor->services()->syncWithoutDetaching($request->services_id);  //many to many insert to DB

    		 return "successful";
    }





    public function getPatientDoctor() {
    	$patient = Patient::find(1);

      return	$patient->doctor;
    }


 
 	public function getCountryDoctors() {
 	return	$country = Country::with('doctors')->find(1);

 		return $country->doctors;
 	}

 ###################################### End Many-To-Many RelationShip ##################################### 



 public function getDoctors() {

         $doctors = Doctor::select('id', 'name', 'gender')->get();

         return $doctors;

     /*   if(isset($doctors) && $doctors->count() > 0) {
             foreach($doctors as $doctor) {
                $doctor->gender =  $doctor->gender == 1 ? 'male' : 'female';
             }
        } 

             return $doctors;*/

 }   
}
