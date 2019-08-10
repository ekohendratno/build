<?php 
/**
 * @fileName: admin.php
 * @dir: admin/
 */
if(!defined('_iEXEC')) exit;
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php the_admin_title()?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="libs/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="libs/css/bootswatch.css" media="screen">
    <link rel="stylesheet" href="libs/css/styled-custom.css" media="screen">
	
	<script type='text/javascript' src="libs/js/jquery-1.10.2.js"></script>
	<script type='text/javascript' src="libs/js/jquery-1.10.1.ui.js"></script>
	<script type='text/javascript' src="libs/js/bootstrap.min.js"></script>
		
	<script src="libs/js/jquery.json.min.js?v=2.2"></script>
    <?php the_head_admin();?>
  </head>
  <body>
    
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?admin"><?php echo get_option('sitename');?></a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li>
              <a href="?admin"><span class="glyphicon glyphicon-home"></span></a>
            </li>
            <li><a href="?admin=s&sys=plugin"><span class="glyphicon glyphicon-flash"></span> Plugin <span class="badge">3</span></a>
            </li>
            <li><a href="?admin=f&sys=plugin"><span class="glyphicon glyphicon-book"></span> Help and Guide</a>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><a class="img-name" href="?login=profile"> <img src="libs/img/cinqueterre.jpg" class="img-circle" alt="Cinque Terre" width="23" height="23"> Eko Azza</a></li>
            <li class="dropdown">
              <a href="#"><span class="glyphicon glyphicon-search"></span></a>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropsetting"><span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="download">
                <li><a href="?admin&amp;s=options">Pengaturan</a></li>
                <li><a href="?login=logout">Logout</a></li>
                <li class="divider"></li>
                <li><a id="link-modal" href="#">Help?</a></li>
              </ul>
            </li>
          </ul>

        </div>
      </div>
    </div>


    <div class="container">
    	<div class="row">
        	
			<?php 
			$s = in_array(is_admin_values(), array('f','404') );
			$col_md_number =  12;
			if( !$s ){
				$col_md_number = 10;
			?>
			<div class="col-md-2">       
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="?admin">Dashboard</a></li>
				<li class="nav-header">Actions</li>
				<li class="nav-divider"></li>
				<?php the_menuaction("<li><a href='","</a></li>");?>
				<li class="nav-header">Copyright</li>
				<li><span class="help-block">@CMS.id - 2015</span></li>
			</ul>
            </div>
            <?php }?>
            
            <?php 
			
			the_main_manager("<div class=\"col-md-$col_md_number\">","</div>");?>
			
			
        </div>
    </div>
	
	  
	<script src="libs/js/widget-home.dev.js"></script>
    <script src="libs/js/bootswatch.js"></script>
</body>
</html>