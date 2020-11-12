<?php
require_once '../connect.php';

if (@$_GET['MaPhieuThue']) {
	$sql = "SELECT * FROM PHIEUTHUE WHERE MaPhieuThue = " . $_GET['MaPhieuThue'];
} else {
	if ($_GET['type'] == 'hot') {
		$limit = @$_GET['limit'] ?: 6;
		$where = array();
		if ($_GET['TenPhieuThue']) $where[] = "TenPhieuThue LIKE '%" . $_GET['TenPhieuThue'] . "%'";
		if ($_GET['GiaPhong']) $where[] = "GiaPhong LIKE '%" . $_GET['GiaPhong'] . "%'";
		if ($_GET['TinhTrang']) $where[] = "TenPhieuThue LIKE '%" . $_GET['TinhTrang'] . "%'";
		if (count($where) > 0) $where = "WHERE " . implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM PHONG $where LIMIT $limit";
	} else {
		$where = array();
		if ($_GET['TenPhieuThue']) $where[] = "TenPhieuThue LIKE '%" . $_GET['TenPhieuThue'] . "%'";
		if ($_GET['GiaPhong']) $where[] = "GiaPhong LIKE '%" . $_GET['GiaPhong'] . "%'";
		if ($_GET['TinhTrang']) $where[] = "TenPhieuThue LIKE '%" . $_GET['TinhTrang'] . "%'";
		if (count($where) > 0) $where = "WHERE " . implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM PHONG $where";
	}
}


$data = mysqli_query($conn, $sql);


$arrData = array();
while ($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'MaPhieuThue' => $row['MaPhieuThue'],
		'TenPhieuThue' => $row['TenPhieuThue'],
		'GiaPhong' => $row['GiaPhong'],
		'TinhTrang' => $row['TinhTrang'],
		'HinhPhong' => BASE_UPLOAD . "phong/" . $row['HinhPhong'],
	);
}
echo json_encode($arrData);
mysqli_close($conn);
