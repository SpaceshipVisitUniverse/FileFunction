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

