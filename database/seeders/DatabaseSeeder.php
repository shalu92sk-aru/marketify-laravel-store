<?php
namespace Database\Seeders;
use App\Models\User;use App\Models\Category;use App\Models\Product;use Illuminate\Database\Seeder;use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
 public function run():void{
  User::updateOrCreate(['email'=>'admin@marketify.test'],['name'=>'Marketify Admin','password'=>Hash::make('ChangeMe123!')]);
  $cats=[
   ['name'=>'Clothing','slug'=>'clothing','description'=>'Everyday essentials and modern fits.'],
   ['name'=>'Accessories','slug'=>'accessories','description'=>'The finishing touches.'],
   ['name'=>'Home & Living','slug'=>'home-living','description'=>'Thoughtful pieces for your space.'],
   ['name'=>'Tech','slug'=>'tech','description'=>'Useful technology for everyday life.']
  ];
  foreach($cats as $c)Category::updateOrCreate(['slug'=>$c['slug']],$c);
  $samples=[
   ['category'=>'clothing','name'=>'Everyday Cotton Tee','price'=>599,'compare'=>899,'sku'=>'CL-TEE-01','stock'=>40,'featured'=>1,'description'=>'A soft, breathable cotton T-shirt designed for everyday comfort.'],
   ['category'=>'clothing','name'=>'Classic Overshirt','price'=>1499,'compare'=>1899,'sku'=>'CL-OVS-02','stock'=>18,'featured'=>1,'description'=>'A versatile layer with a relaxed silhouette and clean finish.'],
   ['category'=>'accessories','name'=>'Minimal Leather Wallet','price'=>899,'compare'=>1199,'sku'=>'AC-WAL-03','stock'=>25,'featured'=>1,'description'=>'A compact wallet with practical everyday organisation.'],
   ['category'=>'accessories','name'=>'Canvas Everyday Tote','price'=>499,'compare'=>null,'sku'=>'AC-TOT-04','stock'=>55,'featured'=>0,'description'=>'A durable carry-all for errands, work and weekends.'],
   ['category'=>'home-living','name'=>'Ceramic Desk Planter','price'=>749,'compare'=>999,'sku'=>'HM-PLT-05','stock'=>22,'featured'=>1,'description'=>'A simple ceramic planter to bring a little green indoors.'],
   ['category'=>'home-living','name'=>'Soft Knit Throw','price'=>1299,'compare'=>1599,'sku'=>'HM-THR-06','stock'=>12,'featured'=>0,'description'=>'A cosy textured throw for slow evenings and quiet mornings.'],
   ['category'=>'tech','name'=>'Wireless Desk Speaker','price'=>2199,'compare'=>2799,'sku'=>'TC-SPK-07','stock'=>14,'featured'=>1,'description'=>'A compact wireless speaker with a clean, desk-friendly design.'],
   ['category'=>'tech','name'=>'Aluminium Laptop Stand','price'=>1099,'compare'=>1399,'sku'=>'TC-STN-08','stock'=>30,'featured'=>0,'description'=>'An adjustable-feel ergonomic lift for a tidy workspace.']
  ];
  foreach($samples as $s){$cat=Category::where('slug',$s['category'])->first();Product::updateOrCreate(['sku'=>$s['sku']],['category_id'=>$cat->id,'name'=>$s['name'],'slug'=>\Illuminate\Support\Str::slug($s['name']),'description'=>$s['description'],'price'=>$s['price'],'compare_price'=>$s['compare'],'stock'=>$s['stock'],'is_featured'=>$s['featured'],'is_active'=>true]);}
 }
}
