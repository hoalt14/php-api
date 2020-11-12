<?php
require_once '../connect.php';

define('BASE_URL', 'http://testphp.newpinetech.com/admin/');
define('BASE_PUBLIC', 'http://testphp.newpinetech.com/public/');
define('BASE_UPLOAD', 'http://testphp.newpinetech.com/upload/');

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
		<h3 style="margin: 0 auto; text-align: center; padding-top: 7px;">TRANG QUẢN TRỊ ỨNG DỤNG</h3>
	</div>
	<div class='sidebar-left'>
		<h4 style='color: #848484;padding: 10px 25px 10px 15px;font-size: 12px;'>MAIN NAVIGATION</h4>
		<ul class='ul-control'>
			<li>
				<a href="<?php echo BASE_URL ?>?pages=phong" class='<?php echo @$_GET['pages'] == 'phong' ? 'active' : ''; ?>'>
					<i class='fa fa-tags'></i>
					<label>Phòng</label>
				</a>
			</li>
			<li>
				<a href="<?php echo BASE_URL ?>?pages=phieuthue" class='<?php echo @$_GET['pages'] == 'phieuthue' ? 'active' : ''; ?>'>
					<i class='fa fa-tags'></i>
					<label>Phiếu thuê</label>
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