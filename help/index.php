<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Help & Guide</title>
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/element.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/scroll.css" rel="stylesheet" type="text/css" />
<link href="css/colors.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
mysql_connect('localhost','root','');
mysql_select_db('cmsid_22_0_358');
define('_pre_', 'iw_');
?>

<div id="body-wrap">

<div id="body-menu">
<div id="body-widget">
<div class="box">
<div class="box-head">Support YM</div>
<div class="box-content">
<div style="padding:5px;">
<center>
<a href="ymsgr:sendIM?id.hpaherba">
<img src="http://opi.yahoo.com/online?u=id.hpaherba&amp;m=g&amp;t=1&amp;l=us&amp;opi.jpg" border="0" alt="Status YM">
</a>
</center>
</div>
</div>
</div>

</div>
<div id="body-widget">
<div class="box">
<div class="box-head">Article Help</div>
<div class="box-content">
<ul>
<?php
$i = 1;
$sql_query = mysql_query("SELECT * FROM "._pre_."post WHERE type='post' AND post_topic='2'");
while($data = mysql_fetch_object($sql_query)){
?>
<li><a href="?view=detail&p=<?php echo $data->id;?>"><div class="body-menu-head"><?php echo substr(sprintf('%08d', $i),-3,3);?></div><div class="body-menu-desc"><?php echo strtolower($data->title);?></div></a></li>
<?php
$i++;
}
?>
</ul>
</div></div></div>
</div>

<div id="body-content">
<?php
error_reporting(0);

function sanitize( $string ) { 
	//TRANSLIT or //IGNORE or //TRANSLIT//IGNORE
	$clean = iconv("UTF-8", "ISO-8859-1//IGNORE", $string);	
	//$clean = filter_var($string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	return $clean;
} 

function date_times( $tgl, $jam = true, $hari = true ){
	/*thanks code date from aura
	/*Contoh Format : 2007-08-15 01:27:45*/
	$tanggal = strtotime($tgl);
	$bln_array = array (
		'01'=>'January',
		'02'=>'February',
		'03'=>'Mart',
		'04'=>'April',
		'05'=>'Mey',
		'06'=>'Juny',
		'07'=>'July',
		'08'=>'August',
		'09'=>'September',
		'10'=>'Octtober',
		'11'=>'Nopvemer',
		'12'=>'December'
				);
	$hari_arr = array (	
		'0'=>'Minggu',
		'1'=>'Senin',
		'2'=>'Selasa',
		'3'=>'Rabu',
		'4'=>'Kamis',
		'5'=>'Jum\'at',
		'6'=>'Sabtu'
		);
	$hari 	= $hari ? @$hari_arr[date('w',$tanggal)] : '';
	$tggl 	= date('j',$tanggal);
	$tgl 	= date('d',$tanggal);
	$bln 	= @$bln_array[date('m',$tanggal)];
	$thn 	= date('Y',$tanggal);
	$jam 	= $jam ? date ('H:i:s',$tanggal) : '';
	
	return array('hari' => $hari,'tggl' => $tggl,'tgl' => $tgl,'bln' => $bln,'thn' => $hari,'thn' => $thn,'jam' => $jam);
}

function datetimes( $tgl, $jam = true ){
	$value = date_times( $tgl, $jam );
	return "$value[hari], $value[tggl] $value[bln] $value[thn] $value[jam]";
}

function datetimes2( $tgl, $jam = true ){
	$value = date_times( $tgl, $jam );
	return "$value[thn]-$value[bln]-$value[tgl]";
}

function my_escape( $string ){
	if( !empty( $string ) ){
		
		if (version_compare(phpversion(),"4.3.0", "<")) mysql_escape_string($string);
		else mysql_real_escape_string($string);
		
		return $string;
	}
}
	
