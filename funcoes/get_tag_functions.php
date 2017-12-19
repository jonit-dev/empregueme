<?php
function getAttribute($attrib, $tag){
  //get attribute from html tag
  $re = '/'.$attrib.'=["\']?([^"\' ]*)["\' ]/is';
  preg_match($re, $tag, $match);
  if($match){
    return urldecode($match[1]);
  }else {
    return false;
  }
}
?>