<?php

namespace App\Models;

use App\Scopes\OfferScope;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
   		// protected $table = "my_offers";


	protected $fillable = ['name_ar', 'name_en', 'price', 'photo', 'details_ar', 'details_en', 'status', 'created_at', 'updated_at'];

	protected $hidden = ['created_at', 'updated_at'];

	public $timestamps = false;




###################################### Local Scope ###########################################

	public function scopeInactive($query) {
		return $query->where('status', 0);
	}


	public function scopeInvalid($query) {
		return $query->where('status', 0)->whereNull('details_ar');
	}

##################################### End Local Scope ########################################	

	// Register For Global Scope
	 protected static function boot()
    {
    	parent::boot();
        static::addGlobalScope(new OfferScope);
    }



    //Mutator
    public function setNameEnAttribute($val) {
    	$this->attributes['name_en'] = strtoupper($val);
    }

}
