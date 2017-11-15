<?php
require_once('MarkupParser.php');
/*==========================================================
  Rss解析専用のパーサ
==========================================================*/
class RssParser extends MarkupParser
{
  // 記事をリストアップ
  public function rssArticles(Model $model, $src)
  {
    return $this->getTagDataAll($model, 'item', $src);
  }

  // RSSの記事タイトルを取得
  public function rssTitle(Model $model, $src)
  {
    return $this->getTagData($model, 'title', $src);
  }

  // RSSの記事URLを取得
  public function rssLink(Model $model, $src)
  {
    return $this->getTagData($model, 'link', $src);
  }

  // RSSのメディアコンテンツを取得
  public function rssMedia(Model $model, $src)
  {
    return $this->getTagProp($model, 'enclosure', $src);
  }
}