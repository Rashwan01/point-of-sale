<?php

namespace App;

use App\Client;
use App\product;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
	protected $fillable = ['total_price'];

	public function Client(){	
		return $this->belongsTo(Client::class);
	}
	public function products(){	
		return $this->belongsToMany(product::class,"product_order")->withPivot("quantity");
	}
}
