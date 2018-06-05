 <!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title></title>
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
<form action="index.php" method="post" enctype="multipart/form-data">
	<p>ファイル：<input type="file" name="userfile" size="40" /></p>
	<p><input type="submit" onClick="disp()" value="アップロード" /></p>
</form>
<div class="loading"></div>
<?php
if(isset($_FILES["userfile"]["tmp_name"])){
//index.htmlから、画像をアップロードされるので、その画像をローカルに保存
$tempfile = $_FILES["userfile"]["tmp_name"];
//$filename = $_FILES["userfile"]["name"]; //アップされた本当のファイル名
$filename="uploadImage.jpg";
$result = move_uploaded_file($tempfile, "upload/".$filename);

//Pythonを実行して、判別処理
$fullPath = '/Users/aichitakumiki/anaconda3/bin/python ./predict_face.py '; //pythonに「検索語」を渡す
exec($fullPath,$outpara);//pythonのプログラムにコール行為を発生させる
$nogi_name="";
if($outpara[0]=="akimoto")  $nogi_name="秋元真夏";
else if($outpara[0]=="hoshino")  $nogi_name="星野みなみ";
else if($outpara[0]=="saito_asuka")  $nogi_name="齋藤飛鳥";
else if($outpara[0]=="shiraishi")  $nogi_name="白石麻衣";

echo "<h1>この方は".$nogi_name."さんです！"."</h1>";
echo "<img src='upload/uploadImage.jpg' style='float:left;margin-right:4px;margin-bottom:4px;''>";
echo "<h2>ちなみに、".$nogi_name."さんはこの方です</h2>";
echo "<img src='images/all/1/".$outpara[0].".jpg' style='float:left;margin-right:4px;margin-bottom:4px;''>";

}
?>

<footer>
<small>Copyright &copy; is_this_member_who,all rights reserved.</small>
</footer>

</body>
</html>