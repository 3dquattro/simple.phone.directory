<?php
//include '/admin/conf/config.php';

function show_header($page) //Вопрос "Зачем выносить это в отдельный файл и заранее? Для удобства правки, само собой."
{
	echo '
<html>
<head>
<meta charset="utf-8">
<title>'.$page.'</title>
<style>@import "/phones/style/main.css" screen; /* Стиль для вывода результата на монитор */</style></head>
<body>

  
<div class="main">';
}
function sh_header($page)
{
echo '
	<html>
<head>
<meta charset="utf-8">
<title>'.$page.'</title>
<style>@import "/phones/style/main.css" screen; /* Стиль для вывода результата на монитор */</style>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>  

<!-- x-editable (bootstrap version) -->
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<script>'.
"$.fn.editable.defaults.mode = 'popup';
$(document).ready(function() {

$('.pers-name').editable();
$('.pers-position').editable();
$('.pers-phone').editable();
$('.pers-innerphone').editable();
$('.pers-email').editable();
$('.pers-housing').editable();
$('.pers-cabinet').editable();


$('.dept-name').editable();
$('.dept-phone').editable();
$('.dept-innerphone').editable();
$('.dept-email').editable();
$('.dept-housing').editable();
$('.dept-cabinet').editable();


$('.subd-name').editable();
$('.subd-housing').editable();
$('.subd-cab').editable();
});
</script>
	</head>
<body>".'
<div class="main">
'
;
return;
}
function show_bottom()
{
	echo '</div></body>';
}

?>