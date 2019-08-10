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

$hits   	= 0;
$id 		= get_posted_id('item', get_query_var('id') );
$id 		= filter_int( $id );
$id 		= esc_sql($id);

if( $login->check() && $login->level('admin') && !empty($id) )
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

$GLOBALS['the_title'] = initialized_text( sanitize( $wPost->title ), null );
$GLOBALS['the_desc'] = initialized_text( sanitize( $meta_desc ), 280 );
$GLOBALS['the_key'] = initialized_text( sanitize( $meta_keys ), null, true );

?>
<div id="content">
    <?php if ( !empty($wPost->title) ) : ?>
		<p class="browse"><a href="<?php echo site_url();?>">Home</a> &raquo; <a href="<?php echo do_links('category', array('id' =>$wTopic->id, 'title' => $wTopic->topic));?>"><?php echo "$wTopic->topic";?></a> &raquo; <a href="<?php echo do_links('postdetail', array('id' =>$wPost->id, 'title' => $wPost->title));?>"><?php echo "$wPost->title";?></a></p>
	  	<div class="postmeta left">
	    	<h2 class="posttitle"><?php echo sanitize( $wPost->title )?></h2>
	    	<span class="by">Posted by <?php echo $wPost->user_login." on ".datetimes( $wPost->date_post, false )." // ".get_comment_total($wPost->id).""?> comments</span>
	    </div> <!--end: postmeta-->
	  	<div class="clear"></div>
	  	<div class="entry">
	    	<?php echo sanitize( $wPost->content )?>
	    	<div class="clear"></div>
	    	<div class="tags">
	      		<?php the_tags(); ?>
	    	</div> <!--end: tags-->
	  	</div> <!--end: entry-->
	  	<?php comments_template(); ?>
    <?php else : ?>
        <h2 class="pagetitle">Page Article Not Found</h2>
    <?php endif; ?>
</div> <!--end: content-->