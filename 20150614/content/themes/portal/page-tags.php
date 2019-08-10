<?php
/*
App Name: Post
App URI: http://cmsid.org/#
Description: App post
Author: Eko Azza
Version: 2.2.2
API Key: G1sSE7bqtXDxXxT8ssiy
Author URI: http://cmsid.org/#
*/ 

//dilarang mengakses
if(!defined('_iEXEC')) exit;
global $db, $login;

$tags = filter_txt( get_query_var('id') );
$tags = esc_sql($tags);
$tags = str_replace('-',' ',$tags);  

$finder = "`tags` LIKE '%$tags%'";
	
$bt = 10;
$pg = (int) get_query_var('pg');
if(empty($pg)){
	$ps = 0;
	$pg = 1;
}
else{
	$ps = ($pg-1) * $bt;
}

$ps = filter_int( $ps );


$data_archive 	= array();
$query_post		= $db->query("SELECT * FROM `$db->post` WHERE $finder AND type='post' AND approved='1' AND status='1' ORDER BY date_post DESC LIMIT $ps,$bt");
$total_post 	= $db->num_query("SELECT * FROM `$db->post` WHERE $finder AND type='post' AND approved='1' AND status='1'");

while( $data_post = $db->fetch_array($query_post) ){
	$data_archive[] = array( 
	'title' 	=> $data_post['title'], 
	'title_url'	=> do_links('postdetail', array('id' => $data_post['id'])), 
	'content' 	=> limittxt( sanitize( strip_tags($data_post['content']) ),250),
	'thumb' 	=> $data_post['thumb']
	);
}

$url = do_links( 'tags', array('id'=>$tags, 'pg' => "%page%") ); 
$data = (object) array(
	'the_title' => 'Tags "'.$tags.'"',	
	'content' 	=> $data_archive, 
	'paging'	=> array(
		'urlscheme' => $url,
		'perpage' 	=> $bt,
		'page' 		=> $pg,
		'total' 	=> $total_post
	), 
	'browse' 	=> '<a href="'.site_url().'">Home</a> &raquo; Posts tagged with "'.$tags.'"'
);
				
$GLOBALS['the_title'] = $data->the_title;
?>

	<div id="content">
	<?php if ( count($data->content) > 0 ) : ?>
	<p class="browse"><?php echo $data->browse;?></p>
	<?php foreach ( $data->content as $content ) :?>
  	<div class="archive">
    	<?php $thumb = get_template_directory_uri().'/images/no-preview.png'; if( !empty($content[thumb]) ): $thumb = content_url('/uploads/post/'.$content[thumb]); endif;?>
    	<div class="thumb left">
    		<a href="<?php echo $content[title_url]; ?>" rel="bookmark"><img src="<?php // site_url().'/?request&load=libs/timthumb.php&src=' . $thumb; ?>&amp;h=100&amp;w=100&amp;zc=1" alt="" style="width:100px; height:100px;" /></a>
    	</div> <!--end: thumb-->
      	<h2><a href="<?php echo $content[title_url]; ?>" rel="bookmark"><?php echo $content[title]; ?></a></h2>
      		<?php echo $content[content]; ?>
    	<div class="clear"></div>
  </div> <!--end: archive-->
  <?php endforeach; ?>
  	<div class="clear"></div>
    <?php if( count($data->paging) > 0 ):?>
  	<div class="pagenavi">  
    <?php 
	$paging = new Pagination();
	$paging->set('urlscheme',$data->paging[urlscheme]);
	$paging->set('perpage',$data->paging[perpage]);
	$paging->set('page',$data->paging[page]);
	$paging->set('total',$data->paging[total]);
	$paging->set('nexttext','Next');
	$paging->set('prevtext','Previous');
	$paging->set('focusedclass','selected');
	$paging->display();
	?>        
    <div class="clear"></div>
	</div> <!--end: pagenavi-->
    <?php endif;?>
	<?php else : ?>
        <h2 class="pagetitle">Page Not Found</h2>
    <?php endif; ?>
    </div> <!--end: content-->