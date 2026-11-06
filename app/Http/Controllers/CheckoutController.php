<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        abort_if(empty($cart), redirect()->route('shop'));
        $products = Product::whereIn('id',array_keys($cart))->get()->keyBy('id');
        $subtotal = 0;
        foreach($cart as $id=>$item) if(isset($products[$id])) $subtotal += $products[$id]->price * $item['quantity'];
        $shipping = $subtotal >= 1500 ? 0 : 99;
        return view('store.checkout', compact('cart','products','subtotal','shipping'));
    }
    public function place(Request $request)
    {
        $data = $request->validate([
            'customer_name'=>['required','string','max:120'],
            'email'=>['required','email','max:160'],
            'phone'=>['required','string','max:30'],
            'address'=>['required','string','max:255'],
            'city'=>['required','string','max:100'],
            'state'=>['required','string','max:100'],
            'postal_code'=>['required','string','max:20'],
            'payment_method'=>['required','in:cod'],
            'notes'=>['nullable','string','max:500']
        ]);
        $cart = session('cart', []);
        abort_if(empty($cart), redirect()->route('shop'));
        $order = DB::transaction(function() use($cart,$data) {
            $ids = array_keys($cart);
            $products = Product::whereIn('id',$ids)->lockForUpdate()->get()->keyBy('id');
            $subtotal = 0;
            foreach($cart as $id=>$item) {
                if(!isset($products[$id]) || !$products[$id]->is_active || $item['quantity'] > $products[$id]->stock) {
                    throw \Illuminate\Validation\ValidationException::withMessages(['cart'=>'One or more products are unavailable or have insufficient stock. Please review your cart.']);
                }
                $subtotal += $products[$id]->price * $item['quantity'];
            }
            $shipping = $subtotal >= 1500 ? 0 : 99;
            $order = Order::create([
                'order_number'=>'MFY-'.strtoupper(Str::random(8)),
                'customer_name'=>$data['customer_name'],'email'=>$data['email'],'phone'=>$data['phone'],
                'address'=>$data['address'],'city'=>$data['city'],'state'=>$data['state'],'postal_code'=>$data['postal_code'],
                'subtotal'=>$subtotal,'shipping'=>$shipping,'total'=>$subtotal+$shipping,
                'payment_method'=>$data['payment_method'],'payment_status'=>'pending','status'=>'placed','notes'=>$data['notes'] ?? null
            ]);
            foreach($cart as $id=>$item) {
                $product = $products[$id];
                $lineTotal = $product->price * $item['quantity'];
                OrderItem::create(['order_id'=>$order->id,'product_id'=>$product->id,'product_name'=>$product->name,'price'=>$product->price,'quantity'=>$item['quantity'],'line_total'=>$lineTotal]);
                $product->decrement('stock',$item['quantity']);
            }
            return $order;
        });
        session()->forget('cart');
        return redirect()->route('checkout.success',$order);
    }
    public function success(Order $order)
    {
        return view('store.success',compact('order'));
    }
}
