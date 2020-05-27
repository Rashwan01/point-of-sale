<?php

namespace App;

use App\category;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class product extends Model implements TranslatableContract
{

	use Translatable;
	protected $fillable = ['category_id','title','description','sale_price','purchase_price','stock','image'];
	
	public $translatedAttributes = ['title','description']; 
	protected $appends = ['image_path','profit_percent'];


	public function category(){

		return $this->belongsTo(category::class,"category_id");
	}
	public function orders(){
	
		return $this->belongsToMany(Orders::class,"product_order");
	}
	public function getImagePathAttribute(){
		return asset("/uploads/product_image/".$this->image);

	}
	public function getProfitPercentAttribute(){
		$profit = $this->sale_price-$this->purchase_price;
		$profit_percent = $profit*100 / $this->purchase_price;
		return  $profit_percent; 

	}
}
