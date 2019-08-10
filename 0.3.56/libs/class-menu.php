<?php
/**
 * @file: class-menu.php
 */
 
//dilarang mengakses
if(!defined('_iEXEC')) exit;

	function get_label($row) {
		$label =
			'<div class="ns-row">' .
				'<div class="ns-title">'.$row['title'].'</div>' .
				'<div class="ns-url">'.$row['url'].'</div>' .
				'<div class="ns-class">'.$row['class'].'</div>' .
				'<div class="ns-actions">' .
					'<a href="#" class="edit-menu" title="Edit Menu">' .
						'<img src="libs/img/edit.png" alt="Edit">' .
					'</a>' .
					'<a href="#" class="delete-menu">' .
						'<img src="libs/img/cross.png" alt="Delete">' .
					'</a>' .
					'<input type="hidden" name="menu_id" value="'.$row['id'].'">' .
				'</div>' .
			'</div>';
		return $label;
	}
	
	function get_row($id) {
		$data 	= array();
		$query 	= mysql_query("SELECT * FROM widget_menu WHERE id = '$id'");
		$data 	= mysql_fetch_assoc($query);
		return $data;
	}
	
	function get_menu_group_title($group_id) {	
		$data 	= '';
		$query 	= mysql_query("SELECT title FROM widget_menu_group WHERE id = '$group_id'");
		$data 	= mysql_fetch_array($query);		
		return $data['title'];
	}
	
	function get_menu_groups() {
		
		$data = array();
		$query 	= mysql_query("SELECT id, title FROM widget_menu_group");
		while( $row = mysql_fetch_array($query) ){
			$data[] = array( 'id' => $row['id'],'title' => $row['title'] );
		}
		
		return $data;
	}
	
	function get_last_position($group_id) {
		$data  	= '';
		$query 	= mysql_query("SELECT MAX(position) FROM widget_menu WHERE group_id = '$group_id'");
		$data 	= mysql_result($query, 0);
		return $data;
	}
	
	function get_menu($group_id) {		
		$data 	= array();
		$query 	= mysql_query("SELECT * FROM widget_menu WHERE group_id = '$group_id' ORDER BY parent_id, position");
		while ($row = mysql_fetch_assoc($query)) {
			$data[] = $row;
		}	
		return $data;
	}
	
	function get_menu_box($group_id, $id = null, $parent = null){
		$get_menu = get_menu($group_id);
		$retval = '<label for="edit-menu-select">Parent to</label><br>';
		$retval.= '<select id="edit-menu-select" name="parent">';	
		$retval.= '<option value="0">-- / --</option>';	
		foreach($get_menu as $value){
			if( $value['id'] != $id && $id != $value['parent_id'] ){
				
				$selected = '';
				if( $value['id'] == $parent ) $selected = 'selected="selected"';
				
				$retval.= '<option value="'.$value['id'].'" '.$selected.'>/'.$value['title'].'</option>';
			}
		}
		$retval.= '</select>';
		return $retval;
	}
	
	function update_position($parent, $children) {
		$i = 1;
		foreach ($children as $k => $v) {
			$id = (int)$children[$k]['id'];
			$data['parent_id'] = $parent;
			$data['position'] = $i;
			update('widget_menu', $data, 'id' . ' = ' . $id);
			if (isset($children[$k]['children'][0])) {
				update_position($id, $children[$k]['children']);
			}
			$i++;
		}
	}

	function dynamic_menus($group_id, $attr = '', $ul = true) {
		include_once libs_path . 'tree.php';
		$tree = new Tree;
		
		$menu 	= array();
		$query 	= mysql_query("SELECT * FROM widget_menu WHERE group_id = '$group_id' ORDER BY parent_id, position");
		while( $row = mysql_fetch_assoc($query)){
			$menu[] = $row;
		}
		
		foreach ($menu as $row) {

			$li_attr = '';
			if ($row['class']) {
				$li_attr = ' class="'.$row['class'].'"';
			}
			
			$label = '<a'.$li_attr.' href="'.$row['url'].'">';
			$label .= $row['title'];
			$label .= '</a>';
			
			$tree->add_row($row['id'], $row['parent_id'], $li_attr, $label);
		}
		$menu = $tree->generate_list($attr, $ul);
		return $menu;
	}
	
	
	function get_descendants($id) {
		class descendants{
			public $ids = array();			
			public function get_descendants($id) {
				$query 	= mysql_query("SELECT id FROM widget_menu WHERE parent_id = '$id'");
				while( $row = mysql_fetch_row($query)){
					$data[] = $row[0];
				}
		
				if (!empty($data)) {
					foreach ($data as $v) {
						$this->ids[] = $v;
						$this->get_descendants($v);
					}
				}
			}
		}	
		$descendants = new descendants;
		$descendants->get_descendants($id);
		
		return $descendants->ids;
	}

	function insert($table_name, $data) {
		$array_keys = array_keys( $data );
		$array_values = array_values( $data );
		return  mysql_query("INSERT INTO `$table_name` (`" . implode( '`,`', $array_keys ) . "`) VALUES ('" . implode( "','", $array_values ) . "')" );		
	}

	function update($table_name, $data, $where) {
		
		foreach ($data as $key => $value) {
			if( is_array($value) ) $value = $value[0];
			else $value = $value; 
			
			$d[] = "$key = '$value'";
		}
		
		return mysql_query( "UPDATE `$table_name` SET ".implode(', ', $d)." WHERE $where" );
	}