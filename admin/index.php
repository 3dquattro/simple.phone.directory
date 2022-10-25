<?php
include $_SERVER['DOCUMENT_ROOT'].'/phones/view.php';
require $_SERVER['DOCUMENT_ROOT'].'/phones/conf/config.php';

//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------



function cconf_sql_dept($subid)
{ 
return "SELECT id,name,phone,innerphone,email,housing,cabinet from department where department.subid ='".$subid."' order by department.posn";
}
function cconf_sql_pers($depid)
{
	return "SELECT id,name,phone,innerphone,email,housing,cabinet,position from person where person.depid ='".$depid."' order by person.posn";
}

function show_table($host,$username,$password)
{
$conn = mysqli_connect($host,$username, $password);
mysqli_select_db($conn,"phones");
$cconf_sql_subdiv =	'SELECT id,name,housing,cabinet from subdivision
					order by subdivision.posn';
//Выполним запрос на существование подразделений
$query = $cconf_sql_subdiv;
$result = mysqli_query($conn,$query);

//Если в базе нашлись подразделения
if(mysqli_num_rows($result) <> '0')
{
//Вывод шапки
echo '<center><table border="1" cellpadding="1" cellspacing="1" width="88%">';
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
		<td colspan="5"><center><a href="#" class="subd-name" data-name="subd-name" data-type="text" data-pk="' . $row['id'] . '" data-url="act.php" >'.$row['name'].'</a></center></td>
		<td><a href="#" class="subd-housing" data-name="subd-housing" data-type="text" data-pk="' . $row['id'] . '" data-url="act.php" >'.$row['housing'].'</a></td>
		<td><a href="#" class="subd-cab" data-name="subd-cabinet" data-type="text" data-pk="' . $row['id'] . '" data-url="act.php" >'.$row['cabinet'].'</td>
		<td><a href="/phones/admin/act.php?oper=ups&id='.$row['id'].'">▲</a><a href="/phones/admin/act.php?oper=downs&id='.$row['id'].'">▼</a> <a href="/phones/admin/act.php?oper=dels&id='.$row['id'].'">Remove</a></td>
		</tr>';
		//Запрос на вывод подразделения
		$query = cconf_sql_dept($row['id']);
		$result_subdiv = mysqli_query($conn,$query);
		
		//Цикл вывода отделов внутри подразделения
		while($rowinner = $result_subdiv->fetch_assoc())
		{
			//Вывод отдела
			
			echo '<tr class="dept">
			<td colspan="2"><b><a href="#" class="dept-name" data-name="dept-name" data-type="text" data-pk="' . $rowinner['id'] . '" data-url="act.php" >'.$rowinner['name'].'</a></b></td>
			<td><a href="#" class="dept-phone" data-name="dept-phone" data-type="text" data-pk="' . $rowinner['id'] . '" data-url="act.php" >'.$rowinner['phone'].'</td>
			<td><a href="#" class="dept-innerphone" data-name="dept-innerphone" data-type="text" data-pk="' . $rowinner['id'] . '" data-url="act.php" >'.$rowinner['innerphone'].'</a></td>
			<td><a href="#" class="dept-email" data-name="dept-email" data-type="text" data-pk="' . $rowinner['id'] . '" data-url="act.php" >'.$rowinner['email'].'</a></td>
			<td><a href="#" class="dept-housing" data-name="dept-housing" data-type="text" data-pk="' . $rowinner['id'] . '" data-url="act.php" >'.$rowinner['housing'].'</a></td>
			<td><a href="#" class="dept-cabinet" data-name="dept-cabinet" data-type="text" data-pk="' . $rowinner['id'] . '" data-url="act.php" >'.$rowinner['cabinet'].'</a></td>
			<td><a href="/phones/admin/act.php?oper=upd&id='.$rowinner['id'].'">▲</a><a href="/phones/admin/act.php?oper=downd&id='.$rowinner['id'].'">▼</a> <a href="/phones/admin/act.php?oper=deld&id='.$rowinner['id'].'">Remove</a></td>
			</tr>';
			
			//Запрос на вывода сотрудника
			$query = cconf_sql_pers($rowinner['id']);
			$result_pers = mysqli_query($conn,$query);
			//Цикл вывода сотрудников
			
			while($rowpers = $result_pers->fetch_assoc())
			{
				echo '<tr class="pers">
				<td><a href="#" class="pers-position" data-name="pers-position" data-type="text" data-pk="' . $rowpers['id'] . '" data-url="act.php" >'.$rowpers['position'].'</a></td>
				<td><a href="#" class="pers-name" data-name="pers-name" data-type="text" data-pk="' . $rowpers['id'] . '" data-url="act.php" >'.$rowpers['name'].'</a></td>
				<td><a href="#" class="pers-phone" data-name="pers-phone" data-type="text" data-pk="' . $rowpers['id'] . '" data-url="act.php" >'.$rowpers['phone'].'</a></td>
				<td><a href="#" class="pers-innerphone" data-name="pers-innerphone" data-type="text" data-pk="' . $rowpers['id'] . '" data-url="act.php" >'.$rowpers['innerphone'].'</a></td>
				<td><a href="#" class="pers-email" data-name="pers-email" data-type="text" data-pk="' . $rowpers['id'] . '" data-url="act.php" >'.$rowpers['email'].'</a></td>
				<td><a href="#" class="pers-housing" data-name="pers-housing" data-type="text" data-pk="' . $rowpers['id'] . '" data-url="act.php" >'.$rowpers['housing'].'</a></td>
				<td><a href="#" class="pers-cabinet" data-name="pers-cabinet" data-type="text" data-pk="' . $rowpers['id'] . '" data-url="act.php" >'.$rowpers['cabinet'].'</td>
				<td><a href="/phones/admin/act.php?oper=upp&id='.$rowpers['id'].'">▲</a><a href="/phones/admin/act.php?oper=downp&id='.$rowpers['id'].'">▼</a>  <a href="/phones/admin/act.php?oper=delp&id='.$rowpers['id'].'">Remove</a></td>
				</tr>';
			}
			//Выведем строку с добавлением 
			echo '<tr><td colspan="8"><center><i><a href="/phones/admin/act.php?id='.$rowinner['id'].'&oper=addp">Add person to department</a></i></center></td><tr>';
		}
		echo '<tr><td colspan="8"><center><i><a href="/phones/admin/act.php?id='.$row['id'].'&oper=addd">Add department</a></i></center></td><tr>';
	}
	echo '<tr><td colspan="8"><center><i><a href="/phones/admin/act.php?id=9&oper=adds">Add subdivision</a></i></center></td><tr>';
}
echo '</table></center>';
$conn->close();
}




sh_header("Admin page");
show_table($host,$username,$password);

?>