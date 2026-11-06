<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Order extends Model
{
    protected $fillable = ['user_id','order_number','customer_name','email','phone','address','city','state','postal_code','subtotal','shipping','total','payment_method','payment_status','status','notes'];
    protected function casts(): array { return ['subtotal'=>'decimal:2','shipping'=>'decimal:2','total'=>'decimal:2']; }
    public function items(): HasMany { return $this->hasMany(OrderItem::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
