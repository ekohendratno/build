<?php
/**
 * @file menu.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $login, $db;

if( 'libs/ajax/menu.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') ):

$_GET['aksi'] = !isset($_GET['aksi']) ? null : $_GET['aksi'];

switch($_GET['aksi']){
	default:
	case'add':
if (isset($_POST['title'])) {
	$data['title'] = esc_sql( trim($_POST['title']) );

	if (!empty($data['title'])) {
	$data['url'] = esc_sql( $_POST['url'] );
	$data['class'] = esc_sql( $_POST['class'] );
	$group_id = esc_sql( $_POST['group_id'] );
	$parent_id = esc_sql( $_POST['parent'] );
	$data['parent_id'] = $parent_id;
	$data['group_id'] = $group_id;
	$data['position'] = dynamic_menus_last_position($group_id, $parent_id) + 1;
	
	$querymax	= $db->query ("SELECT MAX(`position`) FROM `$db->menu` WHERE group_id = '$group_id' AND parent_id = '$parent_id'");
	$alhasil 	= $db->fetch_array($querymax);	
	$numbers	= $alhasil[0];

	if ( $db->insert('menu', $data) ) {
		$data['id'] = mysql_insert_id();
		$response['status'] = 1;
		$li_id = 'menu-'.$data['id'];
		$response['li'] = '<li id="'.$li_id.'" class="sortable_easymn">'.dynamic_menus_label($data, $numbers).'</li>';
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
	
$id = esc_sql( (int)$_GET['id'] );
$data = dynamic_menus_row($id);

?>
    <div class="padding">
<form method="post" action="?request&load=libs/ajax/menu.php&aksi=save">
<table border="0" cellspacing="2" style="width:400px;">
  <tr>
    <td width="18%">Title</td>
    <td width="3%"><strong>:</strong></td>
    <td width="79%"><input type="text" name="title" id="edit-menu-title" value="<?php echo $data['title']; ?>" style="width:95%"></td>
  </tr>
  <tr>
    <td>URL</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="url" id="edit-menu-url" value="<?php echo $data['url']; ?>" style="width:95%"></td>
  </tr>
  <tr>
    <td>Class</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="class" id="edit-menu-class" value="<?php echo $data['class']; ?>" style="width:95%"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo dynamic_menus_box($data['group_id'], $id, $data['parent_id']);?><input type="hidden" name="menu_id" value="<?php echo $data['id']; ?>"></td>
  </tr>
</table>
</form>
</div>
<?php
		}
	break;
	case'save':
		if (isset($_POST['title'])) {
			$data['title'] = esc_sql( trim($_POST['title']) );
			if (!empty($data['title'])) {
				$data['id'] = esc_sql( $_POST['menu_id'] );
				$data['url'] = esc_sql( $_POST['url'] );
				$data['class'] = esc_sql( $_POST['class'] );
				$data['parent_id'] = esc_sql( $_POST['parent'] );
				if ( $db->update('menu', $data, array('id' => $data['id']) )) {
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
			$id = esc_sql( trim($_POST['id']) );

			$ids = dynamic_menus_descendants($id);
			if (!empty($ids)) {
				$ids = implode(', ', $ids);
				$id = "$id, $ids";
			}

			$delete = $db->delete( 'menu', array('id' => $id));
			if ($delete) {
				$response['status'] = 1;
			} else {
				$response['status'] = 3;
			}
			header('Content-type: application/json');
			echo json_encode($response);
		}
	break;
	case'save_position':
		if (isset($_POST['dragbox_easymn'])) {
			$dragbox_easymn = $_POST['dragbox_easymn'];
			dynamic_menus_update_position(0, $dragbox_easymn);
		}
	break;
	
}

endif;