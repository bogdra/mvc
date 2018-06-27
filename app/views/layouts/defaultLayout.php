<!DOCTYPE html>
<html lang="en">
  <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title> <?=$this->siteTitle();?> </title>



		<!-- Bootstrap -->

		<link href="<?=PROOT?>css/bootstrap.min.css" 	rel="stylesheet" media="screen" >
		<link href="<?=PROOT?>css/custom.css" 			rel="stylesheet" media="screen" >

    <script type="text/javascript" src="<?=PROOT?>js/jquery-1.9.1.js"> </script>
    <script type="text/javascript" src="<?=PROOT?>js/bootstrap.min.js"> </script>


		<?=$this->content('head')?>

  </head>

  <body>
    <?php //include('main_menu.php'); ?>
    <div class="container-fluid" style="min-height:calc(100% - 125px);">
    </div>
 <?=$this->content('body');?>
  </body>
</html>
