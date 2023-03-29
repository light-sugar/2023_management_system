$(function () {
    $('#search-form').submit(function (event) {
        // フォームの送信イベントをキャンセル
        event.preventDefault();

        // 検索キーワードを取得
        var keyword = $(this).find('input[name="keyword"]').val();

        $.ajax({
            // 検索処理を行うURL
            url: '/psearch',
            type: 'GET',
            // 検索キーワードを送信
            data: { keyword: keyword }
        })
            .done(function (response) {
                // 商品一覧を更新
                $('#plist-table').html(response);
            })
            .fail(function () {
                alert('検索に失敗しました');
            });
    });

    // ページが読み込まれた時にAjaxリクエストを送信
    sendAjaxRequest();

    function sendAjaxRequest() {
        $.ajax({
            // 商品一覧を取得するURL
            url: '/plist',
            type: 'GET'
        })
            .done(function (response) {
                // 商品一覧を更新
                $('#plist-table').html(response);
            })
            .fail(function () {
                alert('商品一覧の取得に失敗しました');
            });
    };
});


