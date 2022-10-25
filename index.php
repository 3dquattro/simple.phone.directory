
<?php
//----------------------------------------------------------------------------------------------------------
//---------------------Отображение-таблицы-с-телефонами-----------------------------------------------------
//----------------------------------------------------------------------------------------------------------
include 'conf/config.php';
include 'view.php';
show_header("Phone directory");

//Подключение к бд
$conn = mysqli_connect($host,$username, $password);
mysqli_select_db($conn,"phones");
//Выполним запрос на существование подразделений
$query = $conf_sql_subdiv;
$result = mysqli_query($conn,$query);
//Если в базе нашлись подразделения
if(mysqli_num_rows($result) <> '0')
{
//Вывод шапки
echo '<center><table border="1" cellpadding="1" cellspacing="1" width="85%">';
echo '<thead><tr><td rowspan="2" width="13%">Subdivision/Position</td><td rowspan="2">Full name</td><td colspan="3">Contacts</td><td rowspan="2">Learning Campus №</td><td rowspan="2">Room number</td></tr>
<tr><td width="9%">outer phone num.</td>
<td>inner phone num.</td>
<td>e-mail</td></tr></thead><tbody>';
//Цикл вывода подразделений
while ($row = $result->fetch_assoc()) 
	{
		//Вывод подразделения <td>'.$row['housing'].'</td><td>'.$row['cabinet'].'</td>
		echo '<tr><td colspan="7"><b><center>'.$row['name'].'</center></b></td></tr>';
		//Запрос на вывод подразделения
		$query = conf_sql_dept($row['id']);
		$result_subdiv = mysqli_query($conn,$query);
		
		//Цикл вывода отделов внутри подразделения
		while($rowinner = $result_subdiv->fetch_assoc())
		{
			//Вывод отдела
			if($rowinner['name']<>'hidden')
			echo '<tr><td colspan="2"><b>'.$rowinner['name'].'</b></td><td>'.$rowinner['phone'].'</td><td>'.$rowinner['innerphone'].'</td><td>'.$rowinner['email'].'</td><td>'.$rowinner['housing'].'</td><td>'.$rowinner['cabinet'].'</td></tr>';
			//Запрос на вывода сотрудника
			$query = conf_sql_pers($rowinner['id']);
			$result_pers = mysqli_query($conn,$query);
			//Цикл вывода сотрудников
			$fres = mysqli_fetch_all($result_pers,MYSQLI_ASSOC);
			//Далее идет упоротый алгоритм объединения строк.
			//Он состоит в том что каждый раз, у каждого физика проверяется есть ли повторы, проверяется глубина повторов вниз. Предполагается что должность и ФИО не повторяются
			$phone_count = 0; //число оставшихся повторов телефона
			$email_count = 0; //число оставшихся повторов эл.почты
			$innerphone_count = 0; //число оставшихся повторов внутреннего телефона
			$housing_count = 0; //число оставшихся повторов корпуса
			$cabinet_count = 0; //число оставшихся повторов кабинета
			//Цикл православного объединенного вывода таблиц
			if(count($fres)>0)
			{
			for($i=0;$i<count($fres);$i++)
			{
				//Выведем первые два столбца
				echo '<tr><td>'.$fres[$i]['position'].'</td><td>'.$fres[$i]['name'].'</td>';
				//Проверка на телефон
				if($phone_count == 0) 
				{
					for($j = $i+1; $j<count($fres); $j++)
					{
						if($fres[$i]['phone'] == $fres[$j]['phone'])
						{
							$phone_count = $phone_count + 1; 
						}
						else
						{
							break;
						}
					}
					
					echo '<td rowspan="'.strval($phone_count+1).'">'.$fres[$i]['phone'].'</td>';
				}
				elseif($phone_count>0)
				{
					$phone_count = $phone_count-1;
				}
				//проверка на внутренний телефон
				if($innerphone_count == 0) 
				{
					for($j = $i+1; $j<count($fres); $j++)
					{
						if($fres[$i]['innerphone'] == $fres[$j]['innerphone'])
						{
							$innerphone_count = $innerphone_count + 1; 
						}
						else
						{
							break;
						}
					}
					
					echo '<td rowspan="'.strval($innerphone_count+1).'">'.$fres[$i]['innerphone'].'</td>';
				}
				elseif($innerphone_count>0)
				{
					$innerphone_count = $innerphone_count-1;
				}
				//Проверка почты
				if($email_count == 0) 
				{
					for($j = $i+1; $j<count($fres); $j++)
					{
						if($fres[$i]['email'] == $fres[$j]['email'])
						{
							$email_count = $email_count + 1; 
						}
						else
						{
							break;
						}
					}
					
					echo '<td rowspan="'.strval($email_count+1).'">'.$fres[$i]['email'].'</td>';
				}
				elseif($email_count>0)
				{
					$email_count = $email_count-1;
				}
				//Корпус
				if($housing_count == 0) 
				{
					for($j = $i+1; $j<count($fres); $j++)
					{
						if($fres[$i]['housing'] == $fres[$j]['housing'])
						{
							$housing_count = $housing_count + 1; 
						}
						else
						{
							break;
						}
					}
					
					echo '<td rowspan="'.strval($housing_count+1).'">'.$fres[$i]['housing'].'</td>';
				}
				elseif($housing_count>0)
				{
					$housing_count = $housing_count-1;
				}
				//Вывод кабинета
				if($cabinet_count == 0) 
				{
					for($j = $i+1; $j<count($fres); $j++)
					{
						if($fres[$i]['cabinet'] == $fres[$j]['cabinet'])
						{
							$cabinet_count = $cabinet_count + 1; 
						}
						else
						{
							break;
						}
					}
					
					echo '<td rowspan="'.strval($cabinet_count+1).'">'.$fres[$i]['cabinet'].'</td>';
				}
				elseif($cabinet_count>0)
				{
					$cabinet_count = $cabinet_count-1;
				}
			}
			}
		}
	}
}
echo '</tbody></table></center></body>';

?>