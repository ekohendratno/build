<?php 
/**
 * @fileName: functions.php
 * @dir: content/themes/
 */
if(!defined('_iEXEC')) exit;

function theme_option( $param = null, $args = '' ){	
	/*** 
	* function: theme_option(...)
	*
	* Dapat digunakan untuk opsi themes
	*/
	$defaults = array(
		'logo' => get_template_directory_uri() .'/images/logo.png',
		'logo_w' => 185,
		'logo_h' => 40,
		'artist' => 1,
		'ads468x60' => get_template_directory_uri() .'/images/ads/ads468x60.jpg',
		'ads160x600' => get_template_directory_uri() .'/images/ads/ads160x600.jpg',	
		'ads300x250' => get_template_directory_uri() .'/images/ads/ads300x250.jpg',	
		'tabber' => 0,	
		'limit_post' => 10,	
		'front' => 'slide',
		'topnews' => 0
	);
	
	
	if( checked_option( 'portal_options' ) && empty($args) ){
		$args = get_option('portal_options');
		$args = (array) json_decode( $args );
	}
	
	$r = parse_args( $args, $defaults );
	
	if( $param )
		return $r[$param];
	else
		return $r;
}

function home_contents(){	
	if( !the_contents() ):
		if(theme_option('front') == 'slide' 
		|| theme_option('front') == 'topic' )
			require_once( 'hightligth-slide.php' );
		
		if(theme_option('front') == 'topic' )
			require_once( 'front-topic.php' );
		else
			require_once( 'front.php' );		
		
	endif;
}
add_action( 'home_init', 'home_contents' );

function theme_widgets_init() {
	/*** 
	* function: theme_widgets_init()
	*
	* Dapat digunakan untuk menginisialisasi widget dari themes
	*/
	//echo "function: theme_widgets_init()<br>";
	//echo "exec: add_action('widgets_init','theme_widgets_init');<br>";
	if (function_exists('register_sidebar')){
		
	  register_sidebar(array(
		  'name'			=> 'Home/Page Left',
		  'before_widget'	=> '',
		  'after_widget'	=> '</div>',
		  'before_title'	=> '<h3>',
		  'after_title'	=> '</h3><div class="clear"></div><div class="box">',
	  ));		
	  
	  register_sidebar(array(
		  'name'			=> 'Home Right #Full Width',
		  'before_widget'	=> '',
		  'after_widget'	=> '</div>',
		  'before_title'	=> '<h3>',
		  'after_title'	=> '</h3><div class="clear"></div><div class="box">',
	  ));		
	  
	  register_sidebar(array(
		  'name'			=> 'Home Right #Left',
		  'before_widget'	=> '',
		  'after_widget'	=> '</div>',
		  'before_title'	=> '<h3>',
		  'after_title'	=> '</h3><div class="clear"></div><div class="box">',
	  ));	
	  
	  register_sidebar(array(
		  'name'			=> 'Home Right #Right',
		  'before_widget'	=> '',
		  'after_widget'	=> '</div>',
		  'before_title'	=> '<h3>',
		  'after_title'	=> '</h3><div class="clear"></div><div class="box">',
	  ));		
		  
	  register_sidebar(array(
		  'name'			=> 'Page Right',
		  'before_widget'	=> '',
		  'after_widget'	=> '</div>',
		  'before_title'	=> '<h3>',
		  'after_title'	=> '</h3><div class="clear"></div><div class="box">',
	  ));	
	  
	  register_sidebar(array(
		  'name'			=> 'Footer',
		  'before_widget'	=> '',
		  'after_widget'	=> '</div>',
		  'before_title'	=> '<div class="footerwidget left"><h3>',
		  'after_title'	=> '</h3>',
	  ));	
  	}
}
add_action( 'widgets_init', 'theme_widgets_init' );

function action_style(){
	/*** 
	* function: action_style()
	*
	* Dapat digunakan untuk melihat aksi dari themes
	* (sidebar1, sidebar2, content) size and posision
	*/	
	//echo "function: view_action()<br>";
	//echo "exec: add_action('the_head','view_action');<br>";
	
	/*get_sidebar_action(...)
	* get_sidebar_action('sidebar-1') is sidebar left
	* get_sidebar_action('sidebar-2') is sidebar right
	*/
	
	?>    
    <style type="text/css">
	<?php
	if( $p = get_query_var("p") ){
		if( in_array($p,array('postdetail','page','archive','category')) ){
		?>
			#leftwrapper{width:82%; float:left;}
			#leftwrapper #column1{float:left;}
			#leftwrapper #column2{float:right;width: 598px;}
			#sidebar{width:17%;}
		<?php
		}elseif( $p ){
			if( get_sidebar_action('sidebar-1') == true && get_sidebar_action('sidebar-2') == true ){
				//echo "s:1:true,2:true"; 
				//same with 
				//echo "s:else";
			?>
				#leftwrapper{width: 650px;float:left;}
				#leftwrapper #column1{float:left;}
				#leftwrapper #column2{float: right;width: 480px;}
				#leftwrapper #content{width: 460px;}
				#sidebar{width: 300px; float:right;}
			<?php
			}elseif( get_sidebar_action('sidebar-1') == true && get_sidebar_action('sidebar-2') == false ){
				//echo "s:1:true,2:false";
			?>
				#leftwrapper{width:100%;}
				#leftwrapper #column1{float:left;}
				#leftwrapper #column2{float:right;width:82%;}
				#sidebar{display:none;}
			<?php
			}elseif( get_sidebar_action('sidebar-1') == false && get_sidebar_action('sidebar-2') == true ){
				//echo "s:1:false,2:true";
			?>
				#leftwrapper{width: 650px;float:left;}
				#leftwrapper #column1{display:none;}
				#leftwrapper #column2{float: left;width: 650px;}
				#sidebar{width: 300px; float:right;}
			<?php
			}elseif( get_sidebar_action('sidebar-1') == false && get_sidebar_action('sidebar-2') == false ){
				//echo "s:1:false,2:false";
			?>
				#leftwrapper{width:100%;}
				#leftwrapper #column1{display:none;}
				#leftwrapper #column2{width:100%;}
				#sidebar{display:none;}
			<?php
			}
		}
	}else{
		//echo "s:else"; -> home
		?>
		#leftwrapper{width: 650px;float:left;}
		#leftwrapper #column1{float:left;}
		#leftwrapper #column2{float: right;width: 480px;}
		#leftwrapper #content{width: 460px;}
		#sidebar{width: 300px; float:right;}
		<?php
	}
	?>
	</style>
    <?php
}
add_action('the_head','action_style');

function get_comment_total( $id ){
	global $db;
	
	$id = filter_int( $id );
		
	$qry_comment			= $db->select("post_comment",array('post_id'=>$id,'approved'=>1,'comment_parent'=>0)); 
	$num1					= $db->num($qry_comment);
	$num2					= 0;
	while ($data			= $db->fetch_array($qry_comment)) {
		$no_comment 		= filter_int( $data['comment_id'] );
						
		$qry_comment2		= $db->select("post_comment",array('approved'=>1,'comment_parent'=>$no_comment)); 
		$num2				= $num2+$db->num($qry_comment2);
	}
	return $num1+$num2;	
		
}