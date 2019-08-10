<?php 
/**
 * @fileName: class-widgets.php
 * @dir: libs/
 */
if(!defined('_iEXEC')) exit;

class Widget_Factory {
	var $widgets = array();

	function Widget_Factory() {
		add_action( 'widgets_init', array( &$this, '_register_widgets' ), 100 );
	}

	function register($widget_class) {
		$this->widgets[$widget_class] = new $widget_class();
	}

	function unregister($widget_class) {
		if ( isset($this->widgets[$widget_class]) )
			unset($this->widgets[$widget_class]);
	}

	function _register_widgets() {
		global $registered_widgets;
		
		$keys = array_keys($this->widgets);
		$registered = array_keys($registered_widgets);
		$registered = array_map('_get_widget_id_base', $registered);
		
		foreach ( $keys as $key ) {
			if ( in_array($this->widgets[$key]->id_base, $registered, true) ) {
				unset($this->widgets[$key]);
				continue;
			}

			$this->widgets[$key]->_register();
		}
	}
}

class Widgets {

	var $id_base;
	var $name;
	var $widget_options;
	var $control_options;

	var $number = false;
	var $id = false;
	var $updated = false;
	
	function widget($args, $instance) {
		die('function Widgets::widget() must be over-ridden in a sub-class.');
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		return 'noform';
	}

	function Widgets( $id_base = false, $name, $widget_options = array(), $control_options = array() ) {
		Widgets::__construct( $id_base, $name, $widget_options, $control_options );
	}

	function __construct( $id_base = false, $name, $widget_options = array(), $control_options = array() ) {
		$this->id_base = empty($id_base) ? preg_replace( '/()?widget_/', '', strtolower(get_class($this)) ) : strtolower($id_base);
		$this->name = $name;
		$this->option_name = 'widget_' . $this->id_base;
		$this->widget_options = parse_args( $widget_options, array('classname' => $this->option_name) );
		$this->control_options = parse_args( $control_options, array('id_base' => $this->id_base) );
	}

	function get_field_name($field_name) {
		return 'widget-' . $this->id_base . '[' . $this->number . '][' . $field_name . ']';
	}

	function get_field_id($field_name) {
		return 'widget-' . $this->id_base . '-' . $this->number . '-' . $field_name;
	}
	
	function _register() {
		$settings = $this->get_settings();
		$empty = true;

		if ( is_array($settings) ) {
			foreach ( array_keys($settings) as $number ) {
				if ( is_numeric($number) ) {
					$this->_set($number);
					$this->_register_one($number);
					$empty = false;
				}
			}
		}

		if ( $empty ) {
			$this->_set(1);
			$this->_register_one();
		}
	}

	function _set($number) {
		$this->number = $number;
		$this->id = $this->id_base . '-' . $number;
	}

	function _get_display_callback() {
		return array(&$this, 'display_callback');
	}
	
	function _get_form_callback() {
		return array(&$this, 'form_callback');
	}

	function display_callback( $args, $widget_args = 1 ) {
		if ( is_numeric($widget_args) )
			$widget_args = array( 'number' => $widget_args );

		$widget_args = parse_args( $widget_args, array( 'number' => -1 ) );
		$this->_set( $widget_args['number'] );
		$instance = $this->get_settings();

		if ( array_key_exists( $this->number, $instance ) ) {
			$instance = $instance[$this->number];
			$instance = apply_filters('widget_display_callback', $instance, $this, $args);
			if ( false !== $instance )
				$this->widget($args, $instance);
		}
	}

	function form_callback( $widget_args = 1 ) {
		if ( is_numeric($widget_args) )
			$widget_args = array( 'number' => $widget_args );

		$widget_args = parse_args( $widget_args, array( 'number' => -1 ) );
		$all_instances = $this->get_settings();

		if ( -1 == $widget_args['number'] ) {
			// We echo out a form where 'number' can be set later
			$this->_set('__i__');
			$instance = array();
		} else {
			$this->_set($widget_args['number']);
			$instance = $all_instances[ $widget_args['number'] ];
		}

		//$instance = apply_filters('widget_form_callback', $instance, $this);

		$return = null;
		if ( false !== $instance ) {
			$return = $this->form($instance);
			//do_action_ref_array( 'in_widget_form', array(&$this, &$return, $instance) );
		}
		return $return;
	}

	function _register_one($number = -1) {
		register_sidebar_widget( $this->id, $this->name, $this->_get_display_callback(), $this->widget_options, array( 'number' => $number ) );
		_register_widget_form_callback(	$this->id, $this->name,	$this->_get_form_callback(), $this->control_options, array( 'number' => $number ) );
	}

	function save_settings($settings) {
		$settings['_multiwidget'] = 1;
		update_option( $this->option_name, $settings );
	}

