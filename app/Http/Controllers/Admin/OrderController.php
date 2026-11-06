<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class OrderController extends Controller
{
    public function index(){ $orders=Order::latest()->paginate(20);return view('admin.orders.index',compact('orders')); }
    public function show(Order $order){$order->load('items');return view('admin.orders.show',compact('order'));}
    public function updateStatus(Request $request,Order $order)
    {
        $data=$request->validate(['status'=>['required',Rule::in(['placed','processing','shipped','delivered','cancelled'])],'payment_status'=>['required',Rule::in(['pending','paid','refunded'])]]);
        $order->update($data);return back()->with('success','Order updated.');
    }
}
