﻿function disp(){
 $('.loading').append('<img src="common/images/loading.gif" width="50%" style="text-align:center">');
}

/*
検索ボタンがクリックされると、別の箇所でphp関数が呼び出される。
php関数の処理が完了するとブラウザが再読み込みされ、ページが構成される。
この時、後から追加されていたローディング画像は再読みみによって初期状態に戻っているため表示されなくなる
という仕組み
*/