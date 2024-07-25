<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests;
use App\Product;
use App\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function single($slug)
    {
        $products = Product::where('slug',$slug)->firstOrFail();
		//dd($products);
		//$prodid = $products->id;
		//dd($prodid);
		//$attributes = Attribute::has('prodattributes')->get();
		
		/*$attributes = Attribute::has('prodattributes', function ($query) use ($prodid){
			$query->where('product_id',$prodid)->paginate(12);
		})->get();
		
		foreach($attributes as $attr):
			$title = $attr->name;
			foreach($attr->prodattributes as $attribute):
				echo "<pre>";
				echo $attribute;
			endforeach;
		endforeach;
		echo "</pre>";die();*/
		
		
        return view('site.products.single',compact('products'));
    }

}
