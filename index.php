 <!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>メンバーの名前を当てるAI</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script><!--必ずjQuery本体を先に読み込む-->
<script src="common/scripts/display_loading.js"></script><!--ローディング画面表示機能-->
<link rel="stylesheet" href="common/css/style.css"><!--ページ全体のデザイン-->
<style>
/*ローディング画面の配置処理*/
.loading{
	float:right; /*div要素を右に回り込みをさせる*/
	margin-left:0px;/*サンプル画像とローディング画像の間に余白が大きいので修正する*/
}
</style>
</head>
<body>
<header>
<h1><a href="index.html"><img src="common/images/Nogizaka_logo.png" alt="">文化祭企画</a></h1><!--ここはGoogleFontsから読み込んでいるので、表示が少しだけ遅い-->
<!--ナビゲーションメニューであることを明確にする-->
<nav>
<ul><!--ここにリストを作成した瞬間に、header h1のGoogleFontsによるフォントが変わってしまった-->
<li><a href="index.html">no_data</a></li>
<li><a href="news.html">no_data</a></li>
<li><a href="about.html">no_data</a></li>
<li><a href="contact.html">no_data</a></li>
<ul>
</nav>

</header>
<!--システムの注意書き-->
<h1>このメンバー誰だっけ？？画像からメンバーの名前を表示します</h1>
<h2>名前の知りたいメンバーの画像を選択してね(卒業メンバーは含まない)</h2>
<h3>もし画像処理の失敗や判定にミスがあれば、下の画像のようにできるだけ顔だけが写ってるような画像でリトライしてみてください</h3>
<div class="advice">
<h3>※判定ミスをしやすい画像の特徴</h3>
<ul id="caution">
<li>目をかなり細めて笑っている</li>
<li>横を向いている</li>
<li>顔の近くに何かある(手など)</li>
<li>認識対象のメンバーが遠くにいる</li>
<li>複数の人物が写っている</li>
<li>女性にありがちな、画像加工がされていたり化粧の有無や違い</li>
<li>文字や線などが含まれている複雑な写真(ポスターなど)</li>
<li>乃木坂46のメンバーではない</li>
</ul>
</div>
<div class="loading"></div><!--ローディング画面の表示部分-->
<h2></h2>
<!--実際に画像を入力するフォーム-->
<form action="index.php" method="post" enctype="multipart/form-data">
	<p>ファイル：<input type="file" name="userfile" size="40" /></p>
	<p><input type="submit" onClick="disp()" value="アップロード" /></p>
</form>
<?php
//ファイルがセットされていたら
if(isset($_FILES["userfile"]["tmp_name"])){
//index.htmlから、画像をアップロードされるので、その画像をローカルに保存
$tempfile = $_FILES["userfile"]["tmp_name"];
//$filename = $_FILES["userfile"]["name"]; //アップされたファイルの名前を取得できる
$filename="uploadImage.jpg";//判定対象の画像となる、アップロードされたファイル名を決める
$result = move_uploaded_file($tempfile, "upload_before/".$filename);//指定したパスにファイルを保存

//入力された画像をopenCVで画像処理して、顔だけを抜き取る
$fullPath = '/Users/aichitakumiki/anaconda3/envs/python2/bin/python2 crop_face.py';
exec($fullPath,$outpara1);//outpara1の部分は、またexec関数使うなら名前は被っちゃダメ
//この時点で画像処理に失敗していたら、判定を中断
if($outpara1[0]=="can't_crop"){
	echo "<h2>画像処理ができない画像のため、判定できません。他の画像で試してみてね</h2>";
	exit();
}
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
echo "<h1>この方は".$nogi_name."さんだと思います！"."</h1>";
//ユーザーがアップした画像をそのまま表示
echo "<img src='upload_before/uploadImage.jpg' style='float:left;margin-right:4px;margin-bottom:4px;width:400px;height:auto;'''>";
//画像加工前と加工後を比較するときの矢印の画像を表示
echo "<img src='common/images/yajirusi.png' style='float:left;margin-right:4px;margin-bottom:4px;''>";
//ユーザーがアップした画像の顔だけ抜き取った画像処理後の画像を表示
echo "<img src='upload_after/uploadImage.jpg' style='float:left;margin-right:4px;margin-bottom:4px;''>";
//実際に判定結果を出力
echo "<h2>ちなみに、".$nogi_name."さんはこの方です</h2>";
echo "<img src='images/all/1/".$outpara[0].".jpg' style='float:left;margin-right:4px;margin-bottom:4px;''>";

//メンバーそれぞれの値の結果を出力(デバッグ用)
echo "{'akimoto': 0, 'hoshino': 1, 'saito': 2, 'shiraishi': 3}<br>";
echo $outpara[1];
}
?>

<footer>
<small>Copyright &copy; Answer_the_name_of_the_member_AI,all rights reserved.</small>
</footer>

</body>
</html>