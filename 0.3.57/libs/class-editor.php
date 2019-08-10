<?php 
/**
 * @fileName: class-editor.php
 * @dir: libs/
 */
if(!defined('_iEXEC')) exit;

final class wysywigEditor{
	
	private static $baseurl;
	private static $first_init;
	private static $settings = array();
	private static $editor_id;
	private static $setting;
	
	private function __construct() {}
	
	public static function parse_settings($editor_id, $settings) {
		$setting = parse_args( $settings,  array(
			'editor_name' => $editor_id,
			'editor_rows' => '10',
			'editor_css' => '',
			'editor_class' => '',
			'editor_style' => ''
		) );
		return $setting;
	}
	
	public static function editor_settings($editor_id, $setting){
		self::$setting = $setting;
		self::$editor_id = $editor_id;
		self::$baseurl = site_url();
		self::$first_init = array(
			'lang' => 'id',
			'toolbar' => 'a77a',
			'css' => 'wym.css',
			//'fixed' => 'true',
			//'autosave' => self::$baseurl .'ajax/save.php',
			//'interval' => '60',	
			'imageGetJson' => self::$baseurl .'/?request&load=libs/ajax/image.php',
			'fileUpload' => self::$baseurl .'/?request&load=libs/ajax/file-upload.php',	
			'imageUpload' => self::$baseurl .'/?request&load=libs/ajax/image-upload.php',
			'linkFileUpload' => self::$baseurl .'/?request&load=libs/ajax/file_link_upload.php'			
			);
			
		$baseurl = self::$baseurl.'/libs/';
		$wInit = '';
		$wInit.= "<link rel='stylesheet' href='{$baseurl}js/redactor/css/redactor.css' />";
		$wInit.= "<script type='text/javascript' src='{$baseurl}js/redactor/redactor.js'></script>";		
		$wInit.= "<script type=\"text/javascript\">\n";
		$wInit.= "$(document).ready(function(){\n";
		
		$qtInit = "";
		if ( !empty(self::$first_init) ) {
			foreach ( self::$first_init as $options_id => $options ) {
				$qtInit .= "'$options_id':'{$options}',\n";
			}
			$qtInit = "$('#".self::$editor_id."').redactor({\n" . trim($qtInit, ",\n") . "\n});\n";
		} else {
			$qtInit = '{}';
		}		
		
		$wInit.= $qtInit;
		$wInit.= "});\n";
		$wInit.= "</script>\n";
		
		return $wInit;
	}	
	
	public static function editor( $content = '<p>&nbsp;</p>' ) {
		
		$setting = self::parse_settings(self::$editor_id, self::$setting);
		$editor_class = ' class="' . trim( $setting['editor_class'] . 'editor-area' ) . '"';
		$editor_style = ' style="' . (empty($setting['editor_style']) ? '' : $setting['editor_style']) . '"';
		//$content = (empty($content) ? '&lt;p&gt;&nbsp;&lt;/p&gt;' : $content);
		$content = empty($content) ? '' : $content;
		$rows = ' rows="' . (int) $setting['editor_rows'] . '"';
		
		$content = apply_filters('the_editor_content', $content);
		$the_editor = apply_filters('the_editor', '<textarea' . $editor_class . $editor_style . $rows . ' cols="40" name="' . $setting['editor_name'] . '" id="' . self::$editor_id . '">%s</textarea>');
		
		print self::editor_settings(self::$editor_id, $setting);		
		printf($the_editor,$content);
	}

	private static function _parse_init($init) {
		$options = '';

		foreach ( $init as $k => $v ) {
			if ( is_bool($v) ) {
				$val = $v ? 'true' : 'false';
				$options .= $k . ':' . $val . ',';
				continue;
			} elseif ( !empty($v) && is_string($v) && ( ('{' == $v{0} && '}' == $v{strlen($v) - 1}) || ('[' == $v{0} && ']' == $v{strlen($v) - 1}) || preg_match('/^\(?function ?\(/', $v) ) ) {
				$options .= $k . ':' . $v . ',';
				continue;
			}
			$options .= $k . ':"' . $v . '",';
		}

		return '{' . trim( $options, ' ,' ) . '}';
	}
	
	
}


