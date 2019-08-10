<?php
/*
App Name: Post
App URI: http://cmsid.org/#
Description: App post
Author: Eko Azza
Version: 1.2.0
Author URI: http://cmsid.org/#
*/ 

//dilarang mengakses
if(!defined('_iEXEC')) exit;
global $db, $login;

switch( get_query_var('view') ){
default:
case'archives':
case'archive':
$date 		= filter_txt( get_query_var('id') );

if (preg_match('/\d{4}\:\d{2}/',$date) || preg_match('/\d{4}\.\d{2}/',$date)) {
	
	if( preg_match('/\d{4}\:\d{2}/', $date) )
		list($tahun, $bulan) = explode(':',$date);
	
	if( preg_match('/\d{4}\.\d{2}/', $date) )
		list($tahun, $bulan) = explode('.',$date);
	
	$bulan = filter_txt($bulan);
	$tahun = filter_int($tahun);
	
}

$data_archive 	= array();
$query_post		= $db->query("SELECT * FROM `$db->post` WHERE month(`date_post`) = '$bulan' AND year(`date_post`) = '$tahun' AND type = 'post' AND approved=1 AND status = 1 ORDER BY `date_post` DESC");

while( $data_post = $db->fetch_array($query_post) ){
	$data_archive[] = array( 
	'title' 	=> $data_post['title'], 
	'title_url'	=> do_links('post', array('view' => 'item', 'id' => $data_post['id'], 'title' => $data_post['title'])), 
	'content' 	=> limittxt( sanitize( strip_tags($data_post['content']) ),250),
	'thumb' 	=> get_template_directory_uri().'/includes/timthumb.php?src=' . content_url('uploads/post/'.$data_post['thumb'])
	);
}

$text = date_times($tahun.'-'.$bulan,false,false);
$text = sprintf('%1$s %2$d', $text['bln'], $tahun);

$data = array(
	'view' 		=> 'archive', 
	
	'the_title' => 'Archive '.$text,
	
	'content' 	=> $data_archive, 
	'browse' 	=> 'Home &raquo; Archive for '.$text
);
add_the_content_view( (object) $data );
break;
case'tag':
$tags = filter_txt( get_query_var('id') );
$tags = mysql_escape_string($tags);

if ( strlen($tags) == 3 )
	$finder = "`tags` LIKE '%$tags%'";
else
	$finder = "MATCH (tags) AGAINST ('$tags' IN BOOLEAN MODE)";


$data_archive 	= array();
$query_post		= $db->query("SELECT * FROM `$db->post` WHERE $finder AND type='post' AND approved='1' AND status='1' ORDER BY date_post DESC");

while( $data_post = $db->fetch_array($query_post) ){
	$data_archive[] = array( 
	'title' 	=> $data_post['title'], 
	'title_url'	=> do_links('post', array('view' => 'item', 'id' => $data_post['id'], 'title' => $data_post['title'])), 
	'content' 	=> limittxt( sanitize( strip_tags($data_post['content']) ),250),
	'thumb' 	=> get_template_directory_uri().'/includes/timthumb.php?src=' . content_url('uploads/post/'.$data_post['thumb'])
	);
}

$data = array(
	'view' 		=> 'archive', 
	
	'the_title' => 'Tags "'.$tags.'"',
	
	'content' 	=> $data_archive, 
	'browse' 	=> 'Home &raquo; Posts tagged with "'.$tags.'"'
);
add_the_content_view( (object) $data );
break;
case'category':

$id 			= get_posted_id('category', get_query_var('id') );
$data_archive 	= array();
$query_post		= $db->select('post', array('type' => 'post', 'post_topic' => $id, 'approved' => 1, 'status' => 1), 'ORDER BY date_post DESC');

while( $data_post = $db->fetch_obj($query_post) ){
	$data_archive[] = array( 
	'title' 	=> $data_post->title, 
	'author' 	=> $data_post->user_login, 
	'date' 		=> $data_post->date_post, 
	'title_url'	=> do_links('post', array('view' => 'item', 'id' => $data_post->id, 'title' => $data_post->title)), 
	'content' 	=> limittxt( sanitize( strip_tags($data_post->content) ),400),
	'thumb' 	=> get_template_directory_uri().'/includes/timthumb.php?src=' . content_url('uploads/post/'.$data_post->thumb)
	);
}

$query_topic	= $db->select("post_topic",array( 'id' => $id ) );
$data_topic		= $db->fetch_obj($query_topic);

$data = array(
	'view' 		=> 'archive', 
	
	'the_title' => $data_topic->topic,
	
	'content' 	=> $data_archive, 
	'browse' 	=> '<a href="'.do_links('post').'">Home</a> &raquo; <a href="'.do_links('post', array('view' => 'category', 'id' => $data_topic->id, 'title' => $data_topic->topic)).'">'.$data_topic->topic.'</a>'
);
add_the_content_view( (object) $data );
break;
case'item':
$hits   	= 0;
$id 		= get_posted_id('item', get_query_var('id') );

if( $login->user_check() && $login->login_level('admin') && !empty($id) )
$where = array('id' => $id, 'type' => 'post');
else
$where = array('id' => $id, 'type' => 'post', 'approved' => 1, 'status' => 1);

$sqlPost	= $db->select( "post", $where );
$wPost 		= $db->fetch_obj($sqlPost);
$hits		= $wPost->hits;

$db->update( "post", array('hits' => $hits+1 ), $where );

$sqlTopic 	= $db->select( 'post_topic', array('status' => 1,'id' => $wPost->post_topic) );
$wTopic 	= $db->fetch_obj($sqlTopic);

$meta_desc = empty($wPost->meta_desc) ? $wPost->content : $wPost->meta_desc;
$meta_keys = empty($wPost->meta_keys) ? $wPost->tags : $wPost->meta_keys;

$data = array(
	'view' 		=> 'page-full', 
	
	'the_title' => initialized_text( sanitize( $wPost->title ), null ),
	'the_desc' 	=> initialized_text( sanitize( $meta_desc ), 280 ),
	'the_key' 	=> initialized_text( sanitize( $meta_keys ), null, true ),
	
	'title' 	=> sanitize( $wPost->title ), 
	'content' 	=> sanitize( $wPost->content ), 
	'posted' 	=> "Posted by $wPost->user_login on ".datetimes( $wPost->date_post, false )." // ".get_comment_total($wPost->id)." comments", 
	'browse' 	=> "<a href=".do_links('post').">Home</a> &raquo; <a href=".do_links('post', array('view' => 'category', 'id' =>$wTopic->id, 'title' => $wTopic->topic)).">$wTopic->topic</a> &raquo; <a href=".do_links('post', array('view' => 'item', 'id' =>$wPost->id, 'title' => $wPost->title)).">$wPost->title</a>"
);
add_the_content_view( (object) $data );
break;
}
?>