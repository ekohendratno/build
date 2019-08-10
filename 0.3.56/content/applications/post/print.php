<?php
/**
 * @file load.prosess.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $iw,$db;
$id 		= filter_int($_GET['id']);
$q			= $db->query("select * from ".$iw->pre."post where id=$id");
$hits		= 0;
$data   	= $db->fetch_array($q);
if(empty($data['id'])){
echo'<meta http-equiv="refresh" content="0; url='.$iw->base_url.'index.php" />';
}else{
$title		=$data['title'];
$description=limittxt(htmlentities(strip_tags($data['content'])),200);
$keywords	=empty($data['tags']) ? implode(',',explode(' ',htmlentities(strip_tags($data['title'])))) : $data['tags'];
?>
<style type="text/css">
html{height:100%;padding-bottom:1px}
*{padding:0;margin:0}
body{margin:0;padding:5px;font-family:segoe ui,Trebuchet MS,verdana,Helvetica,Arial,Verdana,sans-serif;font-size:12px;color:#39444d;background:#fff}
a{color:#4284B0;background-color:none;text-decoration:none}
a:hover{color:#C00;background-color:none}
h1,h2,h3{font:bold 1em Calibri, Arial, Sans-serif;color:#333}
h1{font-size:1.8em;color:#3b59aa}
h2{font-size:1.2em;text-transform:uppercase}
h3{font-size:1.2em}
h4{font-size:1.2em;color:#572C83;text-align:center}
ul,ol{margin:10px 30px;padding:0 15px;color:#4284B0}
ul span,ol span{color:#666}
img{border:0 solid #CCC}
img.no-border{border:none}
img.float-right{margin:5px 0 5px 5px}
img.float-left{margin:5px 5px 5px 0}
code{margin:5px 0;padding:10px;text-align:left;display:block;overflow:auto;font:500 1em/1.5em 'Lucida Console', 'courier new', monospace;background:#FAFAFA;border:1px solid #f2f2f2;border-left:4px solid #4284B0}
acronym{border-bottom:1px solid #777}
blockquote {
display					:block;
padding					:5px 30px 0 30px;
min-height				:10px;
border					:1px solid #f2f2f2;
font-style				:italic;
}
blockquote:before, blockquote:after {
color					:#69c;
display					:block;
font-size				:500%;
width					:20px;
height					:100%;
}
blockquote:before {
content					:open-quote;
height					:10px;
margin-left				:-0.55em;
}
blockquote:after {
content					:close-quote;
height					:30px;
margin-top				:-25px;
margin-left				:98%;
}
</style>
<div style="background:#fff url(content/applications/post/images/grey_bg.png) top repeat-x; height:24px; padding:5px"></div>
<h1><?php echo $data['title'];?></h1><br />
<div>
<div style="width:60%; float:left;"><?php echo datetimes($data['date_post']);?> - by : <?php echo $data['author'];?> - hits : <?php echo $data['hits'];?></div>
<div style="width:5%; float:right;" align="right">
<a href="#" onclick="window.print();return false;"><img src="content/applications/post/images/printButton.png" alt="print" height="16"/></a>
</div>
</div>
<br />
<div style="margin-top:35px;">
	<?php
    $post_img='';
	if(file_exists( upload_path.'post/'.$data['thumb'])&&!empty($data['thumb']))
	$post_img='<img src="?request&load=thumb.php&apps=post&src='.$data['thumb'].'&x=260&y=260&c=1" style="float:left; margin-right:5px;">';
	?>
	<?php echo $post_img;?>
	<?php echo $data['content'];?></div>
    <?php
    }
    ?>
