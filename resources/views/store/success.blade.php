@extends('layouts.store')
@section('title','Order confirmed — Marketify')
@section('content')
<section class="container success-page"><div class="success-icon">✓</div><span class="kicker">THANK YOU FOR SHOPPING WITH US</span><h1>Your order is in.</h1><p>We've received your order and will get things moving soon.</p><div class="order-confirm"><span>ORDER NUMBER</span><strong>{{ $order->order_number }}</strong><div><span>Order total</span><b>₹{{ number_format($order->total,2) }}</b></div><div><span>Payment</span><b>Cash on Delivery</b></div><div><span>Status</span><b>{{ ucfirst($order->status) }}</b></div></div><a class="dark-btn" href="{{ route('shop') }}">Back to the shop ↗</a></section>
@endsection
