<?php 
/**
 * @fileName: default-widgets.php
 * @dir: libs/
 */
if(!defined('_iEXEC')) exit;

/**
 * Meta widget class
 *
 * Displays log in/out, RSS feed links, etc.
 *
 * @since 2.8.0
 */
class Widget_Meta extends Widgets {

	function __construct() {
		$widget_ops = array('classname' => 'widget_meta', 'description' => "Log in/out, admin, feed and CMS links" );
		parent::__construct('meta', 'Meta', $widget_ops);
	}

	function widget( $args ) {
	global $login;
		extract($args);
		$title = 'Meta';

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
?>
			<ul>
			<?php if( $login->user_check() && $login->login_level('admin') ):?>
				<li><a href="<?php echo site_url('?admin')?>">Administrator</a></li>
			<?php endif;if( $login->user_check() ):?>
				<li><a href="<?php echo site_url('?login&go=logout')?>">Logout</a></li>
			<?php else:?>
				<li><a href="<?php echo site_url('?login')?>">Login</a></li>
			<?php endif;?>
			<li><a href="#" title="">RSS</a></li>
			</ul>
<?php
		echo $after_widget;
	}
}

/**
 * Default Widgets
 *
 * @package CMS
 * @subpackage Widgets
 */

/**
 * Pages widget class
 *
 * @since 2.8.0
 */
class Widget_Pages extends Widgets {

	function __construct() {
		$widget_ops = array('classname' => 'widget_pages', 'description' => 'Your site&#8217;s Pages' );
		parent::__construct('pages', 'Pages', $widget_ops);
	}

	function widget( $args ) {
		extract( $args );

		$title = 'Pages';
		$sortby = 'menu_order';
		$exclude = '';

		if ( $sortby == 'menu_order' )
			$sortby = 'menu_order, post_title';

		$out = list_pages( apply_filters('widget_pages_args', array('title_li' => '', 'echo' => 0, 'sort_column' => $sortby, 'exclude' => $exclude) ) );

		if ( !empty( $out ) ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
		?>
		<ul>
			<?php echo $out; ?>
		</ul>
		<?php
			echo $after_widget;
		}
	}

}

class Widget_Archives extends Widgets {

	function __construct() {
		$widget_ops = array('classname' => 'widget_archive', 'description' => 'A monthly archive of your site&#8217;s posts' );
		parent::__construct('archives', 'Archives', $widget_ops);
	}

	function widget( $args ) {
		extract($args);
		$title = 'Archives';

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $d ) {
		echo 'box:select>Widget_Archives<br>';
		} else {
		echo 'box:ul>Widget_Archives<br>';
		}

		echo $after_widget;
	}
}


class Widget_Categories extends Widgets {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_categories', 'description' => "A list or dropdown of categories" );
		parent::__construct('categories', 'Categories', $widget_ops);
	}

	function widget( $args ) {
		extract($args);
		$title = 'Categories';

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $d ) {
		echo 'box:select>Widget_Categories<br>';
		} else {
		echo 'box:ul>Widget_Categories<br>';
		}

		echo $after_widget;
	}

}


function widgets_init() {

	register_widget('Widget_Meta');
	
	register_widget('Widget_Pages');
	
	register_widget('Widget_Archives');
	
	register_widget('Widget_Categories');

	do_action('widgets_init');
}

add_action('init', 'widgets_init', 1);

