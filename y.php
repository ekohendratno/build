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
		
		if( $show_content )
		message_attention();
			
		$print = "<p style=\"line-height:20px\">";
		
		if($show_content_stable){
		
		if( $show_beta ){
			
		$print.= "<strong>Ada versi baru yang tersedia untuk di ujicoba.</strong><br>";
		$print.= datetimes( date('Y-m-d H:i:s') )."<br><br>";
		$print.= "Tidak diharuskan melakukan pembaharuan tetapi kami merekomendasikan mencoba versi beta. ";
		$print.= "Versi system dipakai adalah versi <u>stable ".$system_stable."</u>. ";	
		
		if( $server_version_beta )		
		$print.= "untuk ujicoba silahkan coba versi <u>beta ".$server_version_beta."</u> ";		
		$print.= "<br>";
		}else{
			
		$print.= "<strong>Ada versi baru yang tersedia untuk perbaharui.</strong><br>";
		$print.= datetimes( date('Y-m-d H:i:s') )."<br><br>";
		$print.= "Tidak diharuskan melakukan pembaharuan tetapi kami merekomendasikan. ";
		
		$print.= "Versi yang di pakai adalah versi <u>stable ".$system_stable."</u>. ";
		$print.= " untuk diperbaharui ke versi <u>stable ".$server_version_stable."</u> "; 
		
		if( $server_version_beta )
		$print.= " atau bisa mencoba versi <u>beta ".$server_version_beta."</u>";
		
		$print.= "<br>";
		
		$print.= "<a target=\"_blank\" href=\"/latest.zip\" class=\"button\" style=\"margin-top:10px\">Unduh Full Stable ".$server_version_stable."</a> ";
		}
		
		if( $show_package == 1 )
		$print.= "<a target=\"_blank\" href=\"/latest-pack.zip\" class=\"button\" style=\"margin-top:10px\">Unduh Pack Stable ".$server_version_stable."</a> ";
		
		if( $server_version_beta )
		$print.= "<a target=\"_blank\" href=\"/latest-beta.zip\" class=\"button\" style=\"margin-top:10px\">Unduh & Coba Beta ".$server_version_beta."</a> ";
		
		
		}
		elseif($show_content_beta){			
		
		if( $show_stable ){
			
		}elseif( $show_beta ){
			
		$print.= "<strong>Ada versi baru yang tersedia untuk diperbaharui.</strong><br>";
		$print.= datetimes( date('Y-m-d H:i:s') )."<br><br>";
		$print.= "Tidak diharuskan melakukan pembaharuan tetapi kami merekomendasikan.<br>";
		
		$print.= "Versi yang dipakai adalah versi <u>beta ".$system_beta."</u>. ";
		
		if( $server_version_stable )
		$print.= "Untuk diperbaharui ke versi <u>stable ".$server_version_stable."</u>";
		
		if( $server_version_beta )
		$print.= " atau bisa mencoba versi <u>beta ".$server_version_beta."</u>";
		elseif( $server_version_beta2 )
		$print.= " untuk bisa mencoba versi <u>beta ".$server_version_beta2."</u>";
		
		$print.= "<br>";
		
		if( $server_version_stable )
		$print.= "<a target=\"_blank\" href=\"/latest.zip\" class=\"button black\" style=\"margin-top:10px\">Unduh Full Stable ".$server_version_stable."</a> ";		
		}
		
		if( $show_package == 1 )
		$print.= "<a target=\"_blank\" href=\"/latest-pack.zip\" class=\"button black\" style=\"margin-top:10px\">Unduh Pack Stable ".$server_version_stable."</a> ";
		
		if( $server_version_beta )
		$print.= "<a target=\"_blank\" href=\"/latest-beta.zip\" class=\"button black\" style=\"margin-top:10px\">Unduh & Coba Beta ".$server_version_beta."</a> ";
		elseif( $server_version_beta2 )
		$print.= "<a target=\"_blank\" href=\"/latest-beta.zip\" class=\"button black\" style=\"margin-top:10px\">Unduh & Coba Beta ".$server_version_beta2."</a> ";
		
		}
		else $print.='Compare Error';
		$print.= "</p>";
		
		return $print;
	}

	function message_attention(){
		$print = "<p class=\"message\">";
		$print.= "<strong>Penting : </strong>sebelum ujicoba/upgrade, silahkan <a href=\"?admin&sys=backup\">backup database dan file</a> terlebih dahulu";
		$print.= "</p>";
		return $print;
	}
	
	function message($data){
		$print = '';
		$print.= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
  		$print.= '<tr>';
   		$print.= '<td width="10%" valign="top" style="vertical-align:top"><img src="libs/img/icon-download-upgrade.png" style="margin-top:2px;"></td>';
    	$print.= '<td width="60%" valign="top">';
		$print.= show_message($data);		
		$print.= "</td>";
  		$print.= "</tr>";
		$print.= "</table>";
		return $print;
	}

