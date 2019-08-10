<?php 
/**
 * @fileName: data.php
 * @dir: statistik/
 */
if(!defined('_iEXEC')) exit;
global $login;

if( 'statistik/data.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

$stat = new statistik;
$op = ( $_GET['op'] ) ? $_GET['op'] : 'os';
$op = filter_txt($op);
$op = esc_sql($op);

$progress 	= $stat->progress("$op");
for($i=0;$i<$progress['totopt'];$i++){
	$persentase = round($progress['hit'][$i] / $progress['tothit'] * 100, 2);
    $result[] = array($progress['opt'][$i], $persentase );
}
print json_encode($result);

endif;
?>