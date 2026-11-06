<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{Schema::create('orders',function(Blueprint $t){$t->id();$t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();$t->string('order_number')->unique();$t->string('customer_name');$t->string('email');$t->string('phone',30);$t->string('address');$t->string('city',100);$t->string('state',100);$t->string('postal_code',20);$t->decimal('subtotal',10,2);$t->decimal('shipping',10,2);$t->decimal('total',10,2);$t->string('payment_method',30);$t->string('payment_status',30)->default('pending');$t->string('status',30)->default('placed');$t->text('notes')->nullable();$t->timestamps();});}
 public function down():void{Schema::dropIfExists('orders');}
};
