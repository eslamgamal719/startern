<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\OfferRequest;
use LaravelLocalization;
use App\Traits\OfferTrait;
use App\Models\Video;
use App\Events\VideoViewer;
use App\Scopes\OfferScope;

class CrudController extends Controller
{



    use OfferTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      
    }

    
    public function getOffers() {
        return Offer::get();
    }

/*
    public function store() {

        Offer::create([
            'name'      => 'offer3',
            'price'     => '200',
            'details'   => 'good offer'
        ]);
    }
*/



    public function create() {
             return view('offers.create');
    }

   



    public function store(OfferRequest $request) {

                //Validate Data Before Insert
            /*  
        		$rules = $this-> getRules();
        		$messages = $this-> getMessages();	
                $validator = Validator::make($request->all(), $rules, $messages );

                    if($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput($request->all());
                    }*/

                //Insert Data Into Table

                $file_name = $this->saveImages($request->photo, 'images/offers');


                Offer::create([
                    'photo'        => $file_name,
                    'name_ar'      => $request->name_ar,
                    'name_en'      => $request->name_en,
                    'price'        => $request->price,
                    'details_ar'   => $request->details_ar,
                    'details_en'   => $request->details_en
                ]);

                return redirect()->back()->with(['success' => "تمت الاضافه بنجاح"]);
    }
	
	
	


	
/*	
	protected function getRules(){
			return	[

						'name'      => 'required|max:100|unique:offers,name',
						'price'     => 'required|numeric',
						'details'   => 'required',
					];
	}
	
	protected function getMessages(){
			return  $messages =[

					'name.required' 	=> __('messages.offer name required'),
					'price.required' 	=> __('messages.price required'),
					'details.required' 	=> __('messages.details required'),
					'name.max' 			=> __('messages.name max length'),
					'price.numeric' 	=> __('messages.price numeric'),
					'name.unique' 		=> __('messages.name unique')
				];
	}*/


    public function getAllOffers() {

       /*  $offers = Offer::select('id', 'photo', 'price', 'name_' .  LaravelLocalization::getCurrentLocale()  . ' as name',  'details_'.  LaravelLocalization::getCurrentLocale()  . ' as details')->get();  // As a Collection
*/


       $offers = Offer::select('id', 'photo', 'price', 'name_' .  LaravelLocalization::getCurrentLocale()  . ' as name',  'details_'.  LaravelLocalization::getCurrentLocale()  . ' as details')->paginate(PAGINATION_COUNT); 

       //  return view('offers.all', compact('offers'));

       return view('offers.pagination', compact('offers'));

    }




    public function editOffer($offer_id) {             
        //Offer::findOrFail($offer_id);  if not Found Give Error404

         // find use to check for id only
        $offer = Offer::select('id', 'name_ar', 'name_en', 'price', 'details_ar', 'details_en')->find($offer_id);

        if(!$offer)
            return redirect()-> back();

        return view('offers.edit', compact('offer'));
    }



    public function updateOffer(OfferRequest $request, $offer_id) {
            //validation of Inputs

            //update for data
         $offer = Offer::find($offer_id);

         if(!$offer)
            return redirect()->back();


            $offer->update($request->all());

       /*     $offer->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'price'   => $request->price
            ]);*/

            return redirect()->back()->with(['success' => __('messages.success')]);
    }





        public function deleteOffer($offer_id) {
        //Check if offer_id is exists
        $offer = Offer::find($offer_id);  //Offer::where('id', $offer_id)->first();
        if(!$offer) 
            return redirect()->back()->with(['error' => __('messages.offer not found')]);
            

          $offer->delete();
          return redirect()->route('offers.all')->with(['success' => __('messages.offer deleted successfully')]);   
    }






   public function getVideo() {

        $video = Video::first();
        event(new VideoViewer($video)); //fire Event
        return view('video')->with('video' , $video);
   } 




   public function getAllInactiveOffers() {

    //where   whereNull   whereNotNull    whereIn
    //Offer::whereNotNull('details_ar')->get();

   // return  $inactiveOffers =  Offer::get();  //Global Scope


// Remove Global Scope
       return $offer  = Offer::withoutGlobalScope(OfferScope::class)->get();
       
   }

    
}
