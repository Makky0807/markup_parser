<?php

define('IN_TAG', 0);   // タグを含める
define('OUT_TAG', 1);  // タグを含めない

/*==========================================================
  HTML/XML からデータを取り出すクラス
==========================================================*/
class MarkupParser
{
  // 指定したタグの中身を返す
  public function getTagData(Model $model, $selector, $src, $tag = OUT_TAG)
  {
    $selector = preg_quote( $selector );
    $closer = explode(' ', $selector)[0];
    preg_match("/<$selector.*?>([\s\S]*?)<\/$closer>/", $src, $matches);
    $result = trim( $matches[$tag] );
    if( isset( $result ) && $result != "&nbsp;" ){
      return $result;
    }
    return 'NULL';
  }



  // 指定した全てのタグの中身を配列で返す
  public function getTagDataAll(Model $model, $selector, $src, $tag = OUT_TAG)
  {
    $selector = preg_quote( $selector );
    $closer = explode(' ', $selector)[0];
    preg_match_all("/<$selector.*?>([\s\S]*?)<\/$closer>/", $src, $matches);

    foreach( $matches[$tag] as $mat ){
      $result[] = trim( $mat );
    }
    return $result;
  }



  // 最初に一致する, 指定したタグのプロパティを返す
  public function getTagProp(Model $model, $selector, $src)
  {
    $propaty = [];
    $selector = preg_quote( $selector );
    $is_success = preg_match("/<$selector(.*?)>/", $src, $matches);

    // プロパティをスペースで分割
    if( $is_success ){
      $words = explode(' ', $matches[1]);
      foreach($words as $word){
        if( ! empty($word) ){
          $key = explode('=', $word);
          preg_match('/[a-zA-Z0-9\-\_\.\/:]+/', $key[1], $prop);
          $key[1] = $prop[0];
          $propaty += [$key[0] => trim( isset($key[1]) ? $key[1] : '', '"')];
        }
      }
    }

    return $propaty;
  }

}