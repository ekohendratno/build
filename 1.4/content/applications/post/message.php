<?php
/**
 * @file message.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $login, $db;

if( 'post/message.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

if( isset($_POST['textMessage']) ){
	$email = filter_txt( $_POST['email'] );
	$send_text = filter_txt( $_POST['textMessage'] );
	
	if( empty( $send_text ) )
		$msg[] = 'The message field is empty, ';
	if( empty( $email ) )
		$msg[] = 'The email field is empty, ';
	elseif( !valid_mail( $email ) ) 	
		$msg[] = 'The email not valid, ';
		
	
	if( is_array($msg))	{
		$msg_text = '';
		foreach($msg as $val){
			$msg_text.= $val;
		}
	}
	
	$response['status'] = 3;
	$response['msg'] = $msg_text;	
	
	if( empty($msg) ){
				
		$head  = 'Send message from '.site_url();
			
		if( mail_send($email, $head, $send_text) ){
			$response['status'] = 1;
			$response['msg'] = 'Success send a message';
		}else{
			$response['status'] = 3;
			$response['msg'] = 'Failed send message.';
		}
	}
	
	header('Content-type: application/json');	
	echo json_encode($response);
}else{

$comment_id = filter_int( $_GET['comment_id'] );
$post_comment = $db->fetch_obj(  $db->select('post_comment', compact('comment_id')) );
$post = $db->fetch_obj(  $db->select('post', array('id' => $post_comment->post_id)) );

$message = '<strong>Dari artikel ';
$message.= $post->title;
$message.= "</strong>";
$message.= "<br><br>";
$message.= $post_comment->comment;
?>

<div class="padding">
<form method="post" action="">
<input type="text" name="emailx" value="To: <?php echo $post_comment->email;?>" class="input disable" style="width:500px;" disabled>
<input type="hidden" name="email" value="<?php echo $post_comment->email;?>"><br>
<label for="textMessage">Message</label><br>
<?php the_editor($message,'editor_quick_post', array('editor_name' => 'textMessage','editor_style' => 'height:150px;width:95%;'), array( 'toolbar' => 'simple', 'css' => 'wym-simple.css') );?>
</form>
</div>
<?php
}
endif;
?>