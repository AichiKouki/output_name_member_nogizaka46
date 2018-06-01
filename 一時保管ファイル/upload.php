<?php
$tempfile = $_FILES["userfile"]["tmp_name"];
$filename = $_FILES["userfile"]["name"];
$result = move_uploaded_file($tempfile, "upload/".$filename);
?>