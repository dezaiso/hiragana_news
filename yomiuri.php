<?php
print"<?xml version=\"1.0\" encording=\"UTF-8\">";
print"<meta charset=\"UTF-8\" />";
/* スクレーピング関数群のインクルード */
include( "scrape_func.php" );

/* getURL()関数を使用して、ページの生データを取得する。 */
$_rawData = getURL( "http://trans.hiragana.jp/ruby/http://www.yomiuri.co.jp/" );

/* 生データをUTF-8に変換する。 */
$_rawData = mb_convert_encoding($_rawData, "UTF-8", "auto");

/* 解析しやすいよう、生データを整理する。 */
$_rawData = cleanString( $_rawData );

/* 次は若干ややこしい。　必要な項目の開始部分と終了部分は、事前に
   HTMLから確認してある。　こういったものを利用して必要なデータを取得
   する。 */
$_rawData = getBlock( "<div class=\"listOsusume\">",
                      "<div id=\"subColumn2\">", $_rawData );

/* これで箇条書きに必要な特定データが入手できた。
   ここでは項目を配列化した後、繰り返しで処理を行っている。 */
$_rawData = explode( "<rb>", $_rawData );

/* 繰り返しを行いながら、個々の項目を解析する。 */
foreach( $_rawData as $_rawBlock ) {
   $_item = array(  );
   $_rawBlock = trim( $_rawBlock );
   if( strlen( $_rawBlock ) > 0 ) {

   /*   ルビは<rt> ... </rt>間にある。 */
   $_item[ "ruby" ] = strip_tags( getBlock( "<rt>","</rt>", $_rawBlock ) );

   /*   送りがなは</ruby> ... <ruby>間にある。 */
   $_item[ "text" ] = strip_tags( getBlock( "</ruby>","<ruby>", $_rawBlock ) );
   
      /*   スクレーピングした結果を出力する。 */
	   print( implode( chr(10), $_item ) . chr(10) . chr(10) );
   }
}
?>
