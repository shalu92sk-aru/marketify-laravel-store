<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model
{
    protected $fillable = ['category_id','name','slug','sku','description','price','compare_price','image','stock','is_featured','is_active'];
    protected function casts(): array { return ['price'=>'decimal:2','compare_price'=>'decimal:2','is_featured'=>'boolean','is_active'=>'boolean']; }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function getDiscountPercentAttribute(): int
    {
        if (!$this->compare_price || $this->compare_price <= $this->price) return 0;
        return (int) round((($this->compare_price - $this->price) / $this->compare_price) * 100);
    }
}
