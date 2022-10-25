<?php

//include $_SERVER['DOCUMENT_ROOT'].'/phones/view.php';
require $_SERVER['DOCUMENT_ROOT'].'/phones/conf/config.php';

function show_table()
{
$conn = mysqli_connect($host,$username, $password);
mysqli_select_db($conn,"phones");
//Выполним запрос на существование подразделений
$query = $conf_sql_subdiv;
$result = mysqli_query($conn,$query);
//Если в базе нашлись подразделения
if(mysqli_num_rows($result) <> '0')
{
//Вывод шапки
echo '<table border="1" cellpadding="1" cellspacing="1" width="100%">';
echo '<tr>
<td rowspan="2">Subdivision/Position</td>
<td rowspan="2">Full name</td>
<td colspan="3">Contacts</td>
<td rowspan="2">Learning Campus №</td>
<td rowspan="2">Room number</td>
<td rowspan="2">Move ▲▼</td>
</tr>
<tr>
<td>outer phone num.</td>
<td>inner phone num.</td>
<td>e-mail</td>

</tr>';
//Цикл вывода подразделений
while ($row = $result->fetch_assoc()) 
	{
		//Вывод подразделения
		echo '<tr class="subd">
		<td colspan="5"><center>'.$row['name'].'</center></td>
		<td>'.$row['housing'].'</td>
		<td>'.$row['cabinet'].'</td>
		<td>&#9650;</td>
		</tr>';
		//Запрос на вывод подразделения
		$query = conf_sql_dept($row['id']);
		$result_subdiv = mysqli_query($conn,$query);
		
		//Цикл вывода отделов внутри подразделения
		while($rowinner = $result_subdiv->fetch_assoc())
		{
			//Вывод отдела
			
			echo '<tr class="dept">
			<td colspan="2"><b>'.$rowinner['name'].'</b></td>
			<td>'.$rowinner['phone'].'</td>
			<td>'.$rowinner['innerphone'].'</td>
			<td>'.$rowinner['email'].'</td>
			<td>'.$rowinner['housing'].'</td>
			<td>'.$rowinner['cabinet'].'</td></tr>';
			//Запрос на вывода сотрудника
			$query = conf_sql_pers($rowinner['id']);
			$result_pers = mysqli_query($conn,$query);
			//Цикл вывода сотрудников
			
			while($rowpers = $result_pers->fetch_assoc())
			{
				echo '<tr class="pers">
				<td>'.$rowpers['position'].'</td>
				<td>'.$rowpers['name'].'</td>
				<td>'.$rowpers['phone'].'</td>
				<td>'.$rowpers['innerphone'].'</td>
				<td>'.$rowpers['email'].'</td>
				<td>'.$rowpers['housing'].'</td>
				<td>'.$rowpers['cabinet'].'</td>
				</tr>';
			}
		}
	}
}
echo '</table>';
}




?>