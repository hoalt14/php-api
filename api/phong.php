<?php 
require_once '../connect.php';

if(@$_GET['MaPhong']){
	$sql = "SELECT * FROM PHONG WHERE MaPhong = ".$_GET['MaPhong'];
}else{
	if($_GET['type'] == 'trong'){
		$limit = @$_GET['limit']?:6;
		$where = array();
		if($_GET['TenPhong']) $where[] = "TenPhong LIKE '%".$_GET['TenPhong']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM PHONG $where ORDER BY rand() LIMIT $limit";
	}else{
		$where = array();
		if($_GET['TenPhong']) $where[] = "TenPhong LIKE '%".$_GET['TenPhong']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM PHONG $where";
	}
	
}

$data = mysqli_query($conn, $sql);


$arrData = array();
while($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'MaPhong'   => $row['MaPhong'],
		'TenPhong'  => $row['TenPhong'],
	);
}

echo json_encode($arrData);
mysqli_close($conn);


?>