<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ProductController;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Validator;

class Product extends Model
{
    use Sortable;
    // use HasFactory;
    // モデルに関連づけるテーブル
    protected $table = "products";
    // テーブルに関連づける主キー
    protected $primaryKey = 'id';
    // 登録・変更可能なカラム
    protected $fillable = [
        'company_id','product_name',
        'price','stock','comment','img_path'
    ];
    // ソートしたいカラムを指定
    public $sortable = [
    'id','img_path','product_name',
    'price','stock','company_id'
    ];

    // companyとのリレーション
    public function company() {
        return $this->belongsTo(Company::class);
    }
    // 一覧画面のためにproducts&companyテーブルから全てのデータ取得
    public function findAllProducts() {
        return Product::all();
    }
    public function findAllCompanies() {
        return Company::all();
    }

    // saleとのリレーション
    public function sales() {
        return $this->hasMany(Sale::class);
    }

// 更新処理
    public function updateProduct($request, $product, $companies) {

        // $img_path = $request->file('img_path') ?? null;
        // $img_path = $request->file('img_path')->store('public/img');
        // // 保存したファイルのパスを取得する
        // $img_path = str_replace('public/', 'storage/', $img_path);

        $img_path = $request->file('img_path') ? $request->file('img_path')->store('public/img') : null;
        $img_path = $img_path ? str_replace('public/', 'storage/', $img_path) : null;
        $result = $product->fill([
            'product_name' => $request->product_name,
            'company_name' => $companies->find($request->company_name)->company_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $img_path
        ])->save();
        return $result;
    }
// 価格範囲の検索
    public function scopePriceRange($query, $min_price = null, $max_price = null)
{
    $validator = Validator::make(compact('minPrice', 'maxPrice'), [
        'minPrice' => 'nullable|numeric|min:0',
        'maxPrice' => 'nullable|numeric|min:0|gte:minPrice',
    ]);

    if ($validator->fails()) {
        throw new InvalidArgumentException('Validation failed: ' . $validator->errors()->first());
    }

    if ($min_price && $max_price) {
        $query->whereBetween('price', [$min_price, $max_price]);
    } elseif ($min_price!== null) {
        $query->where('price', '>=', $min_price);
    } elseif ($max_price!== null) {
        $query->where('price', '<=', $max_price);
    }
    return $query;
}
// 在庫数範囲の検索
public function scopeStockRange($query, $minStock = null, $maxStock = null)
{
    $validator = Validator::make(compact('minStock', 'maxStock'), [
        'minStock' => 'nullable|numeric|min:0',
        'maxStock' => 'nullable|numeric|min:0|gte:minStock',
    ]);

    if ($validator->fails()) {
        throw new InvalidArgumentException('Validation failed: ' . $validator->errors()->first());
    }

    if ($minStock !== null || $maxStock !== null) {
        $query->whereBetween('stock', [$minStock ?? 0, $maxStock ?? PHP_INT_MAX]);
    }
    return $query;
}


}
