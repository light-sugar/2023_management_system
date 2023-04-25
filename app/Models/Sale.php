<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use HasFactory;
use App\Http\Controllers\ProductController;


class Sale extends Model
{
    // モデルに関連づけるテーブル
    protected $table = "sales";
    // テーブルに関連づける主キー
    protected $primaryKey = 'id';
    protected $fillable = ['product_id'];
    
    // productとのリレーション
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function findAllProducts() {
        return Product::all();
    }
    public function findAllSales() {
        return Sale::all();
    }
}
