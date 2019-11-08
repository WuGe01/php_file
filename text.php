<?php
/****************************************************
1.fopen(file,mode,path,context)
  ->r 唯讀
  ->r+ 讀寫，由檔案開頭開始
  ->w 寫入，由檔案開頭開始並將檔案清空，無檔案則建立檔案
  ->w+ 讀寫，由檔案開頭開始並將檔案清空，無檔案則建立檔案
　->a 寫入，由檔案尾端開始，無檔案則建立檔案
　->a+ 寫入，由檔案尾端開始，無檔案則建立檔案
  ->wb 寫入，轉換換行格式為\r\n
  ->file_exists() 判斷檔案是否存在
2.建立要寫入檔案的內容 str
  ->斷行 \n or \r\n
3.fwrite(file,str) 寫入檔案中
4.fclose() 關閉檔案
*****************************************************/

$file=fopen("hello.txt","w");

$str="hello world! \r\ntoday is a good day,very good day";

fwrite($file,$str);

fclose($file);

?>