@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card ml-4 w-75">
                    <div class="card-header">検索</div>
                    <div class="card-body">
                        {{-- 商品名とメーカー名の検索 --}}
                        @csrf
                        {{-- 商品名検索 --}}
                        <div class="form-group row">
                            <label for="product_name" class="col-sm-3 col-form-label">商品名</label>
                            <div class="col-sm-8">
                                <input type="text" id="product_name" name="keyword" class="form-control"
                                    placeholder="商品名を入力してください">
                            </div>
                        </div>
                        {{-- メーカー名検索 --}}
                        <div class="form-group row">
                            <label for="company_id" class="col-sm-3 col-form-label">メーカー</label>
                            <div class="col-sm-8">
                                <select name="company_id" id="company_id"
                                    class="form-control @if ($errors->has('company_id')) is-invalid @endif is-valid">
                                    <option value="">メーカー名を選択してください</option>
                                    {{-- <option value="" selected disabled>メーカー名を選択してください</option> --}}
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            @if (old('company_id', '') == $company->id) selected @endif>{{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- 価格の下限上限 --}}
                        <div class="form-group row">
                            <label for="price"class="col-sm-3 col-form-label">価格の下限上限</label>
                            <div class="form-group col-sm-8">
                                <div class="d-flex">
                                    <input type="number" class="form-control" id="min_price" name="min_price"
                                        placeholder="下限価格">
                                    <span>〜</span>
                                    <input type="number" class="form-control" id="max_price" name="max_price"
                                        placeholder="上限価格">
                                </div>
                            </div>
                        </div>
                        {{-- 在庫の下限上限 --}}
                        <div class="form-group row">
                            <label for="stock"class="col-sm-3 col-form-label">在庫の下限上限</label>
                            <div class="form-group col-sm-8">
                                <div class="d-flex">
                                    <input type="number" class="form-control" id="min_stock" name="min_stock"
                                        placeholder="下限在庫">
                                    <span>〜</span>
                                    <input type="number" class="form-control" id="max_stock" name="max_stock"
                                        placeholder="上限在庫">
                                </div>
                            </div>
                        </div>


                        {{-- 検索ボタン --}}
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="search-form-btn">検索</button>
                        </div>
                    </div>
                </div>
                {{-- 新規登録ボタン --}}
                <div class="text-right">
                    <a class="btn btn-primary" href="{{ route('create') }}" role="button">新規登録</a>
                </div>


                {{-- 商品一覧テーブル --}}
                <div class="text-center">
                    <table class="table" id="plist-table">
                        <thead>
                            <tr>
                                <th scope="col">@sortablelink('id', 'ID')</th>
                                <th scope="col">@sortablelink('img_path', '商品画像')</th>
                                <th scope="col">@sortablelink('product_name', '商品名')</th>
                                <th scope="col">@sortablelink('price', '価格')</th>
                                <th scope="col">@sortablelink('stock', '在庫数')</th>
                                <th scope="col">@sortablelink('company->id', 'メーカー名')</th>
                                <th scope="col">詳細</th>
                                <th scope="col">削除</th>
                            </tr>
                        </thead>
                        <tbody id="search-result">
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td><img src="{{ asset($product->img_path) }}" alt="{{ $product->product_name }}"
                                            width="50" height="50"></td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->company->company_name }}</td>
                                    <td><a href="{{ route('detail', ['id' => $product->id]) }}"><button type="submit"
                                                class="btn btn-info">詳細</button></a>
                                    </td>
                                    <td>
                                        <button type="button" id="delete-btn" class="btn btn-danger"
                                            data-product-id="{{ $product->id }}">削除</button>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- // ページネーションは一旦保留 --}}
                            {{-- {{ $products->links() }} --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
