@extends('admin.layout')
@section('title','Orders')
@section('content')
<div class="admin-heading"><div><span class="kicker">CUSTOMER ACTIVITY</span><h1>Orders.</h1><p>Review and manage incoming orders.</p></div></div><div class="admin-panel"><div class="table-wrap"><table><thead><tr><th>Order</th><th>Customer</th><th>Email</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th></th></tr></thead><tbody>@forelse($orders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ $order->customer_name }}</td><td>{{ $order->email }}</td><td>₹{{ number_format($order->total,2) }}</td><td>{{ ucfirst($order->payment_status) }}</td><td>{{ ucfirst($order->status) }}</td><td>{{ $order->created_at->format('d M Y') }}</td><td><a href="{{ route('admin.orders.show',$order) }}">View</a></td></tr>@empty<tr><td colspan="8">No orders received yet.</td></tr>@endforelse</tbody></table></div>{{ $orders->links() }}</div>
@endsection
