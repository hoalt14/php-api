<?php
require_once '../connect.php';


if (@$_GET['idQuangCao']) {
	$sql = "SELECT qc.*,bh.tenBaiHat,bh.hinhBaiHat
		FROM quangcao qc
		LEFT JOIN baihat bh ON qc.idBaiHat = bh.idBaiHat
		WHERE qc.idQuangCao = " . $_GET['idQuangCao'];
} else {
	$where = array();
	if ($_GET['tenBaiHat'] && !empty($_GET['tenBaiHat'])) $where[] = "bh.tenBaiHat = '" . $_GET['tenBaiHat'] . "'";
	if (count($where) > 0) $where = "WHERE " . implode(' AND ', $where);
	else $where = '';

	$sql = "SELECT qc.*,bh.tenBaiHat,bh.hinhBaiHat
		FROM quangcao qc
		LEFT JOIN baihat bh ON qc.idBaiHat = bh.idBaiHat
		 $where";
}

$data = mysqli_query($conn, $sql);


$arrData = array();
while ($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'idQuangCao'      => $row['idQuangCao'],
		'noiDungQuangCao' => $row['noiDungQuangCao'],
		'hinhQuangCao'    => BASE_UPLOAD . "quangcao/" . $row['hinhQuangCao'],
		'idBaiHat'        => $row['idBaiHat'],
		'tenBaiHat'       => $row['tenBaiHat'],
		'hinhBaiHat'      => BASE_UPLOAD . "baihat/" . $row['hinhBaiHat'],
	);
}
echo json_encode($arrData);
mysqli_close($conn);
