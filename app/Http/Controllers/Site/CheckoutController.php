<?php

namespace App\Http\Controllers\Site;

use App\Customer;
use App\Order;
use App\Product;
use App\OrderItem;
use App\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Events\Notify;

class CheckoutController extends Controller
{
  public function store(Request $request)
  {
    //dd($request->all());
    $order = $this->addToOrdersTables($request, null);

    $this->decreaseQuantities();

    Cart::instance("default")->destroy();

    return redirect()
      ->route("confirmation.index")
      ->with(
        "success_message",
        "Thank you! Your payment has been successfully accepted!"
      );
  }

  protected function addToOrdersTables($request, $error)
  {
    //dd($request);

    //insert into customer table
    $customer = Customer::create([
      "first_name" => $request->first_name,
      "last_name" => $request->last_name,
      "phone" => $request->phone,
      "email" => $request->email,
      "location" => $request->location,
	  "company_name"=>$request->company_name,
	  "company_address"=>$request->company_address,
	  "concerned_person"=>$request->concerned_person,
	  "company_contact"=>$request->company_contact,
	  "company_pan"=>$request->company_pan,
    ]);

    // Insert into orders table
    $order = Order::create([
      "customer_id" => $customer->id,
      "sub_total" => Cart::subtotal(),
      "tax" => Cart::tax(),
      "total" => Cart::total(),
    ]);
	
	//insert into order_status table
	$status = OrderStatus::create([
		"order_id"=>$order->id,
		"last_status"=>1,
	]);
	
    //insert into order_product table
    foreach (Cart::content() as $item) {
      OrderItem::create([
        "order_id" => $order->id,
        "product_id" => $item->model->id,
        "price" => $item->model->price,
        "quantity" => $item->qty,
      ]);
    }
	
	$fullname = $request->first_name.' '.$request->last_name;
	
	$notification = "Order #".$order->id." have been placed by ".$fullname;
	activity()->log($notification);
	event(new Notify($notification));

    return $order;
  }

  protected function decreaseQuantities()
  {
    foreach (Cart::content() as $item) {
      $product = Product::find($item->model->id);
      //dd($item->qty);
      $decrease = $product->quantity - $item->qty;

      //dd($decrease);
      $product->quantity = $decrease;

      //dd($data);
      $product->save();
    }
  }

  protected function productsAreNoLongerAvailable()
  {
    foreach (Cart::content() as $item) {
      $product = Product::find($item->model->id);
      if ($product->quantity < $item->qnty) {
        return true;
      }
    }

    return false;
  }
}
