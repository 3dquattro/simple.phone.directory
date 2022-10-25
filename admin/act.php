<?php
//Файл с обработчиками действий в ключе "добавить", "удалить", "переместить"
include $_SERVER['DOCUMENT_ROOT'].'/phones/conf/config.php';
//Подсоединимся к БД
$conn = mysqli_connect($host,$username, $password);
mysqli_select_db($conn,"phones");
if(isset($_POST['name']))
{
	//Подбор "таблицы" по наименованию поля
	$table = '';
	//Редактирование разных данных
	if(mb_substr($_POST['name'],0,5) == 'pers-')
	{
		$table = 'person';
	}
	elseif(mb_substr($_POST['name'],0,5) == 'dept-')
	{
		$table = 'department';
	}
	elseif(mb_substr($_POST['name'],0,5) == 'subd-')
	{
		$table = 'subdivision';
	}
	//Подбор столбца по наименованию поля
	$column = mb_substr($_POST['name'],5);
	//Изменение данных
	$sql = 'UPDATE '.$table.' SET '.$column."='".$_POST['value']."' WHERE ".$table.".id='".$_POST['pk']."'";
	file_put_contents("log.txt",$sql);
	$result = mysqli_query($conn,$sql);
	$conn->close();
	exit();
}
if(!isset($_GET["oper"]) and !isset($_POST['name']))
{
	echo 'Operation is unset';
	$conn->close();
	exit();
}
//------------------------------------------------------------------------------------------------
//--------------------------------ОПЕРАЦИЯ-ОПРЕДЕЛЕНА---------------------------------------------
//------------------------------------------------------------------------------------------------
else
{
$table = '';
	//Получим все необходимые сведения
if(mb_substr($_GET["oper"],-1) == 'p')
{
	$table = 'person';
}
elseif(mb_substr($_GET["oper"],-1) == 'd')
{
	$table = 'department';
}
elseif(mb_substr($_GET["oper"],-1) == 's')
{
	$table = 'subdivision';
}

//Деление по операциям
if (mb_substr($_GET["oper"],0,3) == 'add')
{
	
	//Запрос на
	if($table == 'person')
	{
		$sql = 'INSERT INTO person VALUES (DEFAULT,'.$_GET["id"].',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT)';
	}
	elseif($table == 'department')
	{
		$sql = 'INSERT INTO department VALUES (DEFAULT,'.$_GET["id"].',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT)';
	}
	elseif($table == 'subdivision')
	{
		$sql = 'INSERT INTO subdivision VALUES (DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT)';
	}
	$result = mysqli_query($conn,$sql);
	$conn->close();
	header("Location: /phones/admin/");
	exit();
	
}
//поднятие/опускание человека/отдела/подразделения
elseif (($_GET["oper"] == 'upp' 
or $_GET["oper"] == 'upd' 
or $_GET["oper"] == 'ups'
or $_GET["oper"] == 'downp' 
or $_GET["oper"] == 'downd' 
or $_GET["oper"] == 'downs') 
and isset($_GET["id"])) 
{

	
	$sql = "SELECT * FROM ".$table." WHERE ".$table.".id='".$_GET["id"]."'";
	$result = mysqli_query($conn,$sql);
	$fres = $result->fetch_assoc();
	//Получим и изменим значение приоритета
	$priority = $fres['posn'];
	//Если
	if($_GET['oper'] == 'downp' 
	or $_GET["oper"] == 'downd' 
	or $_GET["oper"] == 'downs') 
	{
		$priority = $priority+1; //Если "опускаем" запись, то значение увеличивается
	}
	else
	{
		if($priority>0)
		{
			$priority = $priority-1;
		}
		else
		{
			$priority = 0;
		}
	}
	$sql = "UPDATE ".$table." SET posn='".$priority."' WHERE ".$table.".id='".$fres['id']."'";
	$result = mysqli_query($conn,$sql);
	$conn->close();
	header("Location: /phones/admin/");
	exit();
}
//------------------------------------------------------------------------------------------------
//-------------------------------------------УДАЛЕНИЕ---------------------------------------------
//------------------------------------------------------------------------------------------------
elseif (mb_substr($_GET["oper"],0,3) == 'del' and isset($_GET["id"]))
{
	if($table == 'subdivision')
	{
		//
		$sql1 = "SELECT * from department where subid='".$_GET["id"]."'";
		$result = mysqli_query($conn,$sql1);
		$fres = mysqli_fetch_all($result,MYSQLI_ASSOC);
		//
		$sql2 = 'DELETE FROM department where id in(';
		$sql3 = 'DELETE FROM person where depid in(';
		$ids = '';
		for($i = 0;$i<count($fres);$i++)
		{
			
			$ids = ''.$ids."'".strval($fres[$i]['id'])."',";
			
		}
		$ids = mb_strcut($ids,0,-1);
		$sql2 = ''.$sql2.$ids.')';
		$sql3 = ''.$sql3.$ids.')';
		file_put_contents("log.txt",$sql2);
		file_put_contents("log.txt",$sql3);
		$result = mysqli_query($conn,$sql2);
		$result = mysqli_query($conn,$sql3);
	
	}
	elseif($table == 'department')
	{
		$sql2 = "'DELETE FROM person WHERE depid='".$_GET['id']."'";
		$result = mysqli_query($conn,$sql2);
	}
	
	
	$sql = 'DELETE FROM '.$table." WHERE id = '".$_GET['id']."'"; //Удалим саму запись
	$result = mysqli_query($conn,$sql);
	$conn->close(); //Наконец закроем соединение
	header("Location: /phones/admin/");
	exit();
}
}

?>