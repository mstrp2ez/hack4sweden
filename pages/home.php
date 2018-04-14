<?php

$content=file_get_contents('http://hack4sweden.vwc.se/rest/list');
$content=json_decode($content);
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="pages/css/main.css">
</head>
<body>

<div class="site">
	<div class="header">
		<ul class="nav-list">
			<li><a href="#" onclick="showReg();">Registered people</a></li>
			<li><a href="#" onclick="showRoles();">Roles</a></li>
		</ul>
	</div>
	<div class="content">
		<?php
		foreach($content as $item){
		?>
		<div class="container">
			<h3><?=$item->first_name.' '.$item->second_name;?></h3>
			<ul>
				<li><b>Phone number:</b> <?=$item->phone_number;?></li>
				<li><b>Email:</b> <?=$item->email;?></li>
				<li><b>Notes:</b> <?=$item->notes;?></li>
				<li><p>Roles:</p><ul>
				<?php foreach($item->roles as $role){ 
					if($role->active){?>
					<li><?=$role->name;?></li>
					<?php } ?>
				<?php } ?>
				</ul></li>
			</ul>
		</div>
		<?php
		}
		?>
	</div>
	<div class="footer">
	</div>
</div>

</body>
</html>