	function get_settings() {
		//$settings = get_option($this->option_name);
		$settings = get_option_array_widget_item();

		//if ( false === $settings && isset($this->alt_option_name) )
			//$settings = get_option($this->alt_option_name);
		if ( false === $settings && isset($this->alt_option_name) )
		$settings = get_option_array_widget_item();

		if ( !is_array($settings) )
			$settings = array();

		if ( !empty($settings) && !array_key_exists('_multiwidget', $settings) ) {
			// old format, convert if single widget
			$settings = convert_widget_settings($this->id_base, $this->option_name, $settings);
		}

		unset($settings['_multiwidget'], $settings['__i__']);
		return $settings;
	}
}

function list_widgets() {
	global $registered_widgets, $sidebars_widgets, $registered_widget_controls;

	$sort = $registered_widgets;
	usort( $sort, '_sort_name_callback' );
	$done = array();

	foreach ( $sort as $widget ) {
		if ( in_array( $widget['callback'], $done, true ) ) // We already showed this multi-widget
			continue;

		$sidebar = is_active_widget( $widget['callback'], $widget['id'], false, false );
		$done[] = $widget['callback'];

		if ( ! isset( $widget['params'][0] ) )
			$widget['params'][0] = array();
			
		$args = array( 'widget_id' => $widget['id'], 'widget_name' => $widget['name'], '_display' => 'template' );

		if ( isset($registered_widget_controls[$widget['id']]['id_base']) && isset($widget['params'][0]['number']) ) {
			$id_base = $registered_widget_controls[$widget['id']]['id_base'];
			$args['_temp_id'] = "$id_base-__i__";
			$args['_multi_num'] = next_widget_id_number($id_base);
			$args['_add'] = 'multi';
		} else {
			$args['_add'] = 'single';
			if ( $sidebar )
				$args['_hide'] = '1';
		}

		$args = list_widget_controls_dynamic_sidebar( array( 0 => $args, 1 => $widget['params'][0] ) );
		call_user_func_array( 'widget_control', $args );
	}
}

function is_active_widget($callback = false, $widget_id = false, $id_base = false, $skip_inactive = true) {
	global $registered_widgets;

	$sidebars_widgets = get_sidebars_widgets();

	if ( is_array($sidebars_widgets) ) {
		foreach ( $sidebars_widgets as $sidebar => $widgets ) {
			if ( $skip_inactive && 'inactive_widgets' == $sidebar )
				continue;

			if ( is_array($widgets) ) {
				foreach ( $widgets as $widget ) {
					if ( ( $callback && isset($registered_widgets[$widget]['callback']) && $registered_widgets[$widget]['callback'] == $callback ) || ( $id_base && _get_widget_id_base($widget) == $id_base ) ) {
						if ( !$widget_id || $widget_id == $registered_widgets[$widget]['id'] )
							return $sidebar;
					}
				}
			}
		}
	}
	return false;
}


function register_widget($widget_class) {
	$widget_factory = new Widget_Factory();
	
	$widget_factory->register($widget_class);
}


function list_widget_controls( $sidebar ) {
	add_filter( 'dynamic_sidebar_params', 'list_widget_controls_dynamic_sidebar' );

	echo "<div id='$sidebar' class='widgets-sortables'>\n";

	$description = sidebar_description( $sidebar );

	if ( !empty( $description ) ) {
		echo "<div class='sidebar-description'>\n";
		echo "\t<p class='description'>$description</p>";
		echo "</div>\n";
	}

	dynamic_sidebar( $sidebar );
	echo "</div>\n";
}

function list_widget_controls_dynamic_sidebar( $params ) {
	global $registered_widgets;
	static $i = 0;
	$i++;

	$widget_id = $params[0]['widget_id'];
	$id = isset($params[0]['_temp_id']) ? $params[0]['_temp_id'] : $widget_id;
	$hidden = isset($params[0]['_hide']) ? ' style="display:none;"' : '';

	$params[0]['before_widget'] = "<div id='widget-{$i}_{$id}' class='widget'$hidden>";
	$params[0]['after_widget'] = "</div>";
	$params[0]['before_title'] = "%BEG_OF_TITLE%"; // deprecated
	$params[0]['after_title'] = "%END_OF_TITLE%"; // deprecated
	if ( is_callable( $registered_widgets[$widget_id]['callback'] ) ) {
		$registered_widgets[$widget_id]['_callback'] = $registered_widgets[$widget_id]['callback'];
		$registered_widgets[$widget_id]['callback'] = 'widget_control';
	}

	return $params;
}

