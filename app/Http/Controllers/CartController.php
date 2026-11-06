<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $products = Product::whereIn('id',array_keys($cart))->get()->keyBy('id');
        $subtotal = 0;
        foreach ($cart as $id=>$item) if(isset($products[$id])) $subtotal += $products[$id]->price * $item['quantity'];
        return view('store.cart', compact('cart','products','subtotal'));
    }
    public function add(Request $request, Product $product)
    {
        abort_unless($product->is_active,404);
        $data = $request->validate(['quantity'=>['nullable','integer','min:1','max:20']]);
        $quantity = (int)($data['quantity'] ?? 1);
        $cart = session('cart', []);
        $newQuantity = ($cart[$product->id]['quantity'] ?? 0) + $quantity;
        if ($newQuantity > $product->stock) return back()->withErrors(['cart'=>'Requested quantity is not available in stock.']);
        $cart[$product->id] = ['quantity'=>$newQuantity];
        session(['cart'=>$cart]);
        return back()->with('success','Product added to your cart.');
    }
    public function update(Request $request, Product $product)
    {
        $data = $request->validate(['quantity'=>['required','integer','min:1','max:20']]);
        if ($data['quantity'] > $product->stock) return back()->withErrors(['cart'=>'Requested quantity exceeds available stock.']);
        $cart = session('cart', []);
        if(isset($cart[$product->id])) { $cart[$product->id]['quantity'] = (int)$data['quantity']; session(['cart'=>$cart]); }
        return back()->with('success','Cart updated.');
    }
    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart'=>$cart]);
        return back()->with('success','Product removed from cart.');
    }
}
