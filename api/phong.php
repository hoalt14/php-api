<?php 
require_once '../connect.php';

if(@$_GET['']){
	$sql = "SELECT * FROM album WHERE idAlbum = ".$_GET['idAlbum'];
}else{
	if($_GET['type'] == 'hot'){
		$limit = @$_GET['limit']?:6;
		$where = array();
		if($_GET['tenAlbum']) $where[] = "tenAlbum LIKE'%".$_GET['tenAlbum']."%'";
		if($_GET['tenCaSiAlbum']) $where[] = "tenCaSiAlbumLIKE '%".$_GET['tenCaSiAlbum']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM album $where ORDER BY RAND () LIMIT $limit";
	}else{
		$where = array();
		if($_GET['tenAlbum']) $where[] = "tenAlbum LIKE'%".$_GET['tenAlbum']."%'";
		if($_GET['tenCaSiAlbum']) $where[] = "tenCaSiAlbumLIKE '%".$_GET['tenCaSiAlbum']."%'";
		if(count($where) > 0) $where = "WHERE " .implode(' AND ', $where);
		else $where = '';
		$sql = "SELECT * FROM album $where";
	}	
}

$data = mysqli_query($conn, $sql);
	

$arrData = array();
while($row = mysqli_fetch_assoc($data)) {
	$arrData[] = array(
		'idAlbum' => $row['idAlbum'],
		'tenAlbum' => $row['tenAlbum'],
		'tenCaSiAlbum' => $row['tenCaSiAlbum'],
		'hinhAlbum' => BASE_UPLOAD."album/".$row['hinhAlbum'],
	);
}
echo json_encode($arrData);
mysqli_close($conn);


?>