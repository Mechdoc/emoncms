<?php
$id=$_GET['id'];
if(!isset($_GET['id'])) 
        {
        $id = 'homepage';
        }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
  <head>
    <title>Emon CMS Team Demo</title>
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" media="screen" href="css/screen.css" type="text/css"></link>
  </head>
  <body>
    <div id="navbar">
      <?php @ require_once("menu.php"); ?>
    </div>
    <div id="content">
      <?php
      if(!file_exists("$id.php"))
        {
        include("error_404.php");
        }
      else
        {
        include("$id.php");
        }
      ?>
    </div>
  </body>
</html>
