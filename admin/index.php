<?php 
require_once '../connect.php';

define('BASE_URL',   'http://zingmp3.tctruyen.com/admin/');
define('BASE_PUBLIC',   'http://zingmp3.tctruyen.com/public/');
define('BASE_UPLOAD',   'http://zingmp3.tctruyen.com/upload/');

?>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Admin Mp3 Zing</title>
		<link rel="stylesheet" href="<?php echo BASE_PUBLIC ?>roboto.css">
		<link rel="stylesheet" href="<?php echo BASE_PUBLIC ?>font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo BASE_PUBLIC ?>bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo BASE_PUBLIC?>datatable/css/dataTables.bootstrap.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo BASE_PUBLIC ?>style.css">
		
		<script src="<?php echo BASE_PUBLIC ?>jquery.js"></script>
		<script src="<?php echo BASE_PUBLIC ?>bootstrap.min.js"></script>

		<script src="<?php echo BASE_PUBLIC ?>datatable/js/jquery.dataTables.js"></script>
		<script src="<?php echo BASE_PUBLIC ?>datatable/js/dataTables.bootstrap.js"></script>
		<script src="<?php echo BASE_PUBLIC ?>custom.js"></script>
	</head>
	<body>
		<div class="header-bar">
			<h3 style="margin: 0 auto;
    text-align: center;
    padding-top: 7px;
">TRANG QUẢN TRỊ NHẠC NHÓM AN19</h3>


			

		</div>
		<div class='sidebar-left'>
			<h4 style='color: #848484;padding: 10px 25px 10px 15px;font-size: 12px;'>MAIN NAVIGATION</h4>
			<ul class='ul-control'>
				<li>
					<a href="<?php echo BASE_URL ?>?pages=quangcao" class='<?php echo @$_GET['pages']=='quangcao'?'active':''; ?>' >
						<i class='fa fa-tags'></i>
						<label>Quảng Cáo</label>
					</a>
				</li>
				<li>
					<a href="<?php echo BASE_URL ?>?pages=album" class='<?php echo @$_GET['pages']=='album'?'active':''; ?>' >
						<i class='fa fa-tags'></i>
						<label>Album</label>
					</a>
				</li>
				<li>
					<a href="<?php echo BASE_URL ?>?pages=baihat" class='<?php echo @$_GET['pages']=='baihat'?'active':''; ?>' >
						<i class='fa fa-tags'></i>
						<label>Bài Hát</label>
					</a>
				</li>
				<li>
					<a href="<?php echo BASE_URL ?>?pages=chude" class='<?php echo @$_GET['pages']=='chude'?'active':''; ?>' >
						<i class='fa fa-tags'></i>
						<label>Chủ Đề</label>
					</a>
				</li>
				<li>
					<a href="<?php echo BASE_URL ?>?pages=playlist" class='<?php echo @$_GET['pages']=='playlist'?'active':''; ?>' >
						<i class='fa fa-tags'></i>
						<label>Playlist</label>
					</a>
				</li>

				<li>
					<a href="<?php echo BASE_URL ?>?pages=theloai" class='<?php echo @$_GET['pages']=='theloai'?'active':''; ?>' >
						<i class='fa fa-tags'></i>
						<label>Thể Loại</label>
					</a>
				</li>				
			</ul>
		</div>
		<div class='wrapper'>
			<?php 
				if(@$_GET['pages']){
					include '../pages/'.$_GET['pages'].'.php';					
				}else{
					include '../pages/home.php';
				}
			?>
			
		</div>
	</body>	
</html>