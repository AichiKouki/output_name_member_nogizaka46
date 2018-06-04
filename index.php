 <!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title></title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script><!--必ずjQuery本体を先に読み込む-->
<script src="common/scripts/display_loading.js"></script>
</head>
<body>
<div class="loading"></div>
<h1>このメンバー誰だっけ？？<br>新しく乃木坂46に興味を持った人を幸せにします</h1>
<h2>名前の知りたいメンバーの画像を選択してね</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
	<p>ファイル：<input type="file" name="userfile" size="40" /></p>
	<p><input type="submit" onClick="disp()" value="アップロード" /></p>
</form>
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
else if($outpara[0]=="saito")  $nogi_name="齋藤飛鳥";
else if($outpara[0]=="shiraishi")  $nogi_name="白石麻衣";

echo "<h1>この方は".$nogi_name."さんです！"."</h1>";
echo "<img src='upload/uploadImage.jpg' style='float:left;margin-right:4px;margin-bottom:4px;''>";
}
?>
</body>
</html>