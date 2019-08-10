<?php 
/**
 * @fileName: rewrite.php
 * @dir: libs/
 */
if(!defined('_iEXEC')) exit;

class engine{
	var $data_judul;
	
	function construct($data_judul){
		return $this->data_judul=$this->add_space($data_judul);
	}
	function __toString(){
		return $this->data_judul;
	}
	private function add_space($string){
		if($string!='')
		$stringname=html_entity_decode($string);
		$stringname=strtolower(preg_replace("/[^A-Za-z0-9-]/","-",$stringname));
		return $stringname;
	}
	private function add_to_expload($explode){
		$explode=explode('-',$this->construct($explode));
		$jumcount=count($explode);
		for($i=0; $i<=$jumcount; $i++){
			if(!empty($explode[$i]))
				$string[] = $explode[$i];
		}
		if(!empty($string))	$implode=implode("-",$string);
		return $implode;		
	}
	function judul($data){
		return $this->data_judul=$this->add_to_expload($data);
	}
	function convert_tags($data){
		$explode = explode('+',$data);
		//$jumcount=count($explode);
		//for($i=0; $i<=$jumcount; $i++){
		for($i=0; $i<=5; $i++){
			if(!empty($explode[$i]))
				$string[] = $explode[$i];
		}
		return implode("-",$string);
	}
	function item($int){
		if (is_numeric ($int)){
			return (int)preg_replace ( '/\D/i', '', $int);
		}
	}	
}
class linked extends engine{
	
	function set( $app, $data = null ){
	global $rewrite_link, $rewrite_app, $rewrite_data;
	
	
	$rewrite_app = esc_sql( $app );
	$rewrite_data = esc_sql( $data );
	
	do_action('rewrite');
	
	if( !checked_option('rewrite') ) $set_rewrite = 'advance';
	else $set_rewrite = get_option('rewrite');
	
	//view,cat_id,id,offset
	if( ($set_rewrite != 'advance' or $set_rewrite != 'advance-type') 
	&& !empty($rewrite_link) ):	
		/*
		 * Type: Where using plugin load in function load_plugin_link()
		 * Number: N/A
		 */	
		$link = $rewrite_link;
			
	else:
		if(!empty($data)):
		if(!is_array($data))
		return false;	
		extract($data, EXTR_SKIP);
		endif;
		/*
		 * Type: Advance (default)
		 * Number: 1
		 */	
		if($app=='login' || $app=='logout'):
			if(!empty($go) && !empty($act)):
				//?login&go=N/A&cat=N/A; 
				$link = '?'.$app.'&go='.$go.'&act='.$act;
			elseif(!empty($go)):
				//?login&go=N/A; 
				$link = '?'.$app.'&go='.$go;
			else:
				if($app == 'logout'):
				//?login&go=N/A; 
				$link = '?login&go='.$app;
				else:
				//?login
				$link = '?'.$app; 
				endif;
			endif;
		else:
			if(!empty($offset) && !empty($cat_id) && !empty($id) && !empty($view)):
				//?com=N/A&view=N/A&cat_id=N/A&id=N/A&offset=N/A
				$link = '?com='.$app.'&view='.$view.'&cat_id='.$cat_id.'&id='.$id.'&offset='.$offset; 
			elseif(!empty($offset) && !empty($id) && !empty($view)):
				//?com=N/A&view=N/A&id=N/A&offset=N/A
				$link = '?com='.$app.'&view='.$view.'&id='.$id.'&offset='.$offset; 
			elseif(!empty($offset) && !empty($view)):
				//?com=N/A&view=N/A&offset=N/A
				$link = '?com='.$app.'&view='.$view.'&offset='.$offset; 
			elseif(!empty($cat_id) && !empty($id) && !empty($view)):
				//?com=N/A&view=N/A&cat_id=N/A&id=N/A
				$link = '?com='.$app.'&view='.$view.'&cat_id='.$cat_id.'&id='.$id; 
			elseif(!empty($id) && !empty($view) && !empty($reply)):
				//?com=N/A&view=N/A&id=N/A&reply=N/A
				$link = '?com='.$app.'&view='.$view.'&id='.$id.'&reply='.$reply; 
			elseif(!empty($id) && !empty($view)):
				//?com=N/A&view=N/A&id=N/A
				$link = '?com='.$app.'&view='.$view.'&id='.$id; 
			elseif(!empty($id)):
				//?com=N/A&id=N/A
				$link = '?com='.$app.'&id='.$id; 
			elseif(!empty($view)):
				//?com=N/A&view=N/A
				$link = '?com='.$app.'&view='.$view; 
			else:
				//?com=N/A
				$link = '?com='.$app; 
			endif;
		endif;
		
		if( function_exists('rewrite_delete') ) 
			rewrite_delete();
		
	endif;
	
	if( !empty($app) ) return site_url( $link );
	else return site_url();
	
	}
}

function do_links( $type, $data = false ){
	$convert = new linked;
	return $convert->set( $type, $data );
}