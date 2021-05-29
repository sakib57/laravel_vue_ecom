<?php

namespace App\Http\Controllers;

use App\Model\Order;
use App\Model\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

   public function index(Request $request, $number = 10)
   {
    if (!$request->ajax()) {
       return abort(404);
    }
    $orders = Order::latest()->paginate($number);
    return response()->json([
        'orders' => $orders
    ]);
   } 

   public function checkout(Request $request)
   {
   
    $payment_type = $request->payment_type;

    if ($payment_type === 'cash_on_delivery') {
       $this->orderProcess($request);
    } else if($payment_type === 'card_payment') {
        dd('card');
        // $this->orderProcess($request);
    }
   }

   public function orderProcess($request)
   {
        $user = Auth::user();
        $shipping_address = '';
        if ($request->shipping_address) {
            $shipping_address = $request->shipping;
        } else {
            $shipping_address = $user;
        }
        $payment_type = $request->payment_type;
        $total = \Cart::getTotal();  

        $order = new Order();
        $order->user_id = $user->id;
        $order->shipping_address = json_encode($shipping_address);
        $order->payment_type = $payment_type;
        $order->total = $total;
        $order->sub_total = $total;
        $order->save();
        $items = \Cart::getContent();
        
        foreach($items as $row) {
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->item_name = $row->name;
            $order_item->item_price = $row->price;
            $order_item->item_quantity = $row->quantity;
            $order_item->save();
        }
        \Cart::clear();
        return 'ok';
   }

    public function orderDetail(Request $request, $id)
    {
        if (!$request->ajax()) {
            return abort(404);
         }
        $order = Order::find($id);
        return response()->json([
            'order' => $order
        ]);
    }
    
}
