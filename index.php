<?php
	include ('login.php');
	$oLogin = new Login();
	
	if (isset ($_POST['send_reg'])){
		$result = $oLogin->registratsiya($_POST['login'], $_POST['pas'], $_POST['name'], $_POST['s_name'], $_POST['email']);
		if ($result["result"]){
			echo 'Вы зарегистрировались. <a href="index.php">Войти</a>';
			exit();	
		}
		else echo $result["message"];	
	}

	
	
	if (isset ($_POST['send_aut'])&& $_POST['login'] != ""){
		$result = $oLogin->avtorizatsiya($_POST['login'], $_POST['pas']);
		if ($result){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: task.php");
				exit();
		}
	}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
</head>

<body>
<table>
	<tr>
    	
    	<td valign="top">
        	<h3>Войти:</h3>
        	<form action="index.php" method="post">
                <input type="text" name="login" placeholder="введите логин"><br>
                <input type="password" name="pas" placeholder="введите пароль"><br>
                <input type="submit" name="send_aut" value="Войти"><br>
    		</form>
        </td>
        <td valign="top">
        	<h3>Зарегистрироваться:</h3>
        	<form action="index.php" method="post">
                <input type="text" name="login" placeholder="введите логин"><br>
                <input type="password" name="pas" placeholder="введите пароль"><br>
                <input type="text" name="name" placeholder="введите имя"><br>
                <input type="text" name="s_name" placeholder="введите фамилию"><br>
                <input type="text" name="email" placeholder="введите email"><br>
                <input type="submit" name="send_reg" value="Войти"><br>
    		</form>
        </td>
</table>



</body>
</html>
