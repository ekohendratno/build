<?php 
/**
 * @fileName: data.php
 * @dir: shoutbox/
 */
if(!defined('_iEXEC')) exit;
global $db, $login;

if( 'shoutbox/data.php' == is_load_values() ):

switch( $_GET['aksi'] ){
	default:

$o = filter_txt($_GET['option']);
if( $o == 'post' ){

$data = array(
	'nama' 	=> filter_post('nama'),
	'email' => filter_post('email'),
	'pesan' => filter_post('pesan'),
	'waktu'	=> date('Y-m-d H:i:s') 
);

$security_posted = false;

if( security_posted('shoutbox', true) < 1 || $login->level('admin') ){ $security_posted = true; }
	
if( $security_posted ){
if ( !empty($data['nama']) && !empty($data['email']) && !empty($data['pesan']) ):

	$query_shoutbox	= $db->insert("shoutbox", $data );	
	if( $query_shoutbox && $user->user_level != 'admin' ) 
		security_posted('shoutbox');
		
endif;
}
	
}elseif( $o == 'get' ){


if( checked_option( 'shoutbox_echo_limit' )  ) $shoutbox_echo_limit = get_option('shoutbox_echo_limit');
else $shoutbox_echo_limit = 50; //limit default

$q = $db->select('shoutbox', null, "ORDER BY id DESC LIMIT $shoutbox_echo_limit");
if( $db->num($q) < 1 ){
	echo'<center>No data</center>';
}else{
	echo'<table style="width:100%">';
	$warna	= '';
	
	while($r = $db->fetch_array($q)){
		
	$warna 	= empty ($warna) ? ' bgcolor="#f1f6fe"' : '';
	$pesan	= shoutbox_filter( $r['pesan'] );
	echo'<tr '.$warna.'><td><a href="mailto:'.$r['email'].'">'.substr($r['nama'],0,15).'</a> : '.$pesan.'</td></tr>';
	echo'<tr '.$warna.'><td><span style="font-color:gray;font-size:10px">'.date_stamp($r['waktu']).'</span></td></tr>';	
	
	}
	echo'</table>';
}

}

	break;
	case 'widget':
if( $login->check() && $login->level('admin') ){
?>

<script type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
	
$(".tab_shoutbox_records").hide();
$(".tab_shoutbox_records:first").show();
$("ul.shoutbox_records li:first").addClass("active").show();
$("ul.shoutbox_records li").click(function() {
	$("ul.shoutbox_records li").removeClass("active");
	$(this).addClass("active");
	$(".tab_shoutbox_records").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).slideDown('slow');
	return false;
});

});
/* ]]> */
</script>
<div style="clear:both"></div>
<ul class="shoutbox_records">
	<li class="active"><a href="#shoutbox-all">Semua</a></li>
	<li><a href="#shoutbox-now">Sekarang</a></li>
</ul>
<div style="clear:both"></div>
<div class="tabs-content">
	<div id="shoutbox-all" class="tab_shoutbox_records" style="display: block; ">
	<?php echo shoutbox_message( null, 'widget' );?>
	</div>
	<div id="shoutbox-now" class="tab_shoutbox_records" style="display: none; ">
	<?php echo shoutbox_message( 'today', 'widget' );?>
	</div>
</div>
<div style="clear:both"></div>
<?php
}
	break;
	case 'edit':


if( checked_option( 'shoutbox_echo_limit' )  ) $shoutbox_echo_limit = get_option('shoutbox_echo_limit');
else $shoutbox_echo_limit = 50; //limit default

if( isset($_POST['txtShow']) ){
	$shoutbox_echo_limit = filter_int( $_POST['txtShow'] );
	if( checked_option( 'shoutbox_echo_limit' ) ){
		set_option( 'shoutbox_echo_limit', $shoutbox_echo_limit );
		$response['status'] = 1;
		$response['msg'] = 'Edit success.';
	}else{
		add_option( 'shoutbox_echo_limit', $shoutbox_echo_limit );
		$response['status'] = 1;
		$response['msg'] = 'Add success.';
	}
	header('Content-type: application/json');	
	echo json_encode($response);
}else{
?>
<script>
/* <![CDATA[ */
$(document).ready(function(){
	$('button#submitProcessClear').click(function() {
		$.ajax({ 
			type: 'POST', 
			url: BASE_URL + '/?request&plg=yes&load=shoutbox/data.php&aksi=delete', 
			data: 'submitProcessClear=1', 
			success: function(data) {}
		});
	});
});
</script>

<div class="padding">
<form method="post" action="">
<label for="txtShow">Limit Show :</label>
<input id="txtShow" name="txtShow" type="text" style="width:50px" value="<?php echo $shoutbox_echo_limit;?>" /> or <button class="red" id="submitProcessClear" name="submitProcessClear">Hapus semua jajak aktivitas</button>
</form>
</div>
<?php
}
	break;
	case 'delete':
	if( $_GET['item'] == 1 ){
		$id = filter_int( $_POST['id'] );
		if( $db->delete('shoutbox', array('id' => $id) ) ){
			$response['status'] = 1;
			$response['msg'] = 'delete data success.';
		}else{
			$response['status'] = 3;
			$response['msg'] = 'delete data error.';
		}
	}else{	
		if( isset($_POST['submitProcessClear']) ){
			$db->truncate('shoutbox');
			$response['status'] = 1;
			$response['msg'] = 'Clear data success.';
		}else{
			$response['status'] = 3;
			$response['msg'] = 'Clear data error.';
		}
	}
	header('Content-type: application/json');	
	echo json_encode($response);
	break;
}
endif;