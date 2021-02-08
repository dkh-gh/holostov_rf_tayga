
<?php $version="0.2.1"; ?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="utf-8">
		
		<title>Тайга</title>
		
		<link rel="stylesheet" href="style.css">
		
	</head>
	
	<script>
		
		document.addEventListener("DOMContentLoaded", function() {
			document.getElementById("authProg").addEventListener("click", function() {
				win = window.open("user.php", "Вход в систему", "menubar=no,location=no,resizable=no,scrollbars=yes,status=no,width=400,height=600");
				
			});
		});
		
	</script>
	
	<body>
		
		<div class="doc">
			
			<h1 class="header">ТАЙГА <? echo $version ?></h1>
			
			<div class="page">
				
				<div class="slot">
					<div class="part3_4">
						<p>Система поуровневого оценивания умений и знаний "Тайга".</p>
						<p>На данный момент система находится на первых этапах её разработки, и загрузка материалов недоступна.</p>
					</div>
					<div class="part1_4">
						<div class="btn">ЗАГРУЗИТЬ</div>
					</div>
				</div>
				
				<div class="hr"></div>
				
				<div class="slot">
					<div class="part3_4">
						<p>Адаптация системы "Тайга" к урокам по программированию.</p>
						<p>Войдите что бы просмотреть доступные задания и информацию о своём уровне.</p>
					</div>
					<div class="part1_4">
						<div class="btn" id="authProg">ВОЙТИ</div>
					</div>
				</div>
				
				<div class="hr"></div>
				
				<div class="slot">
					<p>По всем вопросам и предложениям обращаться на почту dkh@ro.ru.</p>
				</div>
				
			</div>
			
		</div>
		
	</body>
	
</html>
