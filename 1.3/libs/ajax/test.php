<?php
switch($_GET['aksi']){
	case'add':
	case'edit':
	
	if (isset($_POST['title1'])) {
	$data['title1'] = trim($_POST['title1']);
	$data['title2'] = trim($_POST['title2']);
	
	if (!empty($data['title1'])) {
		if ( $data['title1'] ) {
		$response['status'] = 1;
		$response['msg'] = 'Add ok.';
		} else {
		$response['status'] = 2;
		$response['msg'] = 'Add no.';
		}
	} else {
		$response['status'] = 3;
		$response['msg'] = 'empty.';
	}
	
	header('Content-type: application/json');	
	echo json_encode($response);
	} else {
	?>   
    <div class="padding">
	<form>
		<label for="menu-group-title1">Group Title</label><br>
		<input type="text" name="title1" id="menu-group-title1"><br>
		<label for="menu-group-title2">Group Title</label><br>
		<input type="text" name="title2" id="menu-group-title2">
	</form>
    </div>
	<?php
	}
	
	break;
	case 'confirm':
	if (isset($_POST['id'])) {
		$data['id'] = trim($_POST['id']);
	
		if (!empty($data['id'])) {
			$response['status'] = 1;
			$response['msg'] = 'Delete Seccess.';
		} else {
			$response['status'] = 2;
			$response['msg'] = 'Delete Error.';
		}
		header('Content-type: application/json');
		echo json_encode($response);
	}else{
		echo 'Are you sure delete this data';
	}
	break;
	case 'show':
		echo 'show id '.$_GET['id'];
	break;
}
?>