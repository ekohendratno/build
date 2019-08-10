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

$date 		= filter_txt( get_query_var('id') );
$date 		= esc_sql($date);

if( get_option('rewrite') != 'advance' ) 
	$date = str_replace('-',':',$date);

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

if (preg_match('/\d{4}\:\d{2}/',$date) || preg_match('/\d{4}\.\d{2}/',$date)) {
	
	if( preg_match('/\d{4}\:\d{2}/', $date) )
		list($tahun, $bulan) = explode(':',$date);
	
	if( preg_match('/\d{4}\.\d{2}/', $date) )
		list($tahun, $bulan) = explode('.',$date);
	
	$bulan 	= filter_txt($bulan);
	$tahun 	= filter_int($tahun);
	
	$bulan  = esc_sql($bulan);
	$tahun 	= esc_sql($tahun);
	
}

$data_archive 	= array();
$query_post		= $db->query("SELECT * FROM `$db->post` WHERE month(`date_post`) = '$bulan' AND year(`date_post`) = '$tahun' AND type = 'post' AND approved=1 AND status = 1 ORDER BY `date_post` DESC LIMIT $ps,$bt");
$total_post 	= $db->num_query("SELECT * FROM `$db->post` WHERE month(`date_post`) = '$bulan' AND year(`date_post`) = '$tahun' AND type = 'post' AND approved=1 AND status = 1");


while( $data_post = $db->fetch_array($query_post) ){
	$data_archive[] = array( 
	'title' 	=> $data_post['title'], 
	'title_url'	=> do_links('postdetail', array('id' => $data_post['id'], 'title' => $data_post['title'])), 
	'content' 	=> limittxt( sanitize( strip_tags($data_post['content']) ),250),
	'thumb' 	=> $data_post['thumb']
	);
}

$text = date_times($tahun.'-'.$bulan,false,false);
$text = sprintf('%1$s %2$d', $text['bln'], $tahun);

if( get_option('rewrite') != 'advance' ) 
	$id = str_replace(':','-',$date);
				
$url = do_links( 'archive', array('id'=>$id, 'pg' => "%page%") ); 
$GLOBALS['the_title'] = 'Archive '.$text;
?>
<div id="content">
	<?php if ( count($data_archive) > 0 ) : ?>
	<p class="browse"><?php echo '<a href="'.site_url().'">Home</a> &raquo; Archive for '.$text;?></p>
	<?php foreach ( $data_archive as $content ) :?>
  	<div class="archive">
    	<?php $thumb = get_template_directory_uri().'/images/no-preview.png'; if( !empty($content[thumb]) ): $thumb = content_url('/uploads/post/'.$content[thumb]); endif;?>
    	<div class="thumb left">
    		<a href="<?php echo $content[title_url]; ?>" rel="bookmark"><img src="<?php //echo site_url().'/?request&load=libs/timthumb.php&src=' . $thumb; ?>&amp;h=100&amp;w=100&amp;zc=1" alt="" style="width:100px; height:100px;" /></a>
    	</div> <!--end: thumb-->
      	<h2><a href="<?php echo $content[title_url]; ?>" rel="bookmark"><?php echo $content[title]; ?></a></h2>
      		<?php echo $content[content]; ?>
    	<div class="clear"></div>
  </div> <!--end: archive-->
  <?php endforeach; ?>
  	<div class="clear"></div>
    <?php if( count($data_archive) > 0 ):?>
  	<div class="pagenavi">  
    <?php 
	$paging = new Pagination();
	$paging->set('urlscheme',$url);
	$paging->set('perpage',$bt);
	$paging->set('page',$pg);
	$paging->set('total',$total_post);
	$paging->set('nexttext','Next');
	$paging->set('prevtext','Previous');
	$paging->set('focusedclass','selected');
	$paging->display();
	?>        
    <div class="clear"></div>
	</div> <!--end: pagenavi-->
    <?php endif;?>
	<?php else : ?>
        <h2 class="pagetitle">Page Archive Is Empty</h2>
    <?php endif; ?>
</div> <!--end: content-->