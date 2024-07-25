<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function checkout()
  {
    return view("site.carts.checkout");
  }

  public function index()
  {
    //$recommend = Product::whereStatus('PUBLISHED')->inRandomOrder()->take(4)->get();
	
    return view("site.carts.index"); //,compact('recommend'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
      return $cartItem->id === $request->product_id;
    });

    if ($duplicates->isNotEmpty()) {
      //return redirect()->route('carts.index')->with('success_message', 'Item is already in your cart!');
      return view("site.carts.index")->with(
        "message",
        "Item is already in your cart!"
      );
    }

    Cart::add(
      $request->product_id,
      $request->product_name,
      $request->quantity,
      $request->product_price
    )->associate(Product::class);

    //return redirect()->route('carts.index')->with('success_message','Item was added to your cart!');
    return view("site.carts.index")->with(
      "message",
      "Item was added to your cart!"
    );
  }
  
	public function add($id)
	{
		$products = Product::where('id',$id)->firstOrFail();
		//dd($products);
		$duplicates = Cart::search(function ($cartItem, $rowId) use ($products) {
		  return $cartItem->id === $products->id;
		});
		
		 if ($duplicates->isNotEmpty()) {
		  //return redirect()->route('carts.index')->with('success_message', 'Item is already in your cart!');
		  return view("site.carts.index")->with(
			"message",
			"Item is already in your cart!"
		  );
		}
		
		Cart::add(
		  $products->id,
		  $products->sku,
		  1,
		  $products->price
		)->associate(Product::class);

		//return redirect()->route('carts.index')->with('success_message','Item was added to your cart!');
		return view("site.carts.index")->with(
		  "message",
		  "Item was added to your cart!"
		);
	
	}
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
	  
	//sreturn $request->all();
    $validator = Validator::make($request->all(), [
      "quantity" => "required|numeric|between:1,5",
    ]);

    if ($validator->fails()) {
      //session()->flash("errors", collect([""]));
      return response()->json(["success" => "Quantity must be between 1 and 5"]);
    }

    Cart::update($request->id, $request->quantity);
    //session()->flash("success_message", "Quantity was updated successfully");
    return response()->json(["message" => "Quantity was updated successfully"]);
  }
  
  /*ajax add product from cart view*/
  public function ajaxadd(Request $request)
  {
	$products = Product::where('id',$request->id)->firstOrFail();
	$duplicates = Cart::search(function ($cartItem, $rowId) use ($products) {
	  return $cartItem->id === $products->id;
	});
	
	 if ($duplicates->isNotEmpty()) {
	  return response()->json([
		"message"=>"Item is already in your cart!"
	  ]);
	}
	
	Cart::add(
	  $products->id,
	  $products->sku,
	  1,
	  $products->price
	)->associate(Product::class);
	
	$response=[];
	$cartitems = '';
	$content = '';
	
	foreach(Cart::content() as $item):
		$content .= '<tr>
				<td style="padding:30px 0; text-align:center">
					<button class="remove" data-id="'.$item->rowId. '"><i class="fa fa-times" aria-hidden="true"></i></button>
				</td>
				<td>
<td><img class="img-responsive lozad" width="100" src="'.asset($item->model->getMedia("products")[0]->getUrl("thumb")).'" data-src="'.asset($item->model->getMedia("products")[0]->getUrl("thumb")).'" title="'.$item->model->sku.'" alt="'.$item->model->sku.'"></td>
				</td>
<td>'.$item->model->sku.'</td>
				<td class="cart-amount">NPR. '.$item->model->price.".00".'</td>
				<td>
					<select class="quantity" data-id="'.$item->rowId.'" data-productQuantity="'.$item->qty.'">
						<option '.($item->qty=="1" ? "selected" : "").' data-qty="1">1</option>
						<option '.($item->qty=="2" ? "selected" : "").' data-qty="2">2</option>
						<option '.($item->qty=="3" ? "selected" : "").' data-qty="3">3</option>
						<option '.($item->qty=="4" ? "selected" : "").' data-qty="4">4</option>
						<option '.($item->qty=="5" ? "selected" : "").' data-qty="5">5</option>
                    </select>
				</td>
				<td class="cart-amount">NPR. '.$item->subtotal.'</td>
		</tr>';
		
		$cartitems .= '<div class="col-md-4">
							<img class="lozad img-responsive cart-img" src="'.asset($item->model->getMedia('products')[0]->getUrl('thumb')).'" data-src="'.asset($item->model->getMedia('products')[0]->getUrl('thumb')).'" title="'.$item->model->sku.'" alt="'.$item->model->sku.'">
						</div>
						<div class="col-md-8">
							<div class="product-name"><b>'.$item->model->sku.'</b></div>
							<div class="row ">
								<div class="display-inbl col-md-5 flex">
									<label class="fw5">Qty </label> 
									<input name="quantity" value="'.$item->qty.'" disabled class="form-control form-control-sm number-form">
								</div>
								<span class="card-total-price col-md-7"> NPR. '.$item->subtotal.'</span>
							</div>
						</div>
						<div class="clearfix"></div>
						<hr>';
	endforeach;
	$response['subtotal'] = Cart::subtotal(); 
	$response['tax'] = Cart::tax(); 
	$response['count'] = Cart::count();
	$response['total'] = Cart::total(); 
	$response['content']=$content;
	$response['cartitems']=$cartitems;
	return response()->json($response);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    //dd($request->all());
    Cart::remove($request->id);
	 return response()->json(["message" => "Item has been removed!"]);
    //return redirect()->route('home)->with('message', 'Item has been removed!');
  }
  
 
}