function widget_control( $sidebar_args ) {
	global $registered_widgets, $registered_widget_controls, $sidebars_widgets;

	$widget_id = $sidebar_args['widget_id'];
	$sidebar_id = isset($sidebar_args['id']) ? $sidebar_args['id'] : false;
	$key = $sidebar_id ? array_search( $widget_id, $sidebars_widgets[$sidebar_id] ) : '-1'; // position of widget in sidebar
	$control = isset($registered_widget_controls[$widget_id]) ? $registered_widget_controls[$widget_id] : array();
	$widget = $registered_widgets[$widget_id];

	$id_format = $widget['id'];
	$widget_number = isset($control['params'][0]['number']) ? $control['params'][0]['number'] : '';
	$id_base = isset($control['id_base']) ? $control['id_base'] : $widget_id;
	$multi_number = isset($sidebar_args['_multi_num']) ? $sidebar_args['_multi_num'] : '';
	$add_new = isset($sidebar_args['_add']) ? $sidebar_args['_add'] : '';

	$query_arg = array( 'editwidget' => $widget['id'] );
	if ( $add_new ) {
		$query_arg['addnew'] = 1;
		if ( $multi_number ) {
			$query_arg['num'] = $multi_number;
			$query_arg['base'] = $id_base;
		}
	} else {
		$query_arg['sidebar'] = $sidebar_id;
		$query_arg['key'] = $key;
	}

	// We aren't showing a widget control, we're outputting a template for a multi-widget control
	if ( isset($sidebar_args['_display']) && 'template' == $sidebar_args['_display'] && $widget_number ) {
		// number == -1 implies a template where id numbers are replaced by a generic '__i__'
		$control['params'][0]['number'] = -1;
		// with id_base widget id's are constructed like {$id_base}-{$id_number}
		if ( isset($control['id_base']) )
			$id_format = $control['id_base'] . '-__i__';
	}

	$registered_widgets[$widget_id]['callback'] = $registered_widgets[$widget_id]['_callback'];
	unset($registered_widgets[$widget_id]['_callback']);

	$widget_title = strip_tags( $sidebar_args['widget_name'] );
	$has_form = 'noform';

	echo $sidebar_args['before_widget']; ?>
	<div class="widget-top">
	<div class="widget-title-action">
		<a class="widget-action" href="javascript:void(0);"></a>
	</div>
	<div class="widget-title">
    	<h4><?php echo $widget_title ?><span class="in-widget-title"></span></h4>
    </div>
	</div>

	<div class="widget-inside">
	<form action="" method="post">
	<div class="widget-content">
<?php
	if ( isset($control['callback']) )
		$has_form = call_user_func_array( $control['callback'], $control['params'] );
	else
		echo "\t\t<p>There are no options for this widget.</p>\n"; ?>
	</div>
	<input type="hidden" name="widget-id" class="widget-id" value="<?php echo $id_format; ?>" />
	<input type="hidden" name="id_base" class="id_base" value="<?php echo $id_base; ?>" />
	<input type="hidden" name="multi_number" class="multi_number" value="<?php echo $multi_number; ?>" />
	<input type="hidden" name="add_new" class="add_new" value="<?php echo $add_new; ?>" />

	<div class="widget-control-actions">
		<div class="alignleft">
		<a class="widget-control-remove button3" href="#remove">Delete</a> | 
		<a class="widget-control-close button3" href="#close">Close</a>
		</div>
		<div class="alignright<?php if ( 'noform' === $has_form ) echo ' widget-control-noform'; ?>">
			<?php submit_button( 'Save', 'button-primary widget-control-save button button3 blue', 'savewidget', false, array( 'id' => 'widget-' . $id_format . '-savewidget' ) ); ?>
			<span class="spinner"></span>
		</div>
		<br style="clear:both;"/>
	</div>
	</form>
	</div>
<?php
	echo $sidebar_args['after_widget'];
	return $sidebar_args;
}


function sidebar_description( $id ) {
	if ( !is_scalar($id) )
		return;

	global $registered_sidebars;

	if ( isset($registered_sidebars[$id]['description']) )
		return $registered_sidebars[$id]['description'];
}