switch( $_GET[action] ){
default:

$server = "/?api=$api_version&content=release";
$server = get_content( esc_sql( $api_url . $server ) );
$data 	= json_decode( $server, TRUE );

if( count($data[content]) > 0 ):
	$xy = $data[content];
		
		if( 'stable' == $version_project ) $system_stable = $version_system;
		elseif( 'beta' == $version_project ) $system_beta = $version_system;
			
		$system_beta = !isset($system_beta) ? '' : $system_beta;
		$system_stable = !isset($system_stable) ? '' : $system_stable;
		$server_available_beta = !isset($xy[version][release][code]) ? '' : $xy[version][release][name];
		$server_available_stable = !isset($xy[version][code]) ? '' : $xy[version][code];
		
		
		$r = array();
		$r[show_content] 	= $r[show_beta] = $opt = false;
		$r[show_package] 	= $xy[package];
		$r[system_beta] 	= $system_beta;
		$r[system_stable] 	= $system_stable;
	
		if($system_stable){
			if($server_available_stable){
				
				if(version_compare($server_available_stable,$system_stable, '>')) {
					$r[show_content] = $r[show_content_stable] = true;
					$r[server_version_stable] = $server_available_stable;
					
					if($server_available_beta)
					$r[server_version_beta] = $server_available_beta;
				}
				
				if( $server_available_beta ){
				if( version_compare($server_available_stable,$system_stable, '=') &&
					version_compare($server_available_beta,$system_stable, '>') ){
					$r[show_package] = false;
					$r[show_content] = $r[show_content_stable] = $r[show_beta] = true;
					$r[server_version_stable] = $server_available_stable;
					$r[server_version_beta] = $server_available_beta;
				}}
						
			}elseif( $server_available_beta ){
				if(version_compare($server_available_beta,$system_stable, '>')) {
					$r[show_content] = $r[show_content_stable] = $r[show_content_beta] = $r[show_beta] = true;
					$r[server_version_beta] = $server_available_beta;
				}
			}
		}elseif($system_beta){
			if( $server_available_beta ){
				
				if(version_compare($server_available_beta,$system_beta, '>')) {
					$r[show_content] = $r[show_content_beta] = $r[show_beta] = true;
					$r[server_version_beta2] = $server_available_beta;
					
					if($server_available_stable){
						$r[server_version_stable] = $server_available_stable;
						$r[server_version_beta] = $server_available_beta;
					}else
						$r[show_content_stable] = false;
					
					$opt = true;
				}
				
				if( $server_available_stable ){
				if( version_compare($server_available_beta,$system_beta, '=') &&
					version_compare($server_available_stable,$system_beta, '>') ){
					$r[show_package] = false;
					$r[show_content] = $r[show_content_beta] = $r[show_stable] = true;
					$r[server_version_beta] = $server_available_beta;
					$r[server_version_stable] = $server_available_stable;
					
					$opt = true;
				}}
				
			}
			if( $server_available_stable && $opt == false &&
				version_compare($server_available_stable, $system_beta, '>=')  ){
				
				//$r[show_package] = true;
				$r[show_content] = $r[show_content_beta] = $r[show_beta] = true;
				$r[server_version_stable] = $server_available_stable;
				
			}
			
		}else{ $r[show_content] = false; }
	
	if( $server ){
		if($data['show_content']) $print .= message($data);
		else $print.= "<div id=\"message_no_ani\" style=\"margin-left:0;margin-right:0;margin-bottom:10px\">Tidak ada  update versi baru yang ditemukan</div>";
	}else{
		$print.= "<div id=\"error_no_ani\" style=\"margin-left:0;margin-right:0;margin-bottom:10px\"><strong>HTTP Salah : </strong>tidak bisa terhubung ke host</div>";
	}
	
	echo $print;
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