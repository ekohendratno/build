<?php
$_GET['aksi'] = !isset($_GET['aksi']) ? null : $_GET['aksi'];

switch($_GET['aksi']){
	default:
	case'add':
if (isset($_POST['title'])) {
$data['title'] = trim($_POST['title']);

	if (!empty($data['title'])) {
	$data['url'] = $_POST['url'];
	$data['class'] = $_POST['class'];
	$data['group_id'] = $_POST['group_id'];
	$data['position'] = get_last_position($_POST['group_id']) + 1;
	if ( insert('widget_menu', $data) ) {
		$data['id'] = mysql_insert_id();
		$response['status'] = 1;
		$li_id = 'menu-'.$data['id'];
		$response['li'] = '<li id="'.$li_id.'" class="sortable">'.get_label($data).'</li>';
		$response['li_id'] = $li_id;
	} else {
		$response['status'] = 2;
		$response['msg'] = 'Add menu error.';
	}
} else {
	$response['status'] = 3;
}

header('Content-type: application/json');
echo json_encode($response);

}
	break;
	case'edit':
	
if (isset($_GET['id'])) {
	
$id = (int)$_GET['id'];
$data = get_row($id);

?>
<h2>Edit Menu</h2>
    <div class="padding">
<form method="post" action="?request&load=libs/ajax/menu.php&aksi=save">
		<label for="edit-menu-title">Title</label>
		<input type="text" name="title" id="edit-menu-title" value="<?php echo $data['title']; ?>">
		<label for="edit-menu-url">URL</label>
		<input type="text" name="url" id="edit-menu-url" value="<?php echo $data['url']; ?>">
		<label for="edit-menu-class">Class</label>
		<input type="text" name="class" id="edit-menu-class" value="<?php echo $data['class']; ?>">
        <?php echo get_menu_box($data['group_id'], $id, $data['parent_id']);?>
	<input type="hidden" name="menu_id" value="<?php echo $data['id']; ?>">
</form>
</div>
<?php
		}
	break;
	case'save':
		if (isset($_POST['title'])) {
			$data['title'] = trim($_POST['title']);
			if (!empty($data['title'])) {
				$data['id'] = $_POST['menu_id'];
				$data['url'] = $_POST['url'];
				$data['class'] = $_POST['class'];
				$data['parent_id'] = $_POST['parent'];
				if ( update('widget_menu', $data, 'id' . ' = ' . $data['id'])) {
					$response['status'] = 1;
					$d['title'] = $data['title'];
					$d['url'] = $data['url'];
					$d['klass'] = $data['class']; //klass instead of class because of an error in js
					$response['menu'] = $d;
				} else {
					$response['status'] = 2;
					$response['msg'] = 'Edit menu error.';
				}
			} else {
				$response['status'] = 3;
			}
			header('Content-type: application/json');
			echo json_encode($response);
		}
	break;
	case'delete':
		if (isset($_POST['id'])) {
			$id = (int)$_POST['id'];

			$ids = get_descendants($id);
			if (!empty($ids)) {
				$ids = implode(', ', $ids);
				$id = "$id, $ids";
			}

			$sql = sprintf('DELETE FROM %s WHERE %s IN (%s)', 'widget_menu', 'id', $id);
			$delete = mysql_query($sql);
			if ($delete) {
				$response['success'] = true;
			} else {
				$response['success'] = false;
			}
			header('Content-type: application/json');
			echo json_encode($response);
		}
	break;
	case'save_position':
		if (isset($_POST['dragbox_easymn'])) {
			$dragbox_easymn = $_POST['dragbox_easymn'];
			update_position(0, $dragbox_easymn);
		}
	break;
	
}