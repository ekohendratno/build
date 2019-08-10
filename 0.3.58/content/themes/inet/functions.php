<?php 
/**
 * @fileName: functions.php
 * @dir: content/themes/
 */
if(!defined('_iEXEC')) exit;

function the_sidebar_active( $param ){
	return layout( $param );
}

function the_content_view(){
	
	if( $get_query = get_query_var('com') ){
		if( $get_query == 'page' )
			require_once( 'page.php' );
		else
		{
			if( $file_application = get_application_chek( $get_query ) ){ 
				if( file_exists( application_path .  $get_query . '/functions.php' ) )
				require_once(application_path . $get_query . '/functions.php');
				
				include_once( $file_application );
			}
			else 
			{
				add_the_content_view( (object) array('view' => '404') );
			}
		}
	}else{
		require_once( 'page-front.php' );
	}
}

function inet_widgets_init() {
if (function_exists('register_sidebar'))
{
	register_sidebar(array(
		'name'			=> 'Home/Page Left',
	    'before_widget'	=> '',
	    'after_widget'	=> '</div>',
	    'before_title'	=> '<h1 class="bg">',
	    'after_title'	=> '</h1><div class="box">',
	));		
	
    register_sidebar(array(
		'name'			=> 'Home Right #Full Width',
        'before_widget'	=> '',
        'after_widget'	=> '</div>',
        'before_title'	=> '<h1 class="bg">',
        'after_title'	=> '</h1><div class="box">',
    ));		
}}
add_action( 'widgets_init', 'inet_widgets_init' );

function datetimes( $tgl, $jam = true ){
	$value = date_times( $tgl, $jam );
	return "$value[hari], $value[tggl] $value[bln] $value[thn] $value[jam]";
}

function datetimes2( $tgl, $jam = true ){
	$value = date_times( $tgl, $jam );
	return "$value[thn]-$value[bln]-$value[tgl]";
}

function inet_styler() {
	$get_body_layout_x = get_option('body_layout');
	$get_body_layout_global = esc_sql( $GLOBALS['body_layout'] );
	
	if( $get_body_layout_global )
		$get_body_layout_x = $get_body_layout_global; 
	
	/*
	 * DISABLE AUTO LOAD STYLE
	 *
	/*
	 * standar load style : 'full','left','right','center','sleft','sright','front' 
	 * but this template style : 'sleft','sright','full' only
	 */
	if( !in_array( $get_body_layout_x, array( 'left','right','center','sleft','sright','full') ) )
		$get_body_layout_x = '';
	
	$get_query = get_query_var('com');
	$get_query_view = get_query_var('view');
	/* ========================================================================================
	 * MAKE MANUAL STYLE
	 * ========================================================================================
	 */
	$get_body_layout = 'center';
	if( $get_query == 'post' && $get_query == 'page' ) 
		$get_body_layout == 'left';
	
	if( $get_body_layout_x == 'full' ) $get_body_layout = 'full';
		
	$GLOBALS['body_layout'] = $get_body_layout;
	/* ========================================================================================
	 */	
	
	if( $get_body_layout )
		styler_body( $get_body_layout, (object) array( 'com' => $get_query, 'view' => $get_query_view) );
		
}
add_action( 'the_head', 'inet_styler' );

function styler_body( $style, $optional = false ){	
	
	if( !in_array( $style, array( 'left','right','center','sleft','sright','full') ) )
		$style = 'center';

	$sidebar = $main = $rightbar = '';
	
	if( $style == 'center' || $style == 'front' ){ // null
		if( $optional->com == 'post' || $optional->com == 'page' || $optional->com == '404' ){
			$sidebar = 'width:20%;float:left;';	
			$main = 'width:59%; float:left;';
			$rightbar = 'width:24%;float:right;';		
		}
	}elseif( $style == 'left' ){
		$sidebar = 'float:left;';
		$main = 'width:45%;float:left;';
		$rightbar = 'width:22%;float:left;';
	}
	
	if( !empty($sidebar) || !empty($main) || !empty($rightbar) ):
	?>
	<style type="text/css">
	<?php if( $sidebar ):?>
		#sidebar{ <?php echo $sidebar;?> }
	<?php endif;?>
	<?php if( $main ):?>
		#main{ <?php echo $main;?> }
	<?php endif;?>
	<?php if( $rightbar ):?>
		#rightbar{ <?php echo $rightbar;?> }
	<?php endif;?>
	</style>
	<?php
	endif;
}

