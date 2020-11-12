<div class='container-fluid'>
	<h1>PLAYLIST</h1>
	<?php if (@$_GET['type'] == 'add') { ?>
		<?php
			if (@$_POST['submit']) {

				if (@$_GET['id']) {
					$tenPlayList     = $_POST['tenPlayList'];

					$result = $conn->query("SELECT * FROM playlist WHERE idPlayList = " . $_GET['id'] . " LIMIT 1");
					$row = $result->fetch_assoc();
					if (!empty($_FILES['hinhPlayList']['name'])) {
						$hinhPlayList    = time() . ".png";
						$sql = "UPDATE playlist SET tenPlayList='$tenPlayList', hinhPlayList = '$hinhPlayList' WHERE idPlayList=" . $row['idPlayList'];
					} else {
						$sql = "UPDATE playlist SET tenPlayList='$tenPlayList' WHERE idPlayList=" . $row['idPlayList'];
					}

					if ($conn->query($sql) === TRUE) {
						if (!empty($_FILES['hinhPlayList']['name'])) {
							move_uploaded_file($_FILES['hinhPlayList']['tmp_name'], '../upload/playlist/' . time() . '.png');
							@unlink('./upload/playlist/' . $row['hinhPlayList']);
						}
						echo "<script>alert('Cập nhật PlayList thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=playlist&type=add&id=" . $row['idPlayList'] . "'</script>";
					} else {
						echo "Error updating record: " . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=playlist&type=add&id=" . $row['idPlayList'] . "'</script>";
					}
				} else {
					$tenPlayList     = $_POST['tenPlayList'];
					if (!empty($_FILES['hinhPlayList']['name']))
						$hinhPlayList    = time() . ".png";
					else $hinhPlayList = '';

					$sql = "INSERT INTO playlist (tenPlayList, hinhPlayList)
					VALUES ('$tenPlayList', '$hinhPlayList')";
					if ($conn->query($sql) === TRUE) {
						$last_id = $conn->insert_id;
						if (!empty($_FILES['hinhPlayList']['name']))
							move_uploaded_file($_FILES['hinhPlayList']['tmp_name'], '../upload/playlist/' . $hinhPlayList);
						echo "<script>alert('Thêm PlayList thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=playlist&type=add&id=" . $last_id . "'</script>";
					} else {
						// echo "Error: " . $sql . "<br>" . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=playlist&type=add'</script>";
					}
				}
				$conn->close();
			}

			if (@$_GET['id']) {
				$id = @$_GET['id'];
				$result = $conn->query("SELECT * FROM playlist WHERE idPlayList = $id LIMIT 1");
				$row = $result->fetch_assoc();
			}

			?>
		<div class='box'>
			<div class='header'>
				THÊM MỚI ALBUM
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=playlist'">QUAY LẠI</button>
			</div>
			<div class='body'>
				<form action="<?php echo BASE_URL ?>?pages=playlist&type=add&id=<?php echo @$row['idPlayList'] ?>" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Tên PlayList</label>
						<div class="col-sm-10">
							<input type="text" name="tenPlayList" class="form-control" value="<?php echo @$row['tenPlayList'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Hình PlayList</label>
						<div class="col-sm-10">
							<input type="file" name="hinhPlayList" class="form-control">
						</div>
					</div>
					<?php
						if (@$row['hinhPlayList']) {
							echo '<div class="form-group">
									<label for="input" class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<img src="' . BASE_UPLOAD . 'playlist/' . $row['hinhPlayList'] . '" style="width:100px">
									</div>
								</div>';
						}
						?>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input type="submit" name="submit" class='btn btn-primary' value="XÁC NHẬN">
						</div>
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript">
			$('.table').dataTable();
		</script>

	<?php } elseif (@$_GET['type'] == 'del') {
		$id = @$_GET['id'];
		$result = $conn->query("SELECT * FROM playlist WHERE idPlayList = $id LIMIT 1");
		$row = $result->fetch_assoc();
		if (!empty($row)) {
			$sql = "DELETE FROM playlist WHERE idPlayList=$id";
			if ($conn->query($sql) === TRUE) {
				@unlink('../upload/playlist/' . $row['hinhPlayList']);
				echo "<script>alert('Xóa thành công');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=playlist'</script>";
			} else {
				echo "<script>alert('Xóa thất bại');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=playlist'</script>";
			}
		}
		$conn->close();
		exit;
	} else { ?>
		<div class='box'>
			<div class='header'>
				DANH SÁCH ALBUM
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=playlist&type=add'">THÊM MỚI</button>
			</div>
			<div class='body'>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Hình</th>
							<th>Tên PlayList</th>
							<th>Sửa</th>
							<th>Xóa</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$result = $conn->query("SELECT * FROM playlist");
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
							    			<td>$row[idPlayList]</td>
											<td><img src='" . BASE_UPLOAD . "playlist/$row[hinhPlayList]' class='img-imge'></td>	
											<td  style='width:100%'>$row[tenPlayList]</td>
											<td><a href='" . BASE_URL . "?pages=playlist&type=add&id=$row[idPlayList]'>Sửa</a></td>
											<td><a href='" . BASE_URL . "?pages=playlist&type=del&id=$row[idPlayList]'>Xóa</a></td>
										</tr>";
								}
							}
							$conn->close();
							?>
					</tbody>
				</table>
			</div>
		</div>
		<script type="text/javascript">
			$('.table').dataTable();
		</script>
	<?php } ?>
</div>
<Style>
	.img-imge {
		width: 70px;
	}
</Style>