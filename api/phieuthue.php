<?php
require_once '../connect.php';

if (@$_GET['MaPhieuThue']) {
	$sql = "SELECT * FROM PHIEUTHUE WHERE MaPhieuThue = " . $_GET['MaPhieuThue'];
} else {
	if ($_GET['type'] == 'nhap') {
		$limit = @$_GET['limit'] ?: 6;
		$where = array();
		if ($_GET['TenPhieuThue']) $where[] = "TenPhieuThue LIKE '%" . $_GET['TenPhieuThue'] . "%'";
		if ($_GET['NgayThue']) $where[] = "NgayThue LIKE '%" . $_GET['NgayThue'] . "%'";
		if ($_GET['NgayTra']) $where[] = "NgayTra LIKE '%" . $_GET['NgayTra'] . "%'";
		if ($_GET['MaNguoiThue']) $where[] = "MaNguoiThue LIKE '%" . $_GET['MaNguoiThue'] . "%'";
		if ($_GET['MaPhong']) $where[] = "MaPhong LIKE '%" . $_GET['MaPhong'] . "%'";
		if (count($where) > 0) $where = "WHERE " . implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM PHIEUTHUE $where LIMIT $limit";
	} else {
		$where = array();
		if ($_GET['TenPhieuThue']) $where[] = "TenPhieuThue LIKE '%" . $_GET['TenPhieuThue'] . "%'";
		if ($_GET['NgayThue']) $where[] = "NgayThue LIKE '%" . $_GET['NgayThue'] . "%'";
		if ($_GET['NgayTra']) $where[] = "NgayTra LIKE '%" . $_GET['NgayTra'] . "%'";
		if ($_GET['MaNguoiThue']) $where[] = "MaNguoiThue LIKE '%" . $_GET['MaNguoiThue'] . "%'";
		if ($_GET['MaPhong']) $where[] = "MaPhong LIKE '%" . $_GET['MaPhong'] . "%'";
		if (count($where) > 0) $where = "WHERE " . implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM PHIEUTHUE $where";
	}
}


$data = mysqli_query($conn, $sql);


$arrData = array();
while ($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'MaPhieuThue' => $row['MaPhieuThue'],
		'TenPhieuThue' => $row['TenPhieuThue'],
		'NgayThue' => $row['NgayThue'],
		'NgayTra' => $row['NgayTra'],
		'MaNguoiThue' => $row['MaNguoiThue'],
		'MaPhong' => $row['MaPhong'],
	);
}
echo json_encode($arrData);
mysqli_close($conn);
