
<?php
	$debug = true;
	include 'funcs.php';
?>

				<?php
					
					if($_GET["login"] == "") {
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
					else {
						
						$user = get("user");
						
						//else {
							
							echo '
							<div class="slot auth">
								<div class="part3_4 auth">
									<p>Адаптация системы "Тайга" к урокам по программированию.</p>
									<p>Вы вошли как '.$user['name'].'.</p>
								</div>
								<div class="part1_4 auth">
									<div class="btn" id="loginButton">ВЫЙТИ</div>
									<script>
										document.addEventListener("DOMContentLoaded", function() {
											document.getElementById("loginButton").addEventListener("click", function() {window.location="?";});
										});
									</script>
								</div>
							</div>
							
							<div class="hr"></div>
							
							<div class="slot auth">
							';
						
						
							if($user['AL'] <= 0 && $_GET['page'] == "") {
								addBtn("ВЫПОЛНЕНО ЗАДАНИЕ", "taskend");
								addBtn("СПИСОК ПОЛЬЗОВАТЕЛЕЙ", "users");
								addBtn("ДОБАВИТЬ ПОЛЬЗОВАТЕЛЯ", "adduser");
								addBtn("ДОБАВИТЬ ЗАДАНИЕ", "addtask");
								addBtn("СПИСОК ПОЛЬЗОВАТЕЛЕЙ", "users");
							}
							if($user['AL'] <= 1 && $_GET['page'] == "") {
								addBtn("ЗАДАНИЯ", "tasks");
								addBtn("ПРОФИЛЬ ПОЛЬЗОВАТЕЛЯ", "user");
								addBtn("РЕЙТИНГ ПОЛЬЗОВАТЕЛЕЙ", "ranking");
								addBtn("СМЕНИТЬ ПАРОЛЬ", "newpass");
							}
							
							if($_GET['page'] != "") addBtn("НА ГЛАВНУЮ", "");
							
							if($_GET['page']=="users" && $user['AL'] <= 0) {
								startBlock();
								echo "Список всех пользователей:<br><br><table border=1 width=100%>
								<tr style=\"background-color:#ccc\"><td>Имя</td><td>Ник</td><td>AL</td></tr>
								";
								$res = query("SELECT * FROM users_prog");
								while($row = mysqli_fetch_array($res)) {
									echo "<tr><td>".$row['name']."</td><td>".$row['nick']."</td><td>".$row['AL']."</td></tr>
									";
								}
								echo "</table>";
								endBlock();
							}
							if($_GET['page']=="user") {
								startBlock();
								
								$sc = 0;
								$i = 0;
								$res = query("SELECT * FROM task_prog");
								while($row = mysqli_fetch_array($res)) {
									if($user['t'.$i] == '1') {
										$sc += formuleES($row['DM'], $row['DL'], $row['MU']);
									}
									$i++;
								}
								
								echo "<p>Профиль пользователя:<br><br>
								Имя: ".$user['name']."<br>
								Ник: ".$user['nick']."<br>
								Уровень: ".formuleLVL($sc)." [очки: ".$sc."]
								</p>";
								
								endBlock();
							}
							if($_GET['page']=="tasks") {
								startBlock();
								echo "<script>tasks = [";
								$res = query("SELECT * FROM task_prog");
								while($row = mysqli_fetch_array($res)) {
									echo '['.formuleES($row['DM'], $row['DL'], $row['MU']).', "'.$row['id'].'", "'.$row['name'].'", "'.$row['text'].'", "'.$row['image'].'", "'.$row['themes'].'", "'.$row['langs'].'", "'.$row['DM'].'", "'.$row['DL'].'", "'.$row['MU'].'", "'.$row['author'].'", "'.$user['t'.$row['id']].'"],';
								}
								echo '[]];</script>
								<table border="1" width="100%" id="tasksTable">
								<tr style="background-color:#ccc"><td>СЛОЖНОСТЬ</td><td>НОМЕР</td><td>НАЗВАНИЕ ЗАДАЧИ</td></tr>
								<script>
								function sortFunction(a, b) {
										if (a[0] === b[0]) {
												return 0;
										}
										else {
												return (a[0] < b[0]) ? -1 : 1;
										}
								}
									function addTaskList(nk, ps) {
										tasks.splice(tasks.length-1, 1);
										tasks.sort(sortFunction);
										for(i = 0; i < tasks.length; i++) {
											color="#000";
											if(tasks[i][11]==1) color="#0a0";
											document.getElementById(\'tasksTable\').innerHTML += "<tr><td>"+tasks[i][0]+"</td><td>T"+tasks[i][1]+"</td><td><a href=\'?login="+nk+"&pass="+ps+"&page=taskview&param1="+tasks[i][1]+"\' style=\'color:"+color+";text-decoration:underline\'>"+tasks[i][2]+"</a></td></tr>";
										}
									}
									addTaskList("'.$_GET['login'].'", "'.$_GET['pass'].'");
								</script>
								</table>
								';
								endBlock();
							}
							if($_GET['page']=="adduser" && $user['AL'] <= 0) {
								startBlock();
								echo '<p>Создание пользователя:<br><br></p>
								<input type="text" id="lgn" placeholder="Логин (Ник)">
								<input type="pss" id="nm" placeholder="Имя"><br>
								<div class="btn" id="addUserButton">СОЗДАТЬ</div>
								<p></p>
								<script>
									document.addEventListener("DOMContentLoaded", function() {
										document.getElementById("addUserButton").addEventListener("click", function() {
											lgn = document.getElementById("lgn").value;
											nm = document.getElementById("nm").value;
											window.location="?login='.$_GET['login'].'&pass='.$_GET['pass'].'&page=adduserconf&param1="+lgn+"&param2="+nm;
										});
									});
								</script>
								';
								endBlock();
							}
								if($_GET['page']=="adduserconf" && $user['AL'] <= 0) {
									if(mysqli_num_rows(query("SELECT * FROM users_prog WHERE `nick`='".$_GET['param1']."'"))==0) {
									$res = query("SELECT * FROM users_prog");
									$id = mysqli_num_rows($res);
									$res = query("INSERT INTO users_prog (`id`, `name`, `nick`, `pass`, `AL`) VALUES ('".$id."', '".$_GET['param2']."', '".$_GET['param1']."', '123', 1)");
									echo '<p>ГОТОВО.</p>';
									redirect("users");
									}
									else {
										echo "Пользователь с таким логином уже существует.";
										addBtn("НАЗАД", "adduser");
									}
								}
							if($_GET['page']=="addtask" && $user['AL'] <= 0) {
								startBlock();
								echo '<p>Создание задания:<br><br></p>
								<input type="text" id="name" placeholder="Название">
								<input type="text" id="text" placeholder="Описание">
								<input type="text" id="imag" placeholder="Изображение">
								<input type="text" id="them" placeholder="Тематика">
								<input type="text" id="lang" placeholder="Языки">
								<input type="text" id="dm"   placeholder="ДМ (%)">
								<input type="text" id="dl"   placeholder="ДЛ (%)">
								<input type="text" id="mu"   placeholder="МУ (мин)">
								<input type="text" id="auth" placeholder="Автор">
								<div class="btn" id="addUserButton">СОЗДАТЬ</div>
								<p></p>
								<script>
									document.addEventListener("DOMContentLoaded", function() {
										document.getElementById("addUserButton").addEventListener("click", function() {
											p1 = document.getElementById("name").value;
											p2 = document.getElementById("text").value;
											p3 = document.getElementById("imag").value;
											p4 = document.getElementById("them").value;
											p5 = document.getElementById("lang").value;
											p6 = document.getElementById("dm").value;
											p7 = document.getElementById("dl").value;
											p8 = document.getElementById("mu").value;
											p9 = document.getElementById("auth").value;
											window.location="?login='.$_GET['login'].'&pass='.$_GET['pass'].'&page=addtaskconf&param1="+p1+"&param2="+p2+"&param3="+p3+"&param4="+p4+"&param5="+p5+"&param6="+p6+"&param7="+p7+"&param8="+p8+"&param9="+p9;
										});
									});
								</script>
								';
								endBlock();
							}
								if($_GET['page']=="addtaskconf" && $user['AL'] <= 0) {
									$res = query("SELECT * FROM task_prog");
									$id = mysqli_num_rows($res);
									$res = query("INSERT INTO task_prog (`id`, `name`, `text`, `image`, `themes`, `langs`, `DM`, `DL`, `MU`, `author`) VALUES ('".$id."', '".$_GET['param1']."', '".$_GET['param2']."', '".$_GET['param3']."', '".$_GET['param4']."', '".$_GET['param5']."', '".$_GET['param6']."', '".$_GET['param7']."', '".$_GET['param8']."', '".$_GET['param9']."')");
									$res = query("ALTER TABLE `users_prog` ADD `t".$id."` INT NOT NULL ;");
									echo '<p>ГОТОВО.</p>';
									redirect("tasks");
								}
							if($_GET['page']=="taskend" && $user['AL'] <= 0) {
								startBlock();
								echo '<p>Задание выполнил:<br><br></p>';
								$res = query("SELECT * FROM users_prog");
								echo '<select id="usr">';
								while($row = mysqli_fetch_array($res)) {
									echo "<option>".$row['name']."</option>";
								}
								echo "</select><br>";
								$res = query("SELECT * FROM task_prog");
								echo '<select id="tsk">';
								while($row = mysqli_fetch_array($res)) {
									echo "<option>t".$row['id']."</option>";
								}
								echo '</select><br>
								<div class="btn" id="endTaskButton">ВЫПОЛНИЛ</div>
								<p></p>
								<script>
									document.addEventListener("DOMContentLoaded", function() {
										document.getElementById("endTaskButton").addEventListener("click", function() {
											usr = document.getElementById("usr").value;
											tsk = document.getElementById("tsk").value;
											window.location="?login='.$_GET['login'].'&pass='.$_GET['pass'].'&page=taskendconf&param1="+usr+"&param2="+tsk;
										});
									});
								</script>
								';
								endBlock();
							}
								if($_GET['page']=="taskendconf" && $user['AL'] <= 0) {
									$res = query("SELECT * FROM users_prog");
									$id = mysqli_num_rows($res);
									$res = query("UPDATE users_prog SET `".$_GET['param2']."`='1' WHERE `name`='".$_GET['param1']."'");
									//echo "UPDATE users_prog SET `".$_GET['param2']."`='1' WHERE `name`='".$_GET['param1']."'";
									echo '<p>ГОТОВО.</p>';
									redirect("");
								}
							if($_GET['page']=="taskview") {
								startBlock();
									
									addBtn("К СПИСКУ ЗАДАЧ", "tasks");
									
									$res1 = query("SELECT * FROM task_prog WHERE id=".$_GET['param1']);
									$row1 = mysqli_fetch_array($res1);
									
									echo "<br>Название: ".$row1['name'].' (T'.$row1['id'].')';
									echo "<br><br>Тематика: ".$row1['themes'];
									echo "<br><br>Сложность: ".formuleES($row1['DM'], $row1['DL'], $row1['MU']);
									echo "<br><br>Рекомендуемые языки: ".$row1['langs'];
									echo "<br><br>Описание: ".$row1['text'];
									if($row1['image']!=none) echo "<br><br><img width='100%' height='auto' src='taskImage/".$row1['image']."'>";
									echo "<br><br>Автор: ".$row1['author'];
									
								endBlock();
							}
							if($_GET['page']=="newpass") {
								startBlock();
								echo '<p>Новый пароль:<br><br></p>
								<input type="text" id="pss" placeholder="Пароль">
								<br>
								<div class="btn" id="aplyPassButton">СОХРАНИТЬ</div>
								<p></p>
								<script>
									document.addEventListener("DOMContentLoaded", function() {
										document.getElementById("aplyPassButton").addEventListener("click", function() {
											pss = document.getElementById("pss").value;
											if(pss!="") window.location="?login='.$_GET['login'].'&pass='.$_GET['pass'].'&page=newpassconf&param1="+pss;
										});
									});
								</script>
								';
								endBlock();
							}
								if($_GET['page']=="newpassconf") {
									$res = query("UPDATE users_prog SET `pass`='".$_GET['param1']."' WHERE `id`='".$user['id']."'");
									//echo "UPDATE users_prog SET `".$_GET['param2']."`='1' WHERE `name`='".$_GET['param1']."'";
									echo '<p>ГОТОВО.</p>';
									redirect("exit");
								}
						//}
						if($_GET['page']=="ranking") {
							startBlock();
								echo '<p>Рейтинг пользователей:<br><br></p>
								<table border="1" width="100%" id="scoreTable">
									<tr style="background-color:#ccc"><td>ОЧКИ</td><td>ИМЯ [УРОВЕНЬ]</td></tr>
								</table>
								<script> users = [';
								$res1 = query("SELECT * FROM users_prog");
								while($row1 = mysqli_fetch_array($res1)) {
									if($row1['id']!='0') {
										$sc = 0;
										$i = 0;
										echo " [";
										$res = query("SELECT * FROM task_prog");
										while($row = mysqli_fetch_array($res)) {
											if($row1['t'.$i] == '1') {
												$sc += formuleES($row['DM'], $row['DL'], $row['MU']);
											}
											$i++;
										}
										echo $sc.', "'.$row1['name'].'", '.formuleLVL($sc).'], ';
									}
								}
								echo '[] ];
								function sortFunction2(a, b) {
										if (a[0] === b[0]) {
												return 0;
										}
										else {
												return (a[0] < b[0]) ? 1 : -1;
										}
								}
								users.splice(users.length-1, 1);
								users.sort(sortFunction2);
								function addScoreList() {
									//tasks.sort(sortFunction);
									for(i = 0; i < users.length; i++) {
										color="";
										if(i<3) color="#9f9";
										document.getElementById(\'scoreTable\').innerHTML += "<tr style=\"background-color:"+color+"\"><td>"+users[i][0]+"</td><td>"+users[i][1]+" ["+users[i][2]+"]</td></tr>";
									}
								}
								addScoreList();
								</script><br><br>
								';
							endBlock();
						}
						
					}
					
				?>