function add_the_content_view( $data ){
	
if( $data->the_title )
$GLOBALS['the_title'] = $data->the_title;
if( $data->the_desc )
$GLOBALS['the_desc'] = $data->the_desc;
if( $data->the_key )
$GLOBALS['the_key'] = $data->the_key;

if( $data->view == 'page-full' ){?>
    <?php if ( !empty($data->title) ) : ?>
		<div class="bg"><?php echo $data->browse?></div>
	  	<h4 class="bg"><?php echo $data->title?></h4>
        <div class="border"><?php echo $data->posted?></div>
	  	<div class="border">
	    	<?php echo $data->content?>
	    	<div class="tags">
	      		<?php the_tags(); ?>
	    	</div> <!--end: tags-->
	  	</div>
	  	<?php comments_template(); ?>
    <?php else : ?>
        <h4 class="bg">Page Not Found</h4>
    <?php endif; ?>
<?php }elseif( $data->view == 'page' ){?>
    <?php if ( !empty($data->title) ) : ?>
	<h4 class="bg"><?php echo $data->title; ?></h4>
	<div class="border">
    	<?php echo $data->content; ?>
      <div class="clear"></div>
	</div>
    <?php else : ?>
        <h4 class="bg">Page Not Found</h4>
    <?php endif; ?>
<?php }elseif( $data->view == 'archive' ){?>
	<?php if ( is_array($data->content) && count($data->content) > 0 ) : ?>
	<div class="bg"><?php echo $data->browse;?></div>
	<?php foreach ( $data->content as $content ) :?>
  	<h4 class="bg"><?php echo $content[title]; ?></h4>
    <div class="news">
	<div class="thumb">
    <a href="#" rel="bookmark" class="img-url">
    <img src="<?php echo $content[thumb]; ?>&h=100&w=100&zc=1" alt="">
    </a>
    </div>
	<?php echo $content[content]; ?>
    <div style="clear:both"></div>
    </div>		
                
    <p class="post-footer">					
    <a href="<?php echo $content[title_url]; ?>" title="<?php echo $content[title]; ?>" class="readmore">Read more</a>
    <span class="comments">By <a href="<?php echo $content[title_url]; ?>#<?php echo $content[author]; ?>"><?php echo $content[author]; ?></a></span>
    <span class="date"><?php echo datetimes2( $content[date] ); ?></span>	
    </p>
  <?php endforeach; ?>
  	<div class="clear"></div>
  	<div class="pagenavi">
  		<div class="nextprev left">
    		&laquo; Previous Page
    	</div>
    	<div class="nextprev right">
      		Next Page &raquo;
    	</div>
    <div class="clear"></div>
	</div> <!--end: pagenavi-->
	<?php else : ?>
        <h4 class="bg">Page Not Found</h4>
    <?php endif; ?>
<?php
}elseif( $data->view == '404' ){
set_query_var('com','404');
?>
	<h4 class="bg">Page Not Found</h4>
<?php
}elseif( $data->view == 'archives' ){?>
<?php
}
}

function get_page_view(){
	global $db, $login;
	
	$get_query = get_query_var('com');
	$get_query_id = get_query_var('id');
	
	$type = esc_sql( $get_query );
	$id   = esc_sql( (int) $get_query_id );
		
	if( $login->user_check() && $login->login_level('admin') && !empty($id) )
	$where = array('id' => $id, 'type' => 'page');
	else
	$where = array('type' => 'page', 'id' => $id, 'approved' => 1, 'status' => 1);
	
	$sql 	= $db->select( 'post', $where );
	$post 	= $db->fetch_obj( $sql );
	return $post;
}

function get_posted_id( $act, $id ){
	global $db;
		
	$engine =  new engine;		
	$set_rewrite = get_option('rewrite');
		
	if( $set_rewrite == 'clear-slash' || $set_rewrite == 'clear-strip' ):
		$selftitle = filter_clear( $id );
		
	if( $act == 'page' || $act == 'item' )
		$q = $db->select( "post", array('type'=>'page', 'status'=>1) );
	elseif( $act == 'category' )
		$q = $db->select( "post_topic" );
	endif;
	
	
	while($data = $db->fetch_array($q)){
		if( $act == 'page' || $act == 'item' ) 
			$get_sefttitle = $data['sefttitle'];
		elseif( $act == 'category' )
			$get_sefttitle = $engine->judul( $data['topic'] );
		
		if($get_sefttitle == $selftitle){
			$id = (int) esc_sql( $data['id'] );
		}
	}
	
	return $id;
}

function get_comment_total( $id ){
	global $db;
		
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
