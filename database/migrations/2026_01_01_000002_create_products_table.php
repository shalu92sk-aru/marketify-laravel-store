<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{Schema::create('products',function(Blueprint $t){$t->id();$t->foreignId('category_id')->constrained()->restrictOnDelete();$t->string('name',180);$t->string('slug')->unique();$t->string('sku',60)->unique();$t->text('description')->nullable();$t->decimal('price',10,2);$t->decimal('compare_price',10,2)->nullable();$t->string('image')->nullable();$t->unsignedInteger('stock')->default(0);$t->boolean('is_featured')->default(false);$t->boolean('is_active')->default(true);$t->timestamps();$t->index(['is_active','is_featured']);});}
 public function down():void{Schema::dropIfExists('products');}
};
