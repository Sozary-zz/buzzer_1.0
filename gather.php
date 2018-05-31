<?php

if(isset($argv[1])){

  $a = scandir($argv[1].'/');
  $data = array();
  foreach ($a as $v  ) {
    $t = preg_split('/\./',$v);
    if($t[count($t)-1] == "buzz"){
      $p = preg_split('/-/',$t[0]);
      if($p[1] == $argv[1]){
        $data[$p[0]]=file_get_contents($argv[1].'/'.$v);
        unlink($argv[1].'/'.$v);
      }
    }
  }
  arsort($data);


  $str="";

  foreach ($data as $key => $value)
    $str= $str.' '.$key.','.$value;
    if($str!="")
        file_put_contents($argv[1].'/'.$argv[1].'.res',$str,FILE_APPEND);


}
