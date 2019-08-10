<?php
/**
 * @file tags.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

echo '<div style="text-align:center">';

$where = array('type'=>'post','status'=>1);
		
$qry 	= $db->select('post',$where);
$jum 	= $db->num($qry);

if($jum <1 ) echo 'tidak ada tags';
else{
	
		$TampungData = array();
		while ($data_tags = $db->fetch_array($qry)) {
			$tags = explode(',',strtolower(trim($data_tags['tags'])));
			foreach($tags as $val) {
				$TampungData[] = $val;						
			}
		}
	
		$totalTags = count($TampungData);
		$jumlah_tag = array_count_values($TampungData);
		ksort($jumlah_tag);
		if ($totalTags > 0) {
		$output = array();
		$tag_mod = array();
		$tag_mod['fontsize']['max'] = 20;
		$tag_mod['fontsize']['min'] = 9;
	
		$min_count = min($jumlah_tag);
		$spread = max($jumlah_tag) - $min_count;
		
		if ( $spread <= 0 )
			$spread = 1;
			
		$font_spread = $tag_mod['fontsize']['max'] - $tag_mod['fontsize']['min'];
		if ( $font_spread <= 0 )
			$font_spread = 1;
			
		$font_step = $font_spread / $spread;
		
		foreach($jumlah_tag as $key=>$val) {
			$font_size = ( $tag_mod['fontsize']['min'] + ( ( $val - $min_count ) * $font_step ) );
			$datas = array('view'=>'tags','id'=>urlencode($key));
			$output[] = "<a href='".do_links("post",$datas)."' style='font-size:".$font_size."px'>".$key ."</a>";
		}
		}
}
		
echo implode(', ',$output);

echo '</div>';
