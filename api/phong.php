<?php
require_once '../connect.php';

if (@$_GET['MaPhong']) {
	$sql = "SELECT * FROM phong WHERE MaPhong = " . $_GET['MaPhong'];
} else {
	if ($_GET['type'] == 'hot') {
		$limit = @$_GET['limit'] ?: 6;
		$where = array();
		if ($_GET['TenPhong']) $where[] = "TenPhong LIKE '%" . $_GET['TenPhong'] . "%'";
		if ($_GET['GiaPhong']) $where[] = "GiaPhong LIKE '%" . $_GET['GiaPhong'] . "%'";
		if ($_GET['TinhTrang']) $where[] = "TenPhong LIKE '%" . $_GET['TinhTrang'] . "%'";
		if (count($where) > 0) $where = "WHERE " . implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM PHONG $where LIMIT $limit";
	} else {
		$where = array();
		if ($_GET['TenPhong']) $where[] = "TenPhong LIKE '%" . $_GET['TenPhong'] . "%'";
		if ($_GET['GiaPhong']) $where[] = "GiaPhong LIKE '%" . $_GET['GiaPhong'] . "%'";
		if ($_GET['TinhTrang']) $where[] = "TenPhong LIKE '%" . $_GET['TinhTrang'] . "%'";
		if (count($where) > 0) $where = "WHERE " . implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM PHONG $where";
	}
}


$data = mysqli_query($conn, $sql);


$arrData = array();
while ($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'MaPhong' => $row['MaPhong'],
		'TenPhong' => $row['TenPhong'],
		'GiaPhong' => $row['GiaPhong'],
		'TinhTrang' => $row['TinhTrang'],
		'HinhPhong' => BASE_UPLOAD . "phong/" . $row['HinhPhong'],
	);
}
echo json_encode($arrData);
mysqli_close($conn);