function escape( $data ){
	if ( is_array( $data ) ) {
		foreach ( (array) $data as $k => $v ) {
			if ( is_array( $v ) )
				$data[$k] = escape( $v );
			else
				$data[$k] = my_escape( $v );
		}
	} else {
		$data = my_escape( $data );
	}

	return $data;
}
/**
 * Escapes data query MySQL
 *
 * @param string $sql
 * @return string
 */
function esc_sql( $sql ){
	
	if( !empty( $sql ) )
		return escape( $sql );
	
}

function _filter( $tag, $value, $html=true ){
	switch( $tag ){
	case'int':
		if (is_numeric ( $value )){
		$r = (int)preg_replace ( '/\D/i', '', $value);
		}
		else {
			$value = ltrim( $value, ';' );
			$value = explode ( ';', $value );
			$r = (int)preg_replace ( '/\D/i', '', $value[0] );
		}
		return $r;
	break;
	case'text':
	/*
	* array(
	* 'string'	=>'1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~`!@#$%^&*()_+,>< .?/:;"\'{[}]|\_-+=',
	* 'type'	=>''
	* );
	*/
	if( !empty( $value['string'] ) ){
		if(!empty($value['type']) && intval( $value['type'] ) == 2){
        	$r = htmlspecialchars( trim( $value['string'] ), ENT_QUOTES );
		} else {
			$r = strip_tags( urldecode( $value['string'] ) );
			$r = htmlspecialchars( trim( $r ), ENT_QUOTES );
		}
		return $r;
	}
	break;
	case'editor':
	if( !empty( $value ) ){
		$value = preg_replace( '[\']', '\'\'', $value );
		$value = preg_replace( '[\'\'/]', '\'\'', $value );
		return $value;
	}
	break;
	case'post':
	if( !empty( $value ) ){
		return htmlspecialchars(get_magic_quotes_gpc() ? $_POST[$value] : addslashes($_POST[$value]));
	}
	break;
	case'clear':
	if( !empty( $value ) ){
		return preg_replace( '/[!"\#\$%\'\(\)\?@\[\]\^`\{\}~\*\/]/', '', $value );
	}
	break;
	case'clean':
	if( !empty( $value ) ){
		$value = preg_replace( "'<script[^>]*>.*?</script>'si", '', $value );
        $value = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $value );
        $value = preg_replace( '/<!--.+?-->/', '', $value );
        $value = preg_replace( '/{.+?}/', '', $value );
        $value = preg_replace( '/&nbsp;/', ' ', $value );
        $value = preg_replace( '/&amp;/', ' ', $value );
        $value = preg_replace( '/&quot;/', ' ', $value );		
		$value = preg_replace( '[\']', '&#039;', $value );
		$value = preg_replace( '/&#039;/', '\'\'', $value );
        $value = strip_tags( $value );
        $value = preg_replace("/\r\n\r\n\r\n+/", " ", $value);
        $value = $html ? htmlspecialchars( $value ) : $value;
        return $value;
	}
	break;
	}
}

function filter_int( $value )	{ 	return _filter('int',$value);}
function filter_txt( $value )	{ 	return _filter('text',array('string'=>$value)); }

$p = (int) $_GET['p'];
$p = esc_sql( $p );
$p = filter_int( $p );

switch( $_GET['view'] ){
default:
?>
<div class="page-welcome">
<div class="page-welcome-icon">
</div>
</div>
<?php
break;
case 'detail':
$sql_query = mysql_query("SELECT * FROM "._pre_."post WHERE type='post' AND post_topic='2' AND id='$p' ORDER BY date_post DESC");
$data = mysql_fetch_object($sql_query);
?>
<div class="page-wrap">
<div class="page-head"><h1><?php echo sanitize($data->title);?></h1></div>
<div class="page-author">Posted by <?php echo sanitize($data->user_login);?> on <?php echo datetimes( $data->date_post );?></div>
<div class="page-content"><?php echo sanitize($data->content);?></div>
</div>
<?php
break;
}
?>
</div>

<div class="clear"></div>
</div>

</body>
</html>
