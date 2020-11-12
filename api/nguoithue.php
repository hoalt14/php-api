<?php 
require_once '../connect.php';

if(@$_GET['MaNguoiThue']){
	$sql = "SELECT bh.*, ab.tenAlbum, tl.tenTheLoai, pl.tenPlayList
		FROM baihat bh
		LEFT JOIN album ab ON bh.idAlbum = ab.idAlbum
		LEFT JOIN theloai tl ON bh.idTheLoai = tl.idTheLoai
		LEFT JOIN playlist pl ON bh.idPlayList = pl.idPlayList 
		WHERE bh.idBaiHat = ".$_GET['idBaiHat'];
}else{
	$where = array();
	if($_GET['tenBaiHat'] && !empty($_GET['tenBaiHat'])) $where[] = "bh.tenBaiHat = '".$_GET['tenBaiHat']."'";
	if($_GET['caSi'] && !empty($_GET['caSi'])) $where[] = "caSi = '".$_GET['caSi']."'";
	if($_GET['tenTheLoai'] && !empty($_GET['tenTheLoai'])) $where[] = "tl.tenTheLoai = '".$_GET['tenTheLoai']."'";
	if($_GET['tenAlbum'] && !empty($_GET['tenAlbum'])) $where[] = "ab.tenAlbum = '".$_GET['tenAlbum']."'";
	if($_GET['tenPlayList'] && !empty($_GET['tenPlayList'])) $where[] = "pl.tenPlayList = '".$_GET['tenPlayList']."'";

	switch ($_GET['type']) {
		case 'album':
			$idAlbum = $_GET['idAlbum']?:-1;
			$where[] = "bh.idAlbum = $idAlbum";
			break;
		case 'theloai':
			$idTheLoai = $_GET['idTheLoai']?:-1;
			$where[] = "bh.idTheLoai = $idTheLoai";
			break;
		case 'playlist':
			$idPlayList = $_GET['idPlayList']?:-1;
			$where[] = "bh.idPlayList = $idPlayList";
			break;	
		case 'hot':
			$limit = @$_GET['limit']?:6;
			break;		
		default:
			
			break;
	}	

	if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
	else $where = '';

	$sql = "SELECT bh.*, ab.tenAlbum, tl.tenTheLoai, pl.tenPlayList
		FROM baihat bh
		LEFT JOIN album ab ON bh.idAlbum = ab.idAlbum
		LEFT JOIN theloai tl ON bh.idTheLoai = tl.idTheLoai
		LEFT JOIN playlist pl ON bh.idPlayList = pl.idPlayList 
		 $where";	
	if(@$limit) $sql.= " LIMIT $limit";	



	
}

$data = mysqli_query($conn, $sql);


$arrData = array();
while($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'idBaiHat'    => $row['idBaiHat'],		
		'idAlbum'     => $row['idAlbum'],
		'tenAlbum'    => $row['tenAlbum'],
		'idTheLoai'   => $row['idTheLoai'],
		'tenTheLoai'  => $row['tenTheLoai'],
		'idPlayList'  => $row['idPlayList'],
		'tenPlayList' => $row['tenPlayList'],
		'tenBaiHat'   => $row['tenBaiHat'],
		'caSi'        => $row['caSi'],
		'linkBaiHat'  => BASE_UPLOAD."file/".$row['linkBaiHat'],
		'loiBaiHat'   => $row['loiBaiHat'],
		'hinhBaiHat'  => BASE_UPLOAD."baihat/".$row['hinhBaiHat'],
	);
}
echo json_encode($arrData);
mysqli_close($conn);


?>