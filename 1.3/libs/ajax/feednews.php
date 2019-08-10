<?php
$limit_form = 5;
$json = new JSON();

$news_feeds_default = array(
	'news_feeds' => array( 'cmsid.org Feed' => 'http://cmsid.org/rss.xml'),
	'display' => array('desc' => 0,'author' => 0,'date' => 0,'limit' => 10)
);
	
$news_feeds_default = $json->encode( $news_feeds_default );
$news_feeds_old_value = get_option('feed-news');
	
if( !empty($news_feeds_old_value) ) $feed_obj = $news_feeds_old_value;
else $feed_obj = $news_feeds_default;
	
$feed_obj = $json->decode( $feed_obj );
	
$news_feeds_old = $feed_obj->{'news_feeds'};
$display = $feed_obj->{'display'};

?>
<div class="padding" style="width:500px;">
<script type="text/javascript">
$(document).ready(function(){
	
var m = <?php echo $limit_form;?>;
var i = $('.dynamic_feed_form').size();
	
$("#dynamic_add").click(function() {

	if( i != m ){
		$("<div style=\"clear:both;\" class=\"dynamic_feed_form\"><input type=\"text\" class=\"dynamic_feed_title\" name=\"dynamic_feed_title[]\" style=\"width: 25%; float:left;\" placeholder=\"Judul\">&nbsp;<input type=\"text\" class=\"dynamic_feed_url\" name=\"dynamic_feed_url[]\" style=\"width: 65%; float:right;\" placeholder=\"Alamat URL\"></div>").fadeIn('slow').appendTo(".dynamic_inputs");
		i++;
	}else{
		alert("Maximal Form "+m);
	}
		
});
	
$("#dynamic_remove").click(function() {
	if(i > 1) {
		$(".dynamic_feed_form:last").remove(); 
		i--; 
	}
});
	
$("#dynamic_reset").click(function() {
	while(i > 1) { 
	$(".dynamic_feed_form:last").remove(); 
	i--; 
	}
});

});
</script>
<div style="height:35px;">
<a href="#" id="dynamic_add" class="button button2 l" style="margin-left:0;"> + </a> 
<a href="#" id="dynamic_remove" class="button button2 m"> - </a> 
<a href="#" id="dynamic_reset" class="button button2 r red" onclick="confirm('Are you sure reset field?')">Reset</a>
</div>
<div style="clear: both;"></div>
<?php
if( count($news_feeds_old) < 1 ){
?>
<div style="clear: both;" class="dynamic_feed_form"><input type="text" class="dynamic_feed_title" name="dynamic_feed_title[]" style="width: 25%; float:left;" placeholder="Judul">&nbsp;<input type="text" class="dynamic_feed_url" name="dynamic_feed_url[]" style="width: 65%; float:right;" placeholder="Alamat URL"></div>
<div class="dynamic_inputs">
</div>
<?php
}
else
{
$i = 0;
foreach( $news_feeds_old as $v => $k ){
?>
<div style="clear: both;" class="dynamic_feed_form"><input type="text" class="dynamic_feed_title" name="dynamic_feed_title[]" style="width: 25%; float:left;" placeholder="Judul" value="<?php echo $v?>">&nbsp;<input type="text" class="dynamic_feed_url" name="dynamic_feed_url[]" style="width: 65%; float:right;" placeholder="Alamat URL" value="<?php echo $k?>"></div>
<?php
$i++;
}
?>
<div class="dynamic_inputs">
</div>
<?php
}
$checked_desc = $checked_author = $checked_date = '';
if( $display->{'desc'} == 1 ) $checked_desc = 'checked="checked"';
if( $display->{'author'} == 1 ) $checked_author = 'checked="checked"';
if( $display->{'date'} == 1 ) $checked_date = 'checked="checked"';

?>
<div style="clear:both"></div><br />
<label for="feed_list">Berapa banyak yang ditampilkan</label> 
<select id="feed_list" name="display_feed_limit">
<?php 
$select_feed_limit_array = array(5,10,30,50,100);
foreach( $select_feed_limit_array as $sk => $sv ){
	$selected = '';
	if( $sv == $display->{'limit'} ) $selected = ' selected="selected"';
	echo '<option value="'.$sv.'"'.$selected.'>'.$sv.'</option>';
}
?>
</select><br>
<label for="feed_desc">Tampilkan isi berita?</label>
<input id="feed_desc" name="display_feed_desc" type="checkbox" value="1" <?php echo $checked_desc?>>
<br style="clear:both" />
<label for="feed_author">Tampilkan penulis jika ada?</label>
<input id="feed_author" name="display_feed_author" type="checkbox" value="1" <?php echo $checked_author?>>
<br style="clear:both" />
<label for="feed_date">Tampilkan tanggal?</label>
<input id="feed_date" name="display_feed_date" type="checkbox" value="1" <?php echo $checked_date?>>
</div>

<div style="clear:both"></div>
<?php 
if( isset($_POST['submitFeed']) ){
	$title_feed 	= $_POST['dynamic_feed_title']; 
	$url_feed 		= $_POST['dynamic_feed_url']; 
	
	$display_feed_limit	 	= filter_int( $_POST['display_feed_limit'] ); 
	$display_feed_desc	 	= filter_int( $_POST['display_feed_desc'] ); 
	$display_feed_author 	= filter_int( $_POST['display_feed_author'] ); 
	$display_feed_date 		= filter_int( $_POST['display_feed_date'] ); 
	
	$news_feeds_old_combine = array_combine( $title_feed, $url_feed );
	$display = array('desc' => $display_feed_desc,'author' => $display_feed_author,'date' => $display_feed_date,'limit' => $display_feed_limit);
	
	$news_feeds = array();
	foreach( $news_feeds_old_combine as $news_feeds_old_combine_k => $news_feeds_old_combine_v ){
		
		if( !empty($news_feeds_old_combine_k) && !empty($news_feeds_old_combine_v) )
			$news_feeds[$news_feeds_old_combine_k] = $news_feeds_old_combine_v;
	}
	
	$data_news_feeds = compact('news_feeds','display');
	$data_news_feeds = $json->encode( $data_news_feeds );
	
	if( !checked_option( 'feed-news' ) ) add_option( 'feed-news', $data_news_feeds );
	else set_option( 'feed-news', $data_news_feeds );
}

?>