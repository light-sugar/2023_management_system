$(function () {

    // 検索ボタンクリックしてイベント発生
    $('#search-form-btn').on('click', function () {
        // 検索キーワードを取得
        var productName = $("#product_name").val();
        var companyId = $("#company_id").val();
        // 下限・上限価格を取得
        var minPrice = $("#min_price").val();
        var maxPrice = $("#max_price").val();
        // 下限・上限在庫数を取得
        var minStock = $("#min_stock").val();
        var maxStock = $("#max_stock").val();

        // console.log(productName);
        // console.log(companyId);

        $.ajax({
            url: '/psearch',
            type: 'GET',
            // 検索キーワードを送信する
            data: {
                // 左はphpで受け取る時のキー名、右がjsの変数
                product_name: productName,
                company_id: companyId,
                min_price: minPrice,
                max_price: maxPrice,
                min_stock: minStock,
                max_stock: maxStock,
            },
            dataType: 'json',
        })
            .done(function (data) {

                if (data.error) {
                    alert(data.error);
                    return;
                }
                // テーブルのtbody要素を取得
                var tbody = $('#search-result');
                // 現在の商品一覧表示をクリア
                tbody.empty();

                // JSONデータをループしてテーブルに追加
                $.each(data.products, function (i, product) {
                    var row = $('<tr>');
                    row.append($('<td>').text(product.id));
                    row.append($('<td>').html('<img src="' + product.img_path + '" alt="' + product.product_name + '" width="50" height="50">'));
                    row.append($('<td>').text(product.product_name));
                    row.append($('<td>').text(product.price));
                    row.append($('<td>').text(product.stock));
                    row.append($('<td>').text(product.company.company_name));
                    row.append($('<td>').html('<a><button type="submit" class="btn btn-info">詳細</button></a>'));
                    row.append($('<td>').html('<button type="button" id="delete-btn" class="btn btn-danger" data-product-id="' + product.id + '">削除</button>'));
                    tbody.append(row);
                });

            })
            .fail(function (XMLHttpRequest, textStatus, errorThrown) {
                alert('検索できてないよ');
                console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
            });
    });

    //削除ボタンのクリックイベント
    $(document).on('click', '.btn.btn-danger', function () {
        var deleteBtn = $(this);
        //確認ダイアログを表示、OKが押されると削除処理実行
        if (confirm('削除してよろしいですか？')) {
            //商品IDを取得
            var productId = deleteBtn.data('product-id');
            // 削除処理を実行するajaxリクエスト
            $.ajax({
                url: '/destroy/' + productId,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'delete'
                },
                datatype: 'json'
            })
                .done(function (data) {
                    // 成功時の処理
                    deleteBtn.off('click');
                    location.reload();

                })
                .fail(function (XMLHttpRequest, textStatus, errorThrown) {
                    // 削除が失敗した場合の処理
                    alert('削除に失敗しました。');
                    console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                    console.log("textStatus     : " + textStatus);
                    console.log("errorThrown    : " + errorThrown.message);
                });
        }
    });

});

