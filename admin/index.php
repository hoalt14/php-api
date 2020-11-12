<?php
require_once '../connect.php';

define('BASE_URL', 'http://room.rent.com/admin/');
define('BASE_PUBLIC', 'http://room.rent.com/public/');
define('BASE_UPLOAD', 'http://room.rent.com/upload/');

?>

<html lang="">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>

	<link rel="stylesheet" href="<?php echo BASE_PUBLIC ?>roboto.css">
	<link rel="stylesheet" href="<?php echo BASE_PUBLIC ?>font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo BASE_PUBLIC ?>bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo BASE_PUBLIC ?>datatable/css/dataTables.bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo BASE_PUBLIC ?>style.css">

	<script src="<?php echo BASE_PUBLIC ?>jquery.js"></script>
	<script src="<?php echo BASE_PUBLIC ?>bootstrap.min.js"></script>
	<script src="<?php echo BASE_PUBLIC ?>datatable/js/jquery.dataTables.js"></script>
	<script src="<?php echo BASE_PUBLIC ?>datatable/js/dataTables.bootstrap.js"></script>
	<script src="<?php echo BASE_PUBLIC ?>custom.js"></script>
</head>

<body>
	<div class="header-bar">
		<h3 style="margin: 0 auto; text-align: center; padding-top: 7px;">Administrator Management Page</h3>
	</div>
	<div class='sidebar-left'>
		<h4 style='color: #848484;padding: 10px 25px 10px 15px;font-size: 12px;'>MAIN NAVIGATION</h4>
		<ul class='ul-control'>
			<li>
				<a href="<?php echo BASE_URL ?>?pages=room" class='<?php echo @$_GET['pages'] == 'room' ? 'active' : ''; ?>'>
					<i class='fa fa-tags'></i>
					<label>Room</label>
				</a>
			</li>
			<li>
				<a href="<?php echo BASE_URL ?>?pages=rent" class='<?php echo @$_GET['pages'] == 'rent' ? 'active' : ''; ?>'>
					<i class='fa fa-tags'></i>
					<label>Rent</label>
				</a>
			</li>
		</ul>
	</div>
	<div class='wrapper'>
		<?php
		if (@$_GET['pages']) {
			include '../pages/' . $_GET['pages'] . '.php';
		} else {
			include '../pages/home.php';
		}
		?>
	</div>
</body>

</html>