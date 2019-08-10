<?php 
/**
 * @fileName: data.php
 * @dir: statistik/
 */
if(!defined('_iEXEC')) exit;
global $login, $class_country;

if( 'statistik/data.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

$stat = new statistik;

switch( $_GET['aksi'] ){
	default:

$op = ( $_GET['op'] ) ? $_GET['op'] : 'os';
$op = filter_txt($op);
$op = esc_sql($op);

$progress 	= $stat->progress("$op");

$totopt = $progress['totopt'];
if( $op == 'country' ){
	$totopt = 9;
	//$progress = array_multi_sort($progress, array('hit' => SORT_DESC));
}

$result = array();
for($i=0;$i<$totopt;$i++){
	$persentase = round($progress['hit'][$i] / $progress['tothit'] * 100, 2);
	
	$title_data = $progress['opt'][$i];
	if( $op == 'country' )
		$title_data = $class_country->country_name($title_data);
		
    $result[] = array($title_data, $persentase );
}
print json_encode($result);
	
	break;
	case 'delete':
	if( !empty($_POST['submitProcessClear']) ){
		if( $stat->reset_statistic() ){
			$response['status'] = 1;
			$response['msg'] = 'Reset data success.';
		}else{
			$response['status'] = 3;
			$response['msg'] = 'Reset data error.';
		}
		header('Content-type: application/json');	
		echo json_encode($response);
	}else{
?>
<div class="padding">
<form action="" method="post">
Hapus dan kembalikan data menjadi kosong.
<input type="hidden" name="submitProcessClear" value="1">
</form>
</div>
<?php
	}
	break;
}
endif;
?>