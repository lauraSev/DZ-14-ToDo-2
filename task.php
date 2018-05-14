<?php
include ('login.php');
$oLogin = new Login();
if ($oLogin->getUserId()+0==0){
header ("Location: index.php");
exit();
}
include ('connect.php');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>ToDo</title>
</head>

<body>
<?php
if (isset($_GET['action'])) {
    if ($_GET ['action'] == 'add') {
        $query = "INSERT INTO tasks SET 
				description = '" . $_REQUEST['description'] . "',
				user_id = '".$oLogin->getUserId(). "',
				created_by = '".$oLogin->getUserId(). "',
				date_added = NOW()
				";
        $res = $dbh->query($query);
		//print_r($dbh->errorInfo());
    }
    if ($_GET ['action'] == 'done') {
        $query = "UPDATE tasks SET 
				is_done = 1
				WHERE id = '" . $_REQUEST['id'] . "'
			";
        $res = $dbh->query($query);
    }
    if ($_GET ['action'] == 'del') {
        $query = "DELETE FROM tasks 
				WHERE id = '" . $_REQUEST['id'] . "'
			";
        $res = $dbh->query($query);
    }
	if ($_GET ['action'] == 'worker') {
        $query = "UPDATE tasks SET 
				user_id = '" . $_REQUEST['worker'] . "'
				WHERE id = '" . $_REQUEST['id'] . "'
			";
        $res = $dbh->query($query);
    }
}
?>
<form action="task.php?action=add" method="post">
    <p><input type="text" name="description"
              value="<?= isset ($_REQUEST['description']) ? $_REQUEST['description'] : '' ?>"
              placeholder="Описание задачи"><input type="submit" value="Добавить" name="btn"></p>
</form>
<p><a href="?filter=owner">Созданные мной задачи</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?filter=me">Поставленные на меня задачи</a></p>
<table border="1" width="100%">
    <thead>
    <tr>
        <th>Описание задачи</th>
        <th>Дата добавления</th>
        <th>Статус</th>
        <th>Исполнитель</th>
        <th>Назначить</th>
        <th colspan="2">&nbsp;</th>
    </tr>
    </thead>
    <pre>
<?php
$where = '';
if (isset($_REQUEST['filter']) && $_REQUEST['filter']=='me'){
	$where = "AND tasks.user_id=".$oLogin->getUserId();
}
if(isset($_REQUEST['filter'])&& $_REQUEST['filter']=='owner'){
	$where = "AND tasks.created_by=".$oLogin->getUserId();
}
$res = $dbh->query("SELECT 
					tasks.description,
					tasks.date_added,
					tasks.is_done,
					tasks.id,
					users.name
					FROM tasks,users
					WHERE
					tasks.user_id = users.id
					$where
					");
//print_r($dbh->errorInfo());
$allusers = "";
foreach ($oLogin->getAllUsers() as $user){
	$allusers.='<option value="'.$user['id'].'">'.$user['name'].'</option>';	
}
foreach ($res as $row) {
	//echo '<pre>'.print_r($row,true).'</pre>';
    ?>
    <tbody>
      <tr>
        <td><?= $row['description'] ?></td>
        <td><?= $row['date_added'] ?></td>
        <td><?= $row['is_done'] == 0 ? 'Не выполнено' : 'Выполнено' ?></td>
        <td><?= $row['name'] ?></td>
        <td>
        	<select name="worker" onChange="document.location='?action=worker&id=<?=$row['id']?>&worker='+this.value">
            <option></option>
            	<?=$allusers?> 
            </select>
        </td>
        <td><a href="task.php?action=done&id=<?= $row['id'] ?>">Завершить</a></td>
        <td><a href="task.php?action=del&id=<?= $row['id'] ?>">Удалить</a></td>
      </tr>
    </tbody>

    <?php
}
?>
</table>
</body>
</html>

