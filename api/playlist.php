<?php 
require_once '../connect.php';

if(@$_GET['idPlayList']){
	$sql = "SELECT * FROM playlist WHERE idPlayList = ".$_GET['idPlayList'];
}else{
	if($_GET['type'] == 'hot'){
		$limit = @$_GET['limit']?:6;
		$where = array();
		if($_GET['tenPlayList']) $where[] = "tenPlayList LIKE '%".$_GET['tenPlayList']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM playlist $where ORDER BY rand() LIMIT $limit";
	}else{
		$where = array();
		if($_GET['tenPlayList']) $where[] = "tenPlayList LIKE '%".$_GET['tenPlayList']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM playlist $where";
	}
	
}

$data = mysqli_query($conn, $sql);


$arrData = array();
while($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'idPlayList'   => $row['idPlayList'],
		'tenPlayList'  => $row['tenPlayList'],
		'hinhPlayList' => BASE_UPLOAD."playlist/".$row['hinhPlayList'],
		'iconPlayList' => BASE_UPLOAD."playlist.jpg",
	);
}

echo json_encode($arrData);
mysqli_close($conn);


?>