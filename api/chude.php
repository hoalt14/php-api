<?php 
require_once '../connect.php';

if(@$_GET['idChuDe']){
	$sql = "SELECT * FROM chude WHERE idChuDe = ".$_GET['idChuDe'];
}else{
	if($_GET['type'] == 'hot'){
		$limit = @$_GET['limit']?:6;
		$where = array();
		if($_GET['tenChuDe']) $where[] = "tenChuDe LIKE '%".$_GET['tenChuDe']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM chude $where LIMIT $limit";
	}else{
		$where = array();
		if($_GET['tenChuDe']) $where[] = "tenChuDe LIKE '%".$_GET['tenChuDe']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM chude $where";
	}	

	
}


$data = mysqli_query($conn, $sql);


$arrData = array();
while($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'idChuDe' => $row['idChuDe'],
		'tenChuDe' => $row['tenChuDe'],
		'hinhChuDe' => BASE_UPLOAD."chude/".$row['hinhChuDe'],
	);
}
echo json_encode($arrData);
mysqli_close($conn);


?>