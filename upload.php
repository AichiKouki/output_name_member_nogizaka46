<?php
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
else if($outpara[0]=="saito")  $nogi_name="星野みなみ";
else if($outpara[0]=="shiraishi")  $nogi_name="白石麻衣";

echo "<h1>この方は".$nogi_name."さんです！"."</h1>";

?>