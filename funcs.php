
<?php
	
	$version='0.3';
	
	$link;
	$userData;
	$page = 'main';
	
	function dbConnect() {
		global $link;
		
		$link = mysqli_connect("XXX", "XXX", "XXX", "XXX");
		
		mysqli_query($link, "SET NAMES 'utf8';");
		mysqli_query($link, "SET CHARACTER SET 'utf8';");
		mysqli_query($link, "SET SESSION collation_connection = 'utf8_general_ci';");
		
	}
	function dbDisconnect() {
		global $link;
		mysqli_close($link);
	}
	function get($cmd) {
		$ret = "[нет такой команды]";
		
		if($cmd == 'user') {
            if($_GET['login'] != '') {
                $res = query("SELECT * FROM users_prog WHERE `nick`='".$_GET['login']."'");
                $user = mysqli_fetch_array($res);
                if(mysqli_num_rows($res) == 0 || ($user['pass'] != $_GET['pass'])) {
                    redirect("exit");
                    $user = false;
                }
                $ret = $user;
            }
            else $ret = false;
			
		}
		return $ret;
	}
	function query($ask) {
		global $link;
		dbConnect();
		$res = mysqli_query($link, $ask);
		dbDisconnect();
		return $res;
	}
	
	function redirect($way) {
		if($way=="back") echo '<script>history.back()</script>';
		elseif($way=="exit") echo '<script>window.location="?login="</script>';
		else echo '<script>window.location="?login='.$_GET['login'].'&pass='.$_GET['pass'].'&page='.$way.'"</script>';
	}
	
	function addBtn($name, $href) {
		echo '<a href="?login='.$_GET['login'].'&pass='.$_GET['pass'].'&page='.$href.'"><div class="btn" id="loginButton">'.$name.'</div></a>';
	}
	
	function formuleES($dm, $dl, $mu) {
		$es = ( $dm*.08 + $dl*.02  ) * $mu;
		return $es;
	}
	function formuleLVL($sc) {
		$lvl = (int)(sqrt($sc));
		return $lvl;
	}
	
	function login() {
		$ret = false;
		if($_GET["login"] != "") {
			
		}
	}
	
	function html($param, $append0) {
        global $version, $userData, $page;
        if($param == "block") {
            echo '
				<div class="slot auth">
					<p>'.$append0.'</p>
				</div>
				';
        }
        if($param == "start") {
            echo '
<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="utf-8">
		
		<title>Тайга</title>
		
		<link rel="stylesheet" href="style.css">
		
	</head>
	
	<body>
		
		<div class="doc auth">
			
			<h1 class="header">ТАЙГА '.$version.'</h1>
			
			<div class="page auth">
			';
        }
        if($param == "end") {
            echo '
				
				<div class="hr"></div>
				
				<div class="slot auth">
					<p>По всем вопросам и предложениям обращаться на почту dkh@ro.ru.</p>
				</div>
				
			</div>
			
		</div>
		
	</body>
	
</html>
';
        }
        if($param == "startBlock") {
            echo '
                <div class="slot auth">
                    ';
        }
        if($param == "endBlock") {
            echo '
                </div>
                ';
        }
        if($param == "loginForm") {
            echo '
				<div class="slot auth">
					<div class="part3_4 auth">
						<p>Адаптация системы "Тайга" к урокам по программированию.</p>
						<p>Для входа запоните данные ниже:</p>
					</div>
					<div class="part1_4 auth">
						<input type="text" id="login" placeholder="Логин (Ник)">
						<input type="password" id="password" placeholder="Пароль">
						<div class="btn" id="loginButton">ВОЙТИ</div>
						<script>
							document.addEventListener("DOMContentLoaded", function() {
								document.getElementById("loginButton").addEventListener("click", function() {
									lgn = document.getElementById("login").value;
									pswd = document.getElementById("password").value;
									if(lgn != "" && pswd != "") window.location="?login="+lgn+"&pass="+pswd;
								});
							});
						</script>
					</div>
				</div>
				
				<div class="hr"></div>
				
				<div class="slot auth">
				';
        }
        if($param == "hello") {
            $userData = get('user');
            html("block", "Добро пожаловать, ".$userData['name'].".");
        }
        if($param == "menu") {
            
            if($userData['AL'] <= 0 && $page == "main") {
                addBtn("!ВЫПОЛНЕНО ЗАДАНИЕ", "taskend");
                addBtn("!СПИСОК ПОЛЬЗОВАТЕЛЕЙ", "users");
                addBtn("!ДОБАВИТЬ ПОЛЬЗОВАТЕЛЯ", "adduser");
                addBtn("!ДОБАВИТЬ ЗАДАНИЕ", "addtask");
                addBtn("!СПИСОК ПОЛЬЗОВАТЕЛЕЙ", "users");
            }
            if($userData['AL'] <= 0 && $page == "main") {
                addBtn("!ЗАДАНИЯ", "tasks");
                addBtn("!ПРОФИЛЬ ПОЛЬЗОВАТЕЛЯ", "user");
                addBtn("!РЕЙТИНГ ПОЛЬЗОВАТЕЛЕЙ", "ranking");
                addBtn("!СМЕНИТЬ ПАРОЛЬ", "newpass");
            }
            
            addBtn("!ВЫХОД", "exit");
            
        }
	}
	
?>
