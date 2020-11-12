<?php
require_once '../connect.php';

if (@$_GET['roomID']) {
	$sql = "SELECT * FROM ROOM WHERE roomID = " . $_GET['roomID'];
} else {
	if ($_GET['type'] == 'rent') {
		$limit = @$_GET['limit'] ?: 6;
		$where = array();
		if ($_GET['roomName']) $where[] = "roomName LIKE '%" . $_GET['roomName'] . "%'";
		if ($_GET['roomPrice']) $where[] = "roomPrice LIKE '%" . $_GET['roomPrice'] . "%'";
		if ($_GET['roomStatus']) $where[] = "roomStatus LIKE '%" . $_GET['roomStatus'] . "%'";
		if (count($where) > 0) $where = "WHERE " . implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM ROOM $where LIMIT $limit";
	} else {
		$where = array();
		if ($_GET['roomName']) $where[] = "roomName LIKE '%" . $_GET['roomName'] . "%'";
		if ($_GET['roomPrice']) $where[] = "roomPrice LIKE '%" . $_GET['roomPrice'] . "%'";
		if ($_GET['roomStatus']) $where[] = "roomStatus LIKE '%" . $_GET['roomStatus'] . "%'";
		if (count($where) > 0) $where = "WHERE " . implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM ROOM $where";
	}
}


$data = mysqli_query($conn, $sql);


$arrData = array();
while ($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'roomID' => $row['roomID'],
		'roomName' => $row['roomName'],
		'roomPrice' => $row['roomPrice'],
		'roomStatus' => $row['roomStatus'],
		'roomPicture' => BASE_UPLOAD . "ROOM/" . $row['roomPicture'],
	);
}
echo json_encode($arrData);
mysqli_close($conn);