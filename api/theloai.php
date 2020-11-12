<?php 
require_once '../connect.php';

//$sql = "SELECT *, b.tenChuDe FROM theloai a left join chude b on a.idChuDe = b.idChuDe";

if(@$_GET['idTheLoai']){
	$sql = "SELECT *, b.tenChuDe FROM theloai a left join chude b on a.idChuDe = b.idChuDe WHERE idTheLoai = ".$_GET['idTheLoai'];
}else{
	if($_GET['type'] == 'hot'){
		$where = array();
		if($_GET['tenTheLoai']) $where[] = "tenTheLoai LIKE '%".$_GET['tenTheLoai']."%'";
		if($_GET['tenChuDe']) $where[] = "b.tenChuDe LIKE '%".$_GET['tenChuDe']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT *, b.tenChuDe FROM theloai a left join chude b on a.idChuDe = b.idChuDe $where LIMIT $limit";
	}elseif($_GET['type'] == 'chude'){
		$where = array();
		if($_GET['tenTheLoai']) $where[] = "tenTheLoai LIKE '%".$_GET['tenTheLoai']."%'";
		if($_GET['tenChuDe']) $where[] = "b.tenChuDe LIKE '%".$_GET['tenChuDe']."%'";

		$idChuDe = $_GET['idChuDe']?:-1;
		$where[] = "a.idChuDe = $idChuDe";

		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT *, b.tenChuDe FROM theloai a left join chude b on a.idChuDe = b.idChuDe $where";
	}else{
		$where = array();
		if($_GET['tenTheLoai']) $where[] = "tenTheLoai LIKE '%".$_GET['tenTheLoai']."%'";
		if($_GET['tenChuDe']) $where[] = "b.tenChuDe LIKE '%".$_GET['tenChuDe']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT *, b.tenChuDe FROM theloai a left join chude b on a.idChuDe = b.idChuDe $where";
	}
	
}

$data = mysqli_query($conn, $sql);


$arrData = array();
while($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'idTheLoai'   => $row['idTheLoai'],		
		'tenTheLoai'  => $row['tenTheLoai'],
		'idChuDe'     => $row['idChuDe'],
		'tenChuDe'    => $row['tenChuDe'],
		'hinhTheLoai' => BASE_UPLOAD."theloai/".$row['hinhTheLoai'],
	);
}

echo json_encode($arrData);
mysqli_close($conn);


?>