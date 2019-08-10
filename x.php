<?php
/**
 * @file release.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $login, $api_url, $version_system, $version_project, $version_beta;

if( 'libs/ajax/latest.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') ):

$api_version = 2;

function template_major_download($data){
	$x  = '<li><div><strong>' . $data['name'].'</strong>';
	$x .= '<div style="clear:both;"></div>';
	$x .= 'Versi: ' . $data['code'];
	$x .= ', By: ' . $data['author'];
	$x .= ', <a href="' . $data['url'].'" target="_blank">Unduh</a>';
	$x .= '<div style="clear:both; padding-bottom:5px;"></div></li>';
	return $x;
}

function show_message($data){
		extract($data,EXTR_SKIP);
			
		$print = "<p style=\"line-height:20px\">";
		
		$print.= "<strong>Ada versi baru yang tersedia untuk perbaharui.</strong><br>";
		$print.= datetimes( date('Y-m-d H:i:s') )."<br><br>";
		$print.= "Tidak diharuskan melakukan pembaharuan tetapi kami merekomendasikan. ";
			
		$print.= "Versi yang di pakai adalah versi <u>".$version_system."</u>. ";
		$print.= " untuk diperbaharui ke versi <u>".$release_version."</u> ";
		
		$print.= "</p>";
		
		return $print;
}

switch( $_GET[action] ){
default:

$server = "/?api=$api_version&content=release";
$server = get_content( esc_sql( $api_url . $server ) );
$data 	= json_decode( $server, TRUE );

if( count($data[content]) > 0 ):
	$xy = $data[content];
	
	$show = $show_beta = $show_stable = false;	
	if( $version_system == 'beta' //cek system versi beta 
	&& $xy[version][release][name] == 'beta' //cek api versi beta
	&& $xy[version][release][code] > $version_beta  //bandingkan versi beta
	&& $xy[version][code] > $version_system //bandingkan versi system dg api 
	){ 
		$show = $show_beta = true;
		$show_stable = false;
	}elseif( $version_system == 'stable'
	&& $xy[version][release][name] == 'stable' 
	&& $xy[version][code] > $version_system ){
		$show = $show_stable = true;
		$show_beta = false;
	}elseif( $version_system == 'beta'
	&& $xy[version][release][name] == 'stable'
	&& $xy[version][code] >= $version_system ){
		$show = $show_stable = true;
		$show_beta = false;
	}elseif( $version_system == 'stable'
	&& $xy[version][release][name] == 'beta'
	&& $xy[version][code] > $version_system ){
		$show = $show_beta = true;
		$show_stable = false;
	}
	
	echo $show.'/'.$show_stable.'/'.$show_beta;
	
	if( $show ){

		$print = "<p class=\"message\">";
		$print.= "<strong>Penting : </strong>sebelum ujicoba/upgrade, silahkan <a href=\"?admin&sys=backup\">backup database dan file</a> terlebih dahulu";
		$print.= "</p>";

		$print.= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
  		$print.= '<tr>';
   		$print.= '<td width="10%" valign="top" style="vertical-align:top"><img src="libs/img/icon-download-upgrade.png" style="margin-top:2px;"></td>';
    	$print.= '<td width="60%" valign="top">';	
		$print.= show_message( array(
			'version_system' => $version_system,
			'version_project' => $version_project, 
			'version_beta' => $version_beta, 
			'release_version' => $xy[version][code], 
			'release_name' => $xy[version][release][name], 
			'release_beta' => $xy[version][release][code], 
			'release_package' => $xy[package], 
			'release_date' => $xy[date]
			) );		
		$print.= "</td>";
  		$print.= "</tr>";
		$print.= "</table>";
		echo $print;
	}
endif;

break;
case 'action':
$type = esc_sql( filter_txt( $_GET['type'] ) );
$key_id = esc_sql( filter_txt( $_GET['key_id'] ) );

$add_key_id = '';
if( $key_id ) $add_key_id = "&key_id=$key_id";
		
$server = "/?api=$api_version&content=release&action=etc&type=$type$add_key_id";
$server = get_content( esc_sql( $api_url . $server ) );
$data 	= json_decode( $server, TRUE );

$li = '';
$show = $show_li = true;

if( count($data[content]) > 0 ):

$check_applications = get_dir_applications();
$check_plugins = get_dir_plugins();
$check_themes = get_dir_themes();

$data = array_multi_sort($data[content], array('date' => SORT_DESC));
foreach( $data as $xy){	
	$data_check = template_major_download( array(
					'name' 		=> $xy['version']['name'],
					'code' 		=> $xy['version']['code'],
					'author' 	=> $xy['author'],
					'url' 		=> $xy['url']
					));
	
	if( $type == 'app' ){
		foreach($check_applications as $key => $val){
			if($xy['version']['api_key'] ==  $val['APIKey']
			&& $xy['version']['code'] > $val['Version'] ){
				$li .= $data_check;
			}
		}
	}elseif( $type == 'plugin' ){
		foreach($check_plugins as $key => $val){
			if($xy['version']['api_key'] ==  $val['APIKey']
			&& $xy['version']['code'] > $val['Version'] ){
				$li .= $data_check;
			}
		}
	}elseif( $type == 'themes' ){
		foreach($check_themes as $key => $val){
			if($xy['version']['api_key'] ==  $val['apiKey']
			&& $xy['version']['code'] > $val['version'] ){
				$li .= $data_check;
			}
		}
	}
}

$ul = '<ul class="sidemenu">';
$ul.= $li . '</ul>';

endif;
		
if( $show && empty($li) ) $ul = '<div class="padding"><p id="message_no_ani">Update not found</p></div>';

echo $ul;

break;
}
endif;