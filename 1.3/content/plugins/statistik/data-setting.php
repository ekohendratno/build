<div class="padding">
Hapus dan kembalikan data menjadi kosong.
<?php 
if( isset($_POST['submitResetStatistik']) ){
	$stat->reset_statistic();
	redirect('?admin');	
}
?>
</div>