<?php
print"<?xml version=\"1.0\" encording=\"UTF-8\">";
print"<meta charset=\"UTF-8\" />";
/* �X�N���[�s���O�֐��Q�̃C���N���[�h */
include( "scrape_func.php" );

/* getURL()�֐����g�p���āA�y�[�W�̐��f�[�^���擾����B */
$_rawData = getURL( "http://trans.hiragana.jp/ruby/http://www.yomiuri.co.jp/" );

/* ���f�[�^��UTF-8�ɕϊ�����B */
$_rawData = mb_convert_encoding($_rawData, "UTF-8", "auto");

/* ��͂��₷���悤�A���f�[�^�𐮗�����B */
$_rawData = cleanString( $_rawData );

/* ���͎኱��₱�����B�@�K�v�ȍ��ڂ̊J�n�����ƏI�������́A���O��
   HTML����m�F���Ă���B�@�������������̂𗘗p���ĕK�v�ȃf�[�^���擾
   ����B */
$_rawData = getBlock( "<div class=\"listOsusume\">",
                      "<div id=\"subColumn2\">", $_rawData );

/* ����ŉӏ������ɕK�v�ȓ���f�[�^������ł����B
   �����ł͍��ڂ�z�񉻂�����A�J��Ԃ��ŏ������s���Ă���B */
$_rawData = explode( "<rb>", $_rawData );

/* �J��Ԃ����s���Ȃ���A�X�̍��ڂ���͂���B */
foreach( $_rawData as $_rawBlock ) {
   $_item = array(  );
   $_rawBlock = trim( $_rawBlock );
   if( strlen( $_rawBlock ) > 0 ) {

   /*   ���r��<rt> ... </rt>�Ԃɂ���B */
   $_item[ "ruby" ] = strip_tags( getBlock( "<rt>","</rt>", $_rawBlock ) );

   /*   ���肪�Ȃ�</ruby> ... <ruby>�Ԃɂ���B */
   $_item[ "text" ] = strip_tags( getBlock( "</ruby>","<ruby>", $_rawBlock ) );
   
      /*   �X�N���[�s���O�������ʂ��o�͂���B */
	   print( implode( chr(10), $_item ) . chr(10) . chr(10) );
   }
}
?>
