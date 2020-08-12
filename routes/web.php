<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
define('PAGINATION_COUNT', 3);  //If I need To Make Const === Make It In Web And Use In Controller 


Route::get('/', function () {

    return view('welcome');
});

/*
Route::resource('news', 'NewsController');

Route::get('news', "NewsController@index");
Route::post('news', "NewsController@store");
Route::get('news/create', "NewsController@create");
Route::get('news/{id}/edit', "NewsController@edit");
Route::post('news/{id}', "NewsController@update");
Route::delete('news/{id}', "NewsController@delete");
*/


Route::get('/dashboard', function () {

    return "Not adult";
})->name('not.adult');





Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');


Route::get('redirect/{service}', 'socialcontroller@redirect');

Route::get('callback/{service}', 'socialcontroller@callback');



Route::get('fillable', 'CrudController@getOffers');





Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){ 

		Route::group(['prefix' => 'offers'], function(){
		//Route::get('store', 'CrudController@store');

			Route::get('create' ,'CrudController@create');
			Route::post('store' ,'CrudController@store')->name('offers.store');


			Route::get('edit/{offer_id}' ,'CrudController@editOffer');
			Route::post('update/{offer_id}' ,'CrudController@updateOffer')->name('offers.update');

			
			Route::get('delete/{offer_id}' ,'CrudController@deleteOffer')->name('offers.delete');

			Route::get('all', 'CrudController@getAllOffers')->name('offers.all');

			Route::get('get-all-inactive-offer', 'CrudController@getAllInactiveOffers');
		});


		Route::get('youtube','CrudController@getVideo')->middleware('auth');

});



################################### Start Of ajax-offers #####################################

Route::group(['prefix' => 'ajax-offers'], function(){

	Route::get('create', 'OfferController@create');
	Route::post('store', 'OfferController@store')->name('ajax.offers.store');

	//Route::get('all', 'OfferController@all')->name('ajax.offers.all');
	Route::post('delete', 'OfferController@delete')->name('ajax.offer.delete');

	Route::get('edit/{offer_id}' ,'OfferController@edit')->name('ajax.offers.edit');
	Route::post('update' ,'OfferController@update')->name('ajax.offers.update');

});

#################################### End Of ajax-offers ######################################







################################ Begin Authentication And Guards ###############################

Route::group(['middleware' => 'CheckAge', 'namespace' => 'Auth'], function(){
	Route::get('adults', 'CustomAuthController@adult')->name('adult');
});


Route::get('site', 'Auth\CustomAuthController@site')->middleware('auth:web')->name('site');
Route::get('admin', 'Auth\CustomAuthController@admin')->middleware('auth:admin')->name('admin');

Route::get('admin/login', 'Auth\CustomAuthController@adminLogin')->name('admin.login');
Route::post('admin/login', 'Auth\CustomAuthController@checkAdminLogin')->name('save.admin.login');

################################# End Authentication And Guards ###############################



################################# Begin Relations Routes ########################################


Route::get('has-one', 'Relation\RelationsController@hasOneRelation');

Route::get('has-one-reverse', 'Relation\RelationsController@hasOneRelationReverse');

Route::get('get-user-has-phone', 'Relation\RelationsController@getUserHasPhone');

Route::get('get-user-has-phone-with-condition', 'Relation\RelationsController@getUserHasPhoneWithCondition');

Route::get('get-user-not-has-phone', 'Relation\RelationsController@getUserNotHasPhone');


################################## Start One-To-Many Relations Routes #######################################

Route::get('hospital-has-many', 'Relation\RelationsController@getHospitalDoctors');

Route::get('hospitals', 'Relation\RelationsController@hospitals')->name('all.hospital');
Route::get('doctors/{hospital_id}', 'Relation\RelationsController@hospitalDoctors')->name('doctors.hospital');


Route::get('hospitals/{hospital_id}', 'Relation\RelationsController@deleteHospital')->name('delete.hospital');


Route::get('hospitals-has-doctors', 'Relation\RelationsController@hospitalHasDoctors');
Route::get('hospitals-has-doctors-male', 'Relation\RelationsController@hospitalHasMaleDoctors');
Route::get('hospitals-not-has-doctors', 'Relation\RelationsController@hospitalNotDoctors');

################################## End One-To-Many Relations Routes #########################################

################################## Begin Many-To-Many Relations Routes #########################################

Route::get('doctor-services', 'Relation\RelationsController@getDoctorsService');

Route::get('service-doctors', 'Relation\RelationsController@getServiceDoctors');


Route::get('doctor-services/{doctor_id}', 'Relation\RelationsController@getDoctorServicesById')->name('doctor.services');
Route::post('saveservices-to-doctor', 'Relation\RelationsController@saveServicesToDoctor')->name('save.services.doctor');

################################### End Many-To-Many Relations Routes #########################################

################################### End has-One-Through Relations Routes ######################################

Route::get('has-one-through', 'Relation\RelationsController@getPatientDoctor');

Route::get('has-many-through', 'Relation\RelationsController@getCountryDoctors');


################################### End has-One-Through Relations Routes ######################################

###################################### End Relations Routes #################################################



###################################### Accessors And Mutators ############################################

Route::get('accessors', 'Relation\RelationsController@getDoctors');



###################################### Accessors And Mutators ############################################