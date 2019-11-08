<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳檔案機制
 * 3.取得檔案資源
 * 4.取得檔案內容
 * 5.建立SQL語法
 * 6.寫入資料庫
 * 7.結束檔案
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文字檔案匯入</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 class="header">文字檔案匯入練習</h1>
<!---建立檔案上傳機制--->
<form action="?" method="post" enctype="multipart/form-data">
    檔案: <input type="file" name="file" id="file"><br>
    <input type="submit" value="上傳">
</form>

<?php

if(!empty($_FILES) && $_FILES['file']['error']==0){
    move_uploaded_file($_FILES['file']['tmp_name'],"./upload/tmp.txt");
}

?>
<!----讀出匯入完成的資料----->
<?php

/****
 * 1.讀入檔案
 *  fopen()
 * 2.讀入每一行的資料
 *   fgets()/fgetcsv()
 * 3.解析每一行的欄位
 *    explode()
 * 4.串成SQL語法
 *  $sql="INSERT INTO `retire` (`id`, `year`, `num`, `pro`) VALUES (NULL, '', '', '')";
 *X 5.寫入資料庫
 *  pdo連線
 * 
 * 6.迴圈
 *  while()
 * 7.判斷是否還有資料
 *  feof()
 * 
 * 8.略過標題
 *  if......
 */

if(file_exists("./upload/tmp.txt")){
$dsn="mysql:host=localhost;charset=utf8;dbname=etax";
$pdo=new PDO($dsn,"root","mack");

$file=fopen("./upload/tmp.txt","r");
$line=fgets($file);  //從第一行開始讀起  ,但不處理第一行的資料


while(!feof($file)){
    $line=fgets($file);  //從第二行開始讀起  
    //echo $line;
    //echo "<br>";
    $data=explode(",",$line);
    echo count($data)."<br>";
    if(count($data)>1){
        $sql="INSERT INTO `retire` (`id`, `year`, `num`, `pro`) VALUES (NULL, " . $data[0] . " , ".$data[1].", ".$data[2].")";
      //  echo "<br>".$sql;
    $pdo->exec($sql);
    }
}

unlink("./upload/tmp.txt");

}


?>
</body>
</html>