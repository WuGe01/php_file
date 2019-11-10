<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳圖案機制
 * 3.取得圖檔資源
 * 4.進行圖形處理
 *   ->圖形縮放
 *   ->圖形加邊框
 *   ->圖形驗證碼
 * 5.輸出檔案
 */
include_once "base.php";

if(!empty($_FILES) && $_FILES['file']['error']==0){

    $note=$_POST['note'];
    $type=$_FILES['file']['type'];
    $filename=$_FILES['file']['name'];
    $path="./upload/" . $filename;
    $thmbPath="./thmb/s_" . $filename;
    
    move_uploaded_file($_FILES['file']['tmp_name'] , $path);

    $sql="insert into files (`name`,`type`,`path`,`note`,`thmb`) values('$filename','$type','$path','$note','$thmbPath')";
    echo $sql;
    $result=$pdo->exec($sql);

    if($result==1){

        echo "上傳成功";

    }else{

        echo "DB有誤";

    }

    $imgSrc=$path;

    //取得來源圖片資訊
    $imgInfo=getimagesize($imgSrc);

    //設定縮放比例
    $rate=0.2;
    
    //計算縮放後的大小
    $dst_w=$imgInfo[0]*$rate;
    $dst_h=$imgInfo[1]*$rate;
    
    //建立縮圖圖層畫布及來源圖片轉成圖形資源
    $thm=imagecreatetruecolor($dst_w,$dst_h);
    $src=imagecreatefrompng($imgSrc);

    //進行縮放
    imagecopyresampled($thm,$src,0,0,0,0,$dst_w,$dst_h,$imgInfo[0],$imgInfo[1]);

    //儲存縮圖
    imagepng($thm,$thmbPath);


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP圖形處理</title>
    <link rel="stylesheet" href="style.css">
    <style>
    a{
        display: inline-block;
        border: 1px solid #ccc;
        padding: 5px 15px;
        border-radius: 20px;
        box-shadow: 1px 1px 3px #ccc;
    }
    
    </style>    
</head>
<body>
<h1 class="header">圖形處理練習-縮放</h1>
<!---建立檔案上傳機制--->
<form action="image.php" method="post" enctype="multipart/form-data">
  檔案：<input type="file" name="file" ><br><br>
  說明：<input type="text" name="note" ><br>
  <input type="submit" value="上傳">
</form>

<!----透過資料表來顯示檔案的資訊，並可對檔案執行更新或刪除的工作----->

<table>
    <tr>
        <td>編號</td>
        <td>檔名</td>
        <td>類型</td>
        <td>縮圖</td>
        <td>路徑</td>
        <td>說明</td>
        <td>首次上傳</td>
        <td>操作</td>
    </tr>

    <?php
        $sql="select * from files";
        $rows=$pdo->query($sql)->fetchAll();
        foreach ($rows as $key => $file) {  
    ?>
    <tr>
        <td><?=$file['id'];?></td>
        <td><?=$file['name'];?></td>
        <td><?=$file['type'];?></td>
        <td><a href="<?=$file['path'];?>"><img src="<?=$file['thmb'];?>"></a></td>
        <td><?=$file['path'];?></td>
        <td><?=$file['note'];?></td>
        <td><?=$file['create_time'];?></td>
        <td>
            <a href="edit_file.php?id=<?=$file['id'];?>">更新檔案</a>
            <a href="del_file.php?id=<?=$file['id'];?>">刪除檔案</a>
        
        </td>
    </tr>
   
    <?php
     }
    ?>

</table>


<!----縮放圖形----->
<?php 

/* $imgSrc="縮放測試.png";
$imgInfo=getimagesize($imgSrc);
$rate=0.1;

//計算縮放後的大小
$dst_w=$imgInfo[0]*$rate;
$dst_h=$imgInfo[1]*$rate;

$thm=imagecreatetruecolor($dst_w,$dst_h);
$src=imagecreatefrompng($imgSrc);
imagecopyresampled($thm,$src,0,0,0,0,$dst_w,$dst_h,$imgInfo[0],$imgInfo[1]);
imagepng($thm,"thm.png"); */

/* $background = imagecolorallocate($bg, 255, 0, 0);
imagefill($bg,0,0,$background); */
//imagefill($img,50,50,$background);
/* imagecopymerge($img,$bg,25,25,0,0,50,50,100); */
//imagepng($img,"test.png");
//imagepng($bg,"bg.png");

?>
<!-- <img src="縮放測試.png"><br>
<img src="thm.png"> -->
<!-- <img src="bg.png"> -->



<!----圖形加邊框----->


<!----產生圖形驗證碼----->



</body>
</html>