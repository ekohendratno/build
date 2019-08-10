<?php 
/**
 * @fileName: admin.php
 * @dir: admin/templates/
 */
if(!defined('_iEXEC')) exit;
?><!DOCTYPE html>
<html lang="en">  
<head>
<meta charset="utf-8"> 
<title><?php the_admin_title()?></title>

<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">    

<link href="admin/templates/css/reset.css" rel="stylesheet" />
<link href="admin/templates/css/element.css" rel="stylesheet" />
<link href="admin/templates/css/forms.css" rel="stylesheet" />
<link href="admin/templates/css/style.css" rel="stylesheet" />
<link href="admin/templates/css/aside.css" rel="stylesheet" />
<link href="admin/templates/css/tiptip.css" rel="stylesheet" />
<link href="admin/templates/css/gd.css" rel="stylesheet" />
<link href="admin/templates/css/colors.css" rel="stylesheet" />
<link href="admin/templates/css/table.css" rel="stylesheet" />
<link href="admin/templates/css/css3-buttons.css" rel="stylesheet" />
<link href="admin/templates/css/wrap.css" rel="stylesheet" />
<link href="admin/templates/css/drop-shadow.css" rel="stylesheet" />
<link href="admin/templates/css/oops.css" rel="stylesheet" />
<link href="libs/css/button.css" rel="stylesheet" />
<link href="libs/css/scroll.css" rel="stylesheet" />

<!--[if lte IE 8]>
<script type="text/javascript" src="libs/js/html5.js"></script>
<![endif]-->
<script src="libs/js/jquery.js"></script>
<script src="libs/js/expand.js"></script>
<script src="libs/js/jquery-ui.js?v=1.8.16"></script>
<script src="libs/js/jquery.json.min.js?v=2.2"></script>
<script src="libs/js/jquery.ata.js"></script>

<script src="admin/templates/js/bootstrap-datepicker.js"></script>
<link href="admin/templates/css/datepicker.css" rel="stylesheet"/>

<script src="admin/templates/js/jquery.tiptip.js"></script>
<script src="admin/templates/js/running-script.js"></script>
<script src="admin/templates/js/widget-home.js"></script>

<script src="libs/js/redactor/redactor.js"></script>
<link rel="stylesheet" href="libs/js/redactor/css/redactor.css" />

<script src="libs/js/dialog/pbscript.js"></script>
<link href="libs/js/dialog/dialog.css" rel="stylesheet"/>

<script src="admin/templates/js/cekbox.js"></script>
<?php iw_head_admin();?>
</head>

<body>

<div id="redactor_modal_overlay" style="display: none;"></div>
<div id="redactor_modal_overlay_loading" style="display: none;"></div>

<!--Show Dialog-->
<div id="redactor_modal_console"  class="redactor_modal redactor_modal_loading" style="height: auto;display: none; ">
<div id="redactor_modal_inner_loading"><p>Sedang memperbaharui ....</p></div>
</div>
<!--Show End Dialog-->

<?php do_action('manager_top');?>
<?php do_action('manager_header');?>
<?php do_action('manager_content');?>
<?php do_action('manager_footer');?>

</body>
</html>