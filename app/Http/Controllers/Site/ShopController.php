<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests;
use App\Product;
use App\Brand;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
	public function index()
	{
		
	}
	
	public function brand($slug)
	{	
		//dd($slug);
		/*$products = Product::with(['brand' => function ($query) use ($slug){
			$query->where('slug',$slug);
		}])->where('status', 1)->get();*/
		$categories = Category::where('status',1)->get();
		$brands = Brand::get();
		$brand = Brand::with(['products' => function ($query) use ($slug){
			$query->where([['status','=',1],['is_supplementary','=',0]])->paginate(12);
		}])->where('slug', $slug)->firstOrFail();
		
		return view('site.shop.single',compact('brands','categories','brand'));
	}
	
	public function category($slug)
	{
		$singlecat = Category::where('slug',$slug)->firstOrFail();
		/*dd($singlecat->id);
		$category = Category::where([['status','=',1],['slug','=',$slug]])->get();
		$brand = Category::with(['products' => function ($query) use ($slug){
			$query->where([['status','=',1],['is_supplementary','=',0]])->paginate(12);
		}])->where('slug', $slug)->firstOrFail();*/
		$categories = Category::where([['status','=',1],['brand_id','=','2']])->take(2)->get();
		$products = Product::whereHas('categories', function ($query) use($singlecat) {
			return $query->where('category_id', $singlecat->id);
		})->get();
		
		//dd($products);
		
		return view('site.shop.single',compact('singlecat','products','categories'));
	}
}