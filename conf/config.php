<?php
//Реквизиты для коннекта к базе
$host = 'localhost';
$password = 'pswd';
$username = 'phones';
$path = '/phones/';
$url = 'http://8.8.8.8/golos/index.php?id=';
$url_adm = 'http://8.8.8.8/golos/admin/act.php?id=';


$conf_sql_subdiv =	'SELECT id,name,housing,cabinet from subdivision
					order by subdivision.posn';
function conf_sql_dept($subid)
{ 
return "SELECT id,name,phone,innerphone,email,housing,cabinet from department where department.subid ='".$subid."' order by department.posn";
}
function conf_sql_pers($depid)
{
	return "SELECT id,name,phone,innerphone,email,housing,cabinet,position from person where person.depid ='".$depid."' order by person.posn";
}


?>