function dynamic_sidebar($index = 1) {
	global $registered_sidebars, $registered_widgets;

	if ( is_int($index) ) {
		$index = "sidebar-$index";
	} else {
		$index = sanitize_title($index);
		foreach ( (array) $registered_sidebars as $key => $value ) {
			if ( sanitize_title($value['name']) == $index ) {
				$index = $key;
				break;
			}
		}
	}

	$data_sidebars_widgets = get_sidebars_widgets();
	
	if ( empty( $data_sidebars_widgets ) )
		return false;

	if ( empty($registered_sidebars[$index]) || !array_key_exists($index, $data_sidebars_widgets) || !is_array($data_sidebars_widgets[$index]) || empty($data_sidebars_widgets[$index]) )
		return false;

	$sidebar = $registered_sidebars[$index];

	$did_one = false;
	foreach ( (array) $data_sidebars_widgets[$index] as $id ) {

		if ( !isset($registered_widgets[$id]) ) continue;

		$params = array_merge(
			array( array_merge( $sidebar, array('widget_id' => $id, 'widget_name' => $registered_widgets[$id]['name']) ) ),
			(array) $registered_widgets[$id]['params']
		);

		// Substitute HTML id and class attributes into before_widget
		$classname_ = '';
		foreach ( (array) $registered_widgets[$id]['classname'] as $cn ) {
			if ( is_string($cn) )
				$classname_ .= '_' . $cn;
			elseif ( is_object($cn) )
				$classname_ .= '_' . get_class($cn);
		}
		$classname_ = ltrim($classname_, '_');
		$params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);

		$params = apply_filters( 'dynamic_sidebar_params', $params );

		$callback = $registered_widgets[$id]['callback'];

		do_action( 'dynamic_sidebar', $registered_widgets[$id] );

		if ( is_callable($callback) ) {
			call_user_func_array($callback, $params);
			$did_one = true;
		}
	}

	return $did_one;
}

function get_sidebars_widgets($deprecated = true) {
	//if ( $deprecated !== true )
		//_deprecated_argument( __FUNCTION__, '2.8.1' );

	global $registered_widgets, $_sidebars_widgets, $sidebars_widgets;

	// If loading from front page, consult $_sidebars_widgets rather than options
	// to see if convert_widget_settings() has made manipulations in memory.
	if ( !$_GET['admin'] ) {
		if ( empty($_sidebars_widgets) )
			$_sidebars_widgets = get_option_array_widget();

		$sidebars_widgets = $_sidebars_widgets;
	} else {
		$sidebars_widgets = get_option_array_widget();
	}

	if ( is_array( $sidebars_widgets ) && isset($sidebars_widgets['array_version']) )
		unset($sidebars_widgets['array_version']);
		

	$sidebars_widgets = apply_filters('sidebars_widgets', $sidebars_widgets);
	return $sidebars_widgets;
}

// register theme

function register_sidebar($args = array()) {
	global $registered_sidebars;

	$i = count($registered_sidebars) + 1;

	$defaults = array(
		'name' => sprintf('Sidebar %d', $i ),
		'id' => "sidebar-$i",
		'description' => '',
		'class' => '',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => "</li>\n",
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => "</h2>\n",
	);

	$sidebar = parse_args( $args, $defaults );

	$registered_sidebars[$sidebar['id']] = $sidebar;

	//add_theme_support('widgets');

	do_action( 'register_sidebar', $sidebar );

	return $sidebar['id'];
}

function register_sidebar_widget($id, $name, $output_callback, $options = array()) {
	global $registered_widgets, $registered_widget_controls, $_deprecated_widgets_callbacks;

	$id = strtolower($id);

	if ( empty($output_callback) ) {
		unset($registered_widgets[$id]);
		return;
	}

	$id_base = _get_widget_id_base($id);
	if ( in_array($output_callback, $_deprecated_widgets_callbacks, true) && !is_callable($output_callback) ) {
		if ( isset($registered_widget_controls[$id]) )
			unset($registered_widget_controls[$id]);

		return;
	}

	$defaults = array('classname' => $output_callback);
	$options = parse_args($options, $defaults);
	$widget = array(
		'name' => $name,
		'id' => $id,
		'callback' => $output_callback,
		'params' => array_slice(func_get_args(), 4)
	);
	$widget = array_merge($widget, $options);

	if ( is_callable($output_callback) && ( !isset($registered_widgets[$id]) || did_action( 'widgets_init' ) ) ) {
		do_action( 'register_sidebar_widget', $widget );
		$registered_widgets[$id] = $widget;
	}
}

function _register_widget_form_callback($id, $name, $form_callback, $options = array()) {
	global $registered_widget_controls;

	$id = strtolower($id);

	if ( empty($form_callback) ) {
		unset($registered_widget_controls[$id]);
		return;
	}

	if ( isset($registered_widget_controls[$id]) && !did_action( 'widgets_init' ) )
		return;

	$defaults = array('width' => 250, 'height' => 200 );
	$options = parse_args($options, $defaults);
	$options['width'] = (int) $options['width'];
	$options['height'] = (int) $options['height'];

	$widget = array(
		'name' => $name,
		'id' => $id,
		'callback' => $form_callback,
		'params' => array_slice(func_get_args(), 4)
	);
	$widget = array_merge($widget, $options);

	$registered_widget_controls[$id] = $widget;
}

function next_widget_id_number($id_base) {
	global $registered_widgets;
	$number = 1;

	foreach ( $registered_widgets as $widget_id => $widget ) {
		if ( preg_match( '/' . $id_base . '-([0-9]+)$/', $widget_id, $matches ) )
			$number = max($number, $matches[1]);
	}
	$number++;

	return $number;
}