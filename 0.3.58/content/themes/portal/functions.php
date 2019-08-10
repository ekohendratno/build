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
		require_once( 'hightligth-slide.php' );
		require_once( 'page-front.php' );
	}
}

function datetimes( $tgl, $jam = true ){
	$value = date_times( $tgl, $jam );
	return "$value[hari], $value[tggl] $value[bln] $value[thn] $value[jam]";
}

function datetimes2( $tgl, $jam = true ){
	$value = date_times( $tgl, $jam );
	return "$value[thn]-$value[bln]-$value[tgl]";
}

function classic_soft_widgets_init() {
if (function_exists('register_sidebar'))
{
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
}}
add_action( 'widgets_init', 'classic_soft_widgets_init' );

function classic_soft_styler() {
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
		$get_body_layout == 'center';
	
	if( $get_body_layout_x == 'full' ) $get_body_layout = 'full';
		
	$GLOBALS['body_layout'] = $get_body_layout;
	/* ========================================================================================
	 */	
	
	if( $get_body_layout )
		styler_body( $get_body_layout, (object) array( 'com' => $get_query, 'view' => $get_query_view) );
		
}
add_action( 'the_head', 'classic_soft_styler' );

function styler_body( $style, $optional = false ){	
	
	if( !in_array( $style, array( 'left','right','center','sleft','sright','full') ) )
		$style = 'center';

	$sidebar = $leftwrapper = $leftwrapper_column1 = $leftwrapper_column2 = '';
	
	if( $style == 'center' || $style == 'front' ){ // null
		if( $optional->com == 'post' || $optional->com == 'page' || $optional->com == '404' ){
			$sidebar = 'width:17%;';	
			$leftwrapper = 'width:82%; float:left;';
			$leftwrapper_column2 = 'float:left;';	
			$leftwrapper_column2 = 'float:right;';		
		}
	}elseif( $style == 'full' ){
		$sidebar = 'display:none;';
		$leftwrapper = 'width:100%;';
		$leftwrapper_column1 = 'display:none;';
		$leftwrapper_column2 = 'width:100%;';
	}elseif( $style == 'left' ){
		$sidebar = 'display:none;';
		$leftwrapper = 'width:100%;';
		$leftwrapper_column1 = 'float:right;';
		$leftwrapper_column2 = 'float:left;width:82%;';
	}elseif( $style == 'right' ){
		$sidebar = 'display:none;';
		$leftwrapper = 'width:100%;';
		$leftwrapper_column2 = 'width:82%;';
	}elseif( $style == 'sleft' ){
		$sidebar = 'float:left;';
		$leftwrapper = 'float:right;';
	}
	elseif( $style == 'sright' ){
		$leftwrapper_column1 = 'float:right;';
		$leftwrapper_column2 = 'float:left;';
	}
	
	
	?>
	<style type="text/css">
		#leftwrapper{ <?php echo $leftwrapper;?> }
		#leftwrapper #column1{ <?php echo $leftwrapper_column1;?> }
		#leftwrapper #column2{ <?php echo $leftwrapper_column2;?> }
		#sidebar{ <?php echo $sidebar;?> }
	</style>
	<?php
}

function add_the_content_view( $data ){
	
if( $data->the_title )
$GLOBALS['the_title'] = $data->the_title;
if( $data->the_desc )
$GLOBALS['the_desc'] = $data->the_desc;
if( $data->the_key )
$GLOBALS['the_key'] = $data->the_key;

if( $data->view == 'page-full' ){?>
	<div id="content">
    <?php if ( !empty($data->title) ) : ?>
		<p class="browse"><?php echo $data->browse?></p>
	  	<div class="postmeta left">
	    	<h2 class="posttitle"><?php echo $data->title?></h2>
	    	<span class="by"><?php echo $data->posted?></span>
	    </div> <!--end: postmeta-->
	  	<div class="clear"></div>
	  	<div class="entry">
	    	<?php echo $data->content?>
	    	<div class="clear"></div>
	    	<div class="tags">
	      		<?php the_tags(); ?>
	    	</div> <!--end: tags-->
	  	</div> <!--end: entry-->
	  	<?php comments_template(); ?>
    <?php else : ?>
        <h2 class="pagetitle">Page Not Found</h2>
    <?php endif; ?>
	</div> <!--end: content-->
<?php }elseif( $data->view == 'page' ){?>
    <div id="content">
    <?php if ( !empty($data->title) ) : ?>
        <h2 class="pagetitle"><?php echo $data->title; ?></h2>
        <div class="entry">
            <?php echo $data->content; ?>
        </div> <!--end: entry-->
      <div class="clear"></div>
    <?php else : ?>
        <h2 class="pagetitle">Page Not Found</h2>
    <?php endif; ?>
    </div> <!--end: content-->
<?php }elseif( $data->view == 'archive' ){?>
	<div id="content">
	<?php if ( is_array($data->content) && count($data->content) > 0 ) : ?>
	<p class="browse"><?php echo $data->browse;?></p>
	<?php foreach ( $data->content as $content ) :?>
  	<div class="archive">
    	<div class="thumb left">
    		<a href="<?php echo $content[title_url]; ?>" rel="bookmark"><img src="<?php echo $content[thumb]; ?>&amp;h=100&amp;w=100&amp;zc=1" alt="" /></a>
    	</div> <!--end: thumb-->
      	<h2><a href="<?php echo $content[title_url]; ?>" rel="bookmark"><?php echo $content[title]; ?></a></h2>
      		<?php echo $content[content]; ?>
    	<div class="clear"></div>
  </div> <!--end: archive-->
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
        <h2 class="pagetitle">Page Not Found</h2>
    <?php endif; ?>
    </div> <!--end: content-->
<?php
}elseif( $data->view == '404' ){
set_query_var('com','404');
?>
	<div id="content">
        <h2 class="pagetitle">Page Not Found</h2>
	</div> <!--end: content-->
<?php
}elseif( $data->view == 'archives' ){?>
	<div id="content">
  		<h2 class="pagetitle">Archives</h2>
        <div class="entry">
            <h4>Monthly:</h4>
            <ul>
                a
            </ul>
            <h4>Subjects:</h4>
            <ul>
                a
            </ul>
            <h4>Posts:</h4>
            <ul>
                a
            </ul>
        </div> <!--end: entry-->
	</div> <!--end: content-->
<?php
}
}

function get_page_view(){
	global $db;
	
	$get_query = get_query_var('com');
	$get_query_id = get_query_var('id');
	
	$type = esc_sql( $get_query );
	$id   = esc_sql( (int) $get_query_id );
	
	if( in_array( $type, array('post','page') ) )
		$type = $type;
	
	$sql 	= $db->select( 'post', compact('type','id') );
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

function tp_popular_posts($no_posts = 5, $before = '<li>', $after = '</li>', $duration='') {
	global $db;
		
	$request = "SELECT id, title, COUNT($db->post_comment.post_id) AS comment_count FROM $db->post,$db->post_comment";
	$request.= " WHERE $db->post.id=$db->post_comment.post_id AND $db->post_comment.approved = '1'  AND $db->post.status = '1'";
	
	if( $duration !="" )
	$request.= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < $db->post.date_post ";
		
	$request.= " GROUP BY $db->post_comment.post_id ORDER BY comment_count DESC LIMIT $no_posts";	
		
	$query_request 	= $db->query($request);	
	$post_count 	= $db->num($query_request);	
		
	$output = '';
	if( $post_count > 0 ) {
		while ( $post = $db->fetch_obj($query_request) ) {
			$post_title = stripslashes($post->title);
			$comment_count = $post->comment_count;
			$permalink = do_links('post', array('view' => 'item', 'id' => $post->id, 'title' => $post->title));
			$output .= $before . '<a href="' . $permalink . '" title="' . $post_title.'">' . $post_title . '</a>' . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	echo $output;
}

function tp_recent_comments($no_comments = 5, $comment_lenth = 5, $before = '<li>', $after = '</li>', $comment_style = 1) {
	global $db;
	
	$request = "SELECT id, comment_id, comment, author, title FROM $db->post_comment LEFT JOIN $db->post ON iw_post.id=$db->post_comment.post_id WHERE $db->post.status IN ('1','0') ";		
	$request.= "AND $db->post_comment.approved = '1' ORDER BY $db->post_comment.comment_id DESC LIMIT $no_comments";

	$query_request 	= $db->query($request);
	$comments_count = $db->num($query_request);	
	
	$output = '';

	if ( $comments_count > 0 ) {
		$idx = 0;
		while ( $comment = $db->fetch_obj($query_request) ) {
			$comment_author = stripslashes($comment->author);
			if ($comment_author == "")
				$comment_author = "anonymous"; 
				
				$comment_content = strip_tags($comment->comment);
				$comment_content = stripslashes($comment_content);
				$words = split(" ", $comment_content); 
				$comment_excerpt = join(" ", array_slice($words, 0, $comment_lenth));
				
				$link = do_links('post', array('view' => 'item', 'id' => $comment->id, 'title' => $comment->title));
				$permalink = $link . "#comment-" . $comment->comment_id;
				
				if ( 1 == $comment_style ) {
					$post_title = stripslashes($comment->title);
					$post_id= stripslashes($comment->id);
					$url = '#';
					$idx++;
					if ( 1 == $idx % 2 )
						$before = "<li>";
					else
						$before = "<li>";
					$output .= $before . "<a href='$permalink'>$comment_author</a>" . ' on <a href="'.$link.'">' . $post_title . '</a>' . $after;
				} else {
					$idx++;
					if ( 1 == $idx % 2 )
						$before = "<li class=''>";
					else
						$before = "<li class=''>";
		
					$output .= $before . '<strong>' . $comment_author . ':</strong> <a href="' . $permalink;
					$output .= '" title="View the entire comment by ' . $comment_author.'">' . $comment_excerpt.'</a>' . $after;
				}
			}

			$output = convert_smilies($output);
	} else {
		$output .= $before . "None found" . $after;
	}

	echo $output;
}