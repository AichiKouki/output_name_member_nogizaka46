 <!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>メンバーの名前を当てるAI</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script><!--必ずjQuery本体を先に読み込む-->
<script src="common/scripts/display_loading.js"></script><!--ローディング画面表示機能-->
<link rel="stylesheet" href="common/css/style.css"><!--ページ全体のデザイン-->
</head>
<body>
<header>
<h1><a href="index.html"><img src="common/images/Nogizaka_logo.png" alt="">is_this_member_who</a></h1><!--ここはGoogleFontsから読み込んでいるので、表示が少しだけ遅い-->

<nav><!--ナビゲーションメニューであることを明確にする-->
<ul><!--ここにリストを作成した瞬間に、header h1のGoogleFontsによるフォントが変わってしまった-->
<li><a href="index.html">トップ</a></li>
<li><a href="news.html">お知らせ</a></li>
<li><a href="about.html">サイトについて</a></li>
<li><a href="contact.html">お問い合わせ</a></li>
<ul>
</nav>

</header>
<h1>このメンバー誰だっけ？？<br>画像からメンバーの名前を出力します</h1>
<h2>名前の知りたいメンバーの画像を選択してね(卒業メンバーは含まない)</h2>
<h3>画像処理が失敗して判定ミスをする場合があるので、できるだけ顔だけが写っているような画像だと精度が上がります</h3>
<img border="0" src="images/sample.jpg" width="150" height="150" alt="フリー素材">
<h2>顔だけを抜き取る画像処理も行いますが、できるだけ上の画像のように顔だけが写ってる写真が好ましいです</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
	<p>ファイル：<input type="file" name="userfile" size="40" /></p>
	<p><input type="submit" onClick="disp()" value="アップロード" /></p>
</form>
<div class="loading"></div>
<?php
//ファイルがセットされていたら
if(isset($_FILES["userfile"]["tmp_name"])){
//index.htmlから、画像をアップロードされるので、その画像をローカルに保存
$tempfile = $_FILES["userfile"]["tmp_name"];
//$filename = $_FILES["userfile"]["name"]; //アップされたファイルの名前を取得できる
$filename="uploadImage.jpg";
$result = move_uploaded_file($tempfile, "upload/".$filename);//指定したパスにファイルを保存

//入力された画像をopenCVで画像処理して、顔だけを抜き取る(成功しないこともある)
$fullPath = '/Users/aichitakumiki/anaconda3/envs/python2/bin/python2 crop_face.py';
exec($fullPath);//pythonのプログラムにコール行為を発生させる

//Pythonを実行して、判別処理
$fullPath = '/Users/aichitakumiki/anaconda3/bin/python ./predict_face.py '; //pythonに「検索語」を渡す
exec($fullPath,$outpara);//pythonのプログラムにコール行為を発生させる

$nogi_name="";
//Python側でprintされた文字列を取得して、その結果に基づいて判定処理
if($outpara[0]=="akimoto")  $nogi_name="秋元真夏";
else if($outpara[0]=="hoshino")  $nogi_name="星野みなみ";
else if($outpara[0]=="saito_asuka")  $nogi_name="齋藤飛鳥";
else if($outpara[0]=="shiraishi")  $nogi_name="白石麻衣";

//判定結果を出力
echo "<h1>この方は".$nogi_name."さんです！"."</h1>";
echo "<img src='upload/uploadImage.jpg' style='float:left;margin-right:4px;margin-bottom:4px;''>";
echo "<h2>ちなみに、".$nogi_name."さんはこの方です</h2>";
echo "<img src='images/all/1/".$outpara[0].".jpg' style='float:left;margin-right:4px;margin-bottom:4px;''>";

//メンバーそれぞれの値の結果を出力(デバッグ用)
//echo "#{'akimoto': 0, 'hoshino': 1, 'saito': 2, 'shiraishi': 3}<br>";
echo $outpara[1];
}
?>

<footer>
<small>Copyright &copy; is_this_member_who,all rights reserved.</small>
</footer>

</body>
</html>