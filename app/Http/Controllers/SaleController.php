<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class SaleController extends Controller
{
    protected $product;
    protected $sale;

    public function __construct(Product $product, Sale $sale)
    {
        $this->product = $product;
        $this->sale = $sale;
    }

    public function store(Request $request)
    {
        // 新しいIDを生成する
        $maxId = Sale::max('id');
        $newId = $maxId + 1;

        $sales = Sale::with('product')->get();
        $product = Product::all();
        // 商品IDと数量をリクエストから取得する
        $product_id = $request->input('product_id');
        

        // Salesテーブルのproduct_idカラムとProductsテーブルのidカラムを結合して、商品情報と購入履歴を取得
        $product = Product::with('sales')->where('id', $product_id)->first();

        // 商品が存在しない場合はエラーを返す
        if (!$product) {
            return response()->json(['error' => '商品が存在しません'], 404);
        }
        // 在庫数が不足している場合はエラーを返す
        if ($product->stock < 0) {
            return response()->json(['error' => '在庫が不足しています'], 400);
        }
        
        // 在庫数を減らす
        $product->stock -= 1;
        $product->save();
        
        // Sale モデルを作成する
        $sale = new Sale;
        $sale->id = $newId;
        
        // 販売された商品のIDと数量を設定する
        $sale->product_id = $product_id;
        
        // Sale モデルを保存する
        $sale->save();
        
        // レスポンスを返す
        return response()->json(['message' => '商品が購入されました'], 200);
    }
    

}
