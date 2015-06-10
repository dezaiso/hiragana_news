<?phpprint"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";print"<datas>\n<data>";/* スクレーピング関数群のインクルード */include( "scrape_func.php" );/* getURL()関数を使用して、ページの生データを取得する。 */$_rawData = getURL( "http://trans.hiragana.jp/ruby/http://www.asahi.com/" );/* 生データをUTF-8に変換する。 */$_rawData = mb_convert_encoding($_rawData, "UTF-8", "auto");/* 解析しやすいよう、生データを整理する。 */$_rawData = cleanString( $_rawData );/* 次は若干ややこしい。　必要な項目の開始部分と終了部分は、事前に   HTMLから確認してある。　こういったものを利用して必要なデータを取得   する。 */$_rawData = getBlock( "<div id=\"News\" class=\"Box\">",                      "<div id=\"TopDatePic\">", $_rawData );/* これで箇条書きに必要な特定データが入手できた。   ここでは項目を配列化した後、繰り返しで処理を行っている。 */$_rawData = explode( "<rb>", $_rawData );/* 繰り返しを行いながら、個々の項目を解析する。 */foreach( $_rawData as $_rawBlock ) {   $_item = array(  );   $_rawBlock = trim( $_rawBlock );   if( strlen( $_rawBlock ) > 0 ) {   /*   ルビを<rt> ... </rt>の間から取り出す。 */   $_item[ "ruby" ] = strip_tags( getBlock( "<rt>","</rt>", $_rawBlock ) );   /*   送りがなを</ruby> ... <ruby>の間から取り出す。 */   $_item[ "text" ] = strip_tags( getBlock( "</ruby>","<ruby>", $_rawBlock ) );   /*   いったんキレイにして。 */   $_text[ "ruby" ] = trim( $_item[ "ruby" ] );   $_text[ "text" ] = trim( $_item[ "text" ] );       /*   全部をいっぺんまとめる。 */	   $_allText = implode( "", $_text);	   	   /*   全角スペースをトル。 */	   $preReplace1 ="　";	   $postReplace1 = "";	   $_data1  =  str_replace($preReplace1, $postReplace1, $_allText );	   /*   半角スペースをトル。 */	   $_data1 = preg_replace("/\s+/", "", $_data1 );	   /*   「)」の後ろに「</data>\n<data>」を入れる */	   $preReplace =")";	   $postReplace = ")</data>\n<data>";	   $_data  =  str_replace($preReplace, $postReplace, $_data1 );	   	   	   print($_data);   }}print"</data>\n</datas>";?>