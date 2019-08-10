<?php 
/**
 * @fileName: manage.php
 * @dir: admin/manage/options
 */
if(!defined('_iEXEC')) exit;
global $db, $widget;

$go 	= filter_txt($_GET['go']);
$act	= filter_txt($_GET['act']);
$id		= filter_int($_GET['id']);

ob_start();

switch($go){
default:

?>
<div class="padding">
<?php
if(isset($_POST['submit'])){
	$sitename 				= filter_txt($_POST['sitename']);
	$sitedescription 		= filter_txt($_POST['sitedescription']);
	$sitekeywords 			= filter_txt($_POST['sitekeywords']);
	$site_copyright			= filter_txt($_POST['site_copyright']);
	$admin_email 			= filter_txt($_POST['mail_adress']);
	$datetime_format 		= filter_txt($_POST['datetime_format']);
	$timeout			 	= filter_int($_POST['timeout']);
	$author 				= filter_txt($_POST['author']);
	$account_registration 	= filter_int($_POST['account_registration']);
	$avatar_type			= filter_txt($_POST['avatar_type']);
	$timezone				= filter_txt($_POST['timezone']);
	
	$data = compact('sitename','sitedescription','sitekeywords','site_copyright','admin_email','datetime_format','timeout','author','account_registration','timezone','avatar_type');
	set_general( $data );
	echo '<br>';
	add_activity('manager_options','mengubah settingan general option', 'setting');
}
?>
  <table width="100%">
    <tbody>
    <tr>
      <td width="24%">Site Title</td>
      <td width="1%"><strong>:</strong></td>
      <td width="75%"><input type="text" name="sitename" value="<?php _e(get_option('sitename'))?>" style="width:400px;"></td>
    </tr>
    <tr>
      <td>Description</td>
      <td><strong>:</strong></td>
      <td>
      <textarea type="text" name="sitedescription" style="width:400px; height:60px;"><?php _e(get_option('sitedescription'))?></textarea></td>
    </tr>
    <tr>
      <td>Keywords</td>
      <td><strong>:</strong></td>
      <td>
      <textarea type="text" name="sitekeywords" style="width:400px; height:60px;"><?php _e(get_option('sitekeywords'))?></textarea></td>
    </tr>
    <tr>
      <td>Copyright</td>
      <td><strong>:</strong></td>
      <td></textarea><input type="text" name="site_copyright" value="<?php _e(get_option('site_copyright'))?>" style="width:400px;"></td>
    </tr>
    <tr>
      <td>E-mail address</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="mail_adress" value="<?php _e(get_option('admin_email'))?>" style="width:400px;"></td>
    </tr>
    <tr>
      <td>Datetime format</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="datetime_format" value="<?php _e(get_option('datetime_format'))?>" style="width:150px;"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>ex: F j, Y, g:i a => March 10, 2001, 5:16 pm</td>
    </tr>
    <tr>
      <td>Time Out Session</td>
      <td><strong>:</strong></td>
      <?php $time = get_option('timeout');?>
      <td><input type="text" name="timeout" value="<?php _e($time)?>" style="width:100px"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td><?php echo round(($time/60),2)?> minutes, <?php echo round(($minute/60),2)?> hours</td>
    </tr>
    <tr>
      <td>Author Name</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="author" value="<?php _e(get_option('author'))?>"></td>
    </tr>
    <tr>
      <td>Account Registration</td>
      <td><strong>:</strong></td>
      <td>
      <select name="account_registration">
<?php
if(get_option('account_registration')==1){
	_e('	
      <option value="0">Disable</option>
      <option value="1" selected="selected">Enable</option>
	');
}else{	
	_e('	
      <option value="0" selected="selected">Disable</option>
      <option value="1">Enable</option>
	');
}
?>
      </select>
      </td>
    </tr>
    <tr>
      <td>Avatar Type</td>
      <td><strong>:</strong></td>
      <td>      
      <select name="avatar_type">
<?php
if(get_option('avatar_type')=='gravatar'){
?>	
      <option value="">-- Pilih --</option>
      <option value="gravatar" selected="selected">Gravatar</option>
      <option value="computer">Computer</option>
<?php
}elseif(get_option('avatar_type')=='computer'){
?>	
      <option value="">-- Pilih --</option>
      <option value="gravatar">Gravatar</option>
      <option value="computer" selected="selected">Computer</option>
<?php
}else{	
?>
      <option value="" selected="selected">-- Pilih --</option>
      <option value="gravatar">Gravatar</option>
      <option value="computer">Computer</option>
<?php
}
?>
      </select>
      </td>
    </tr>
    <?php  if ( function_exists('timezone_supported') ) :?>
    <tr>
      <td>Time Zone</td>
      <td><strong>:</strong></td>
      <td><select name="timezone"><?php $tzstring = get_option('timezone'); echo timezone_choice($tzstring);?></select></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>UTC: <i><?php _e(gmdate('Y-m-d G:i:s'))?></i> Local: <i><?php _e(date('Y-m-d G:i:s'))?></i></td>
    </tr>
    <?php else:?>
    <tr>
      <td>Time Zone</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="timezone" value="<?php _e(get_option('timezone'))?>"></td>
    </tr>
    <?php endif;?>
  </tbody></table><br />
</div>
<?php
$header_title = 'General Manage';
$form = 'action="" method="post" enctype="multipart/form-data" name="form1"';
$header_menu = '<input type="submit" name="submit" class="button on l" value="Save & Update"><input type="reset" class="button r" name="Reset" value="Reset">';

break;
case'gravatar':

if(isset($_POST['submit'])){
	$avatar_default = filter_txt($_POST['avatar_default']);
	echo '<div class="padding">';
	set_avatar( compact('avatar_default') );
	echo '</div>';
	add_activity('manager_options','mengubah settingan avatar', 'setting');
}

$avatar_defaults = array(
	'mystery' 			=> 'Mystery Man',
	'blank' 			=> 'Blank',
	'gravatar_default' 	=> 'Gravatar Logo',
	'identicon' 		=> 'Identicon (Generated)',
	'wavatar' 			=> 'Wavatar (Generated)',
	'monsterid' 		=> 'MonsterID (Generated)',
	'retro' 			=> 'Retro (Generated)'
);
$default = get_option('avatar_default');
if ( empty($default) )
$default 		= 'mystery';

foreach ( $avatar_defaults as $default_key => $default_name ) {
	$selected = ($default == $default_key) ? 'checked="checked" ' : '';
	$avatar_list .= "";

	$avatar = get_gravatar( 'unknow@mail.com', $default_key );
	$avatar_img = '';

	$avatar_name= $default_name;
}

?>
<table id=table cellpadding="0" cellspacing="0" width="100%">
<tr class="head">
    <td width="3%" style="text-align:left;border-top:0"><strong>Pilih</strong></td>
    <td width="7%" style="text-align:center;border-top:0"><strong>Image</strong></td>
    <td width="90%" style="text-align:left;border-top:0"><strong>Title</strong></td>
  </tr>
<?php
$warna 		= '';
foreach ( $avatar_defaults as $default_key => $default_name ) {
	
$warna 		= empty ($warna) ? ' bgcolor="#f1f6fe"' : '';
$selected 	= ($default == $default_key) ? 'checked="checked" ' : '';
$avatar 	= get_gravatar( 'unknow@mail.com', $default_key );
?>
  <tr <?php _e($warna)?> class="isi">
    <td><center><?php _e("<input type='radio' name='avatar_default' id='avatar_{$default_key}' value='" . esc_sql($default_key)  . "' {$selected}/>")?></center></td>
    <td align="center" style="padding:2px;"><img src="<?php _e($avatar)?>" alt="" width="30"/></td>
    <td style="padding:2px;"><?php _e($default_name)?></td>
  </tr>
<?php
}
?>
</table>
<?php
$header_title = 'Gravatar Manage';
$form = 'action="" method="post" enctype="multipart/form-data" name="form1"';
$header_menu = '<input type="submit" name="submit" class="button on l" value="Save & Update"><input type="reset" class="button r" name="Reset" value="Reset">';

break;
}

$content = ob_get_contents();
ob_end_clean();

$header_menu = '<div class="header_menu_top">'.$header_menu.'</div>';
add_templates_content_position( $content, $header_title, $header_menu, null, $form );