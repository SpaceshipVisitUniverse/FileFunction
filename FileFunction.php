<?php
/**
 * 向文件中写入内容,并且判断是否清空原来的文件数据
 * @method write_file1
 * @param  string      $filename  文件名
 * @param  mixed       $data      数据
 * @param  boolean     $clearFlag 是否清空文件
 * @return boolean                 true|false
 */
function write_file(string $filename,$data,bool $clearFlag=false){
  $dirname=dirname($filename);
  //检测目标路径是否存在
  if(!file_exists($dirname)){
    mkdir($dirname,0777,true);
  }
  //检测文件是否存在并且可读
  if(is_file($filename)&&is_readable($filename)){
    //读取文件内容，之后和新写入的内容拼装到一起
    if(filesize($filename)>0){
      $srcData=file_get_contents($filename);
    }
  }

  //判断内容是否是数组或者对象
  if(is_array($data)||is_object($data)){
    //序列化数据
    $data=serialize($data);
  }
if($clearFlag==true){
	if(file_put_contents($filename,$data)!==false){
    return true;
  }else{
    return false;
  }
}else{
	$data=$srcData.$data;
}
 if(file_put_contents($filename,$data)!==false){
    return true;
  }else{
    return false;
  }
}
/**
*@method down_file
*@parm string		$filename:FileName
*@return bool		true|false
*/
/**
 * 下载文件
 * @method down_file
 * @param  string    $filename     文件名
 * @param  array     $allowDownExt 允许下载的文件类型
 * @return void
 */
function down_file1(string $filename,array $allowDownExt=array('jpeg','jpg','png','gif','txt','html','php','rar','zip')){
  //检测下载文件是否存在，并且可读
  if(!is_file($filename)||!is_readable($filename)){
    return false;
  }
  //检测文件类型是否允许下载
  $ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
  if(!in_array($ext,$allowDownExt)){
    return false;
  }
  //通过header()发送头信息

  //告诉浏览器输出的是字节流
  header('Content-Type:application/octet-stream');

  //告诉浏览器返回的文件大小是按照字节进行计算的
  header('Accept-Ranges: bytes');

  $filesize=filesize($filename);
  //告诉浏览器返回的文件大小
  header('Accept-Length: '.$filesize);

  //告诉浏览器文件作为附件处理，告诉浏览器最终下载完的文件名称
  header('Content-Disposition: attachment;filename=king_'.basename($filename));

  //读取文件中的内容

  //规定每次读取文件的字节数为1024字节，直接输出数据,切片上传，减少服务器内耗
  //Section to upload, reduce server internal friction
  $read_buffer=1024;
  $sum_buffer=0;
  $handle=fopen($filename,'rb');
  while(!feof($handle) && $sum_buffer<$filesize){
    echo fread($handle,$read_buffer);
    $sum_buffer+=$read_buffer;
  }
  fclose($handle);
  exit;
}
