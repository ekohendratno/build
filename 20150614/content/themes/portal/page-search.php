<?php 
global $db;
$s = esc_sql( filter_txt(get_query_var('s')) );

$query = $db->query("SELECT * FROM $db->post WHERE ((title LIKE '%$s%' OR content LIKE '%$s%') AND status=1 AND approved=1 AND type='post') ORDER BY hits DESC LIMIT 10");

$GLOBALS['the_title'] = "Search for \"$s\"";
?>
    <div id="content">
        <p class="browse"><a href="'.site_url().'">Home</a> &raquo; Search for "<?php echo $s;?>"</p>
        <div class="entry">
<?php
while( $data = $db->fetch_obj($query) ){
	$search_title = ereg_replace($s,"<span style='background:#fcfcae'>$s</span>",strtolower(substr(strip_tags($data->title),0,80)));
	$search_content = ereg_replace($s,"<span style='background:#fcfcae'>$s</span>",strtolower(substr(strip_tags($data->content),0,180)));
	
	echo '<div class="search-frame" style="margin-bottom:10px;"><a href="'.do_links('postdetail', array('id' => $data->id, 'title' => $data->title)).'" style="color:#2e5c01"><b>'.$search_title.'</b></a><div style="clear:both"></div>'.$search_content.'<br></div>';
}

?>
        </div> <!--end: entry-->
      <div class="clear"></div>
    </div> <!--end: content-->