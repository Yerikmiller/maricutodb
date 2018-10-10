<?php

define('DATABASE', dirname(__DIR__).'/MaricutoDB/init.php');
define('src', 'src/files/');
define('src_folder', 'src/files/');
$ACTUAL_LINK = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

require_once DATABASE;


?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Shortener by MaricutoDB</title>
<meta charset='utf-8' >
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta property="og:locale" content="es_ES" />
<link rel="stylesheet" href="<?= src;?>bulma.min.css" media="all" />
<link rel="stylesheet" href="<?= src;?>custom.css" media="all" />
<script src="<?= src;?>jquery.js""></script>
<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:200,300,400,700" rel="stylesheet">
<script src="<?= src_folder; ?>clipboard.min.js" defer></script>
<style>
html, body{
  overflow-y: inherit !important;
  overflow-x: hidden;
}
.navbar{
  background-color: #00d1b2 !important;
}
.josefin{
  font-family: Josefin Sans, Calibri,'Sans serif';
}
.bolder{
  font-weight: 700;
  font-weight: bolder;
}
.light{
  font-weight: 300;
}
.lighter{
  font-weight: 200;
  font-weight: lighter;
}
.normal{
  font-weight: 400;
}
.img_10 {width:10%!important;}
.img_20 {width:20%!important;}
.img_30 {width:30%!important;}
.img_40 {width:40%!important;}
.img_50 {width:50%!important;}
.img_60 {width:60%!important;}
.img_70 {width:70%!important;}
.img_80 {width:80%!important;}
.img_90 {width:90%!important;}
.img_100{width:100%!important;}
.img_120{width:120px!important;}
.img_180{width:180px!important;}
.h-240{height:235px!important;}
.padding-12-r{padding-right:12px;}
.padding-12-l{padding-left:12px;}
.float-l{float:left;}
.float-r{float:right;}
.add-padding{padding-left:6px;padding-right:6px;}
.icon-120{width:120px;}
.icon-180{width:180px;}
.icon-80{width:80px;}
.icon-60{width:60px;}
.icon-40{width:40px;}
.icon-30{width:30px;}
.icon-25{width:20px;}
.icon-20{width:20px;}
</style>


</head>