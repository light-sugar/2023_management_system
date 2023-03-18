@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card ml-3 w-75">
                    <div class="card-header">確認画面</div>
                    <div class="card-body">
                        {{-- productの新規登録確認画面 --}}
                        <form action="{{ route('finish') }}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label for="product_name" class="col-sm-2 col-form-label">商品名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="product_name" class="form-control"
                                        value="{{ old('product_name') }}">
                                </div>
                            </div>
                            <div class="selectbox row">
                                <label for="company_name" class="col-sm-2 col-form-label">メーカー</label>
                                <div class="col-sm-10">{{ old('company_name') }}</div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="price" class="col-sm-2 col-form-label">価格</label>
                                <div class="col-sm-10">{{ $price }}</div>
                            </div> --}}
                            <div class="form-group row">
                                <label for="price" class="col-sm-2 col-form-label">価格</label>
                                <div class="col-sm-10">{{ $product->price }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stock" class="col-sm-2 col-form-label">在庫数</label>
                                <div class="col-sm-10">{{ $stock }}</div>
                            </div>
                            <div class="form-group row">
                                <label for="comment" class="col-sm-2 col-form-label">コメント</label>
                                <div class="col-sm-10">{{ $comment }}</div>
                            </div>
                            <div class="form-group row">
                                <label for="img_path" class="col-sm-2 col-form-label">商品画像</label>
                                <div class="col-sm-10">
                                    <img src="{{ asset('img/' . session()->get('img_path')) }}">
                                </div>
                            </div>
                            {{-- 新規登録ボタン --}}
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">登録</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- 戻るボタン --}}
                <div class="text-right">
                    <a class="btn btn-primary" href="#" role="button">戻る</a>
                </div>
            </div>
        </div>
    </div>
@endsection
