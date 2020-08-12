<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use Illuminate\Http\Request;
use App\Traits\OfferTrait;
use LaravelLocalization;
use App\Models\Offer;


class OfferController extends Controller
{

	use OfferTrait;
    

    public function create() {
    	//view form to add offer

    	return view('ajaxoffers.create');

    }


    public function store(OfferRequest $request) {
    	//save offer into DB useing Ajax


    	    $file_name = $this->saveImages($request->photo, 'images/offers');


           $offer = Offer::create([
                    'photo'        => $file_name,
                    'name_ar'      => $request->name_ar,
                    'name_en'      => $request->name_en,
                    'price'    	   => $request->price,
                    'details_ar'   => $request->details_ar,
                    'details_en'   => $request->details_en
                ]);


        if($offer)        
           return response()->json([
           		"status" => true,
           		'msg'    => "Saved Successfully",
           ]); 

        else 
           return response()->json([
           		'status' => false,
           		'msg'    => "Saved Is Failed Try Again!!",
           ]);	

    	
    }



    public function all() {

    	$offers = Offer::select(
    		'id',
    	 'price',
    	 'photo',
    	 'name_' .  LaravelLocalization::getCurrentLocale()  . ' as name',
    	 'details_'.  LaravelLocalization::getCurrentLocale()  . ' as details'
    	 )->limit(10)->get();  // As a Collection

         return view('ajaxoffers.all', compact('offers'));
    }


    public function delete(Request $request) {

    		  //Check if offer_id is exists
        $offer = Offer::find($request->id);  
        if(!$offer) 
            return redirect()->back();
      
            

          $offer->delete();

          return response()->json([
          		'status' => true,
          		'msg'    => 'تم الحذف بنجاح',
          		'id'     => $request->id
          ]);
    }


    public function edit($offer_id) {

         // find use to check for id only
        $offer = Offer::find($offer_id);

        if(!$offer)

        return response()->json([
           		'status' => false,
           		'msg'    => "Update Is Failed Try Again!!",
           ]);


        $offer = Offer::select('id', 'photo', 'name_ar', 'name_en', 'price', 'details_ar', 'details_en')->find($offer_id);
        return view('ajaxoffers.edit', compact('offer'));

    }



    public function update(OfferRequest $request) {
    	       //update for data
         $offer = Offer::find($request->offer_id);

         if(!$offer)
             return response()->json([
           		'status' => false,
           		'msg'    => "Offer Is Not Exists Try Again!!",
           ]);


            $offer->update($request->all());
            return response()->json([
            	'status' => true,
          	
          		
            ]);
    }


}    

