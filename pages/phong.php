<div class='container-fluid'>
	<h1>PHÒNG</h1>
	<?php if (@$_GET['type'] == 'add') { ?>
		<?php
			if (@$_POST['submit']) {
				if (@$_GET['id']) {
					$TenPhong     = $_POST['TenPhong'];
					$GiaPhong     = $_POST['GiaPhong'];
					$TinhTrang    = $_POST['TinhTrang'];

					$result = $conn->query("SELECT * FROM PHONG WHERE MaPhong = " . $_GET['id'] . " LIMIT 1");
					$row = $result->fetch_assoc();

					if (!empty($_FILES['HinhPhong']['name'])) {
						$HinhPhong    = time() . ".png";
						$sql = "UPDATE PHONG SET TenPhong='$TenPhong', GiaPhong='$GiaPhong', TinhTrang='$TinhTrang', HinhPhong = '$HinhPhong' WHERE MaPhong=" . $row['MaPhong'];
					} else {
						$sql = "UPDATE PHONG SET TenPhong='$TenPhong', GiaPhong='$GiaPhong', TinhTrang='$TinhTrang' WHERE MaPhong=" . $row['MaPhong'];
					}

					if ($conn->query($sql) === TRUE) {
						if (!empty($_FILES['HinhPhong']['name'])) {
							move_uploaded_file($_FILES['HinhPhong']['tmp_name'], '../upload/phong/' . time() . '.png');
							@unlink('../upload/phong/' . $row['HinhPhong']);
						}
						echo "<script>alert('Cập nhật Phòng thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=phong&type=add&id=" . $row['MaPhong'] . "'</script>";
					} else {
						// echo "Error updating record: " . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=phong&type=add&id=" . $row['MaPhong'] . "'</script>";
					}
				} else {
					$TenPhong     = $_POST['TenPhong'];
					$GiaPhong     = $_POST['GiaPhong'];
					$TinhTrang    = $_POST['TinhTrang'];

					if (!empty($_FILES['HinhPhong']['name']))
						$HinhPhong    = time() . ".png";
					else $HinhPhong = '';

					$sql = "INSERT INTO PHONG (TenPhong, GiaPhong, TinhTrang, HinhPhong) VALUES ('$TenPhong', $GiaPhong, $TinhTrang, '$HinhPhong')";

					if ($conn->query($sql) === TRUE) {
						$last_id = $conn->insert_id;
						if (!empty($_FILES['HinhPhong']['name']))
							move_uploaded_file($_FILES['HinhPhong']['tmp_name'], '../upload/phong/' . $HinhPhong);
						echo "<script>alert('Thêm Phòng thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=phong&type=add&id=" . $last_id . "'</script>";
					} else {
						// echo "Error: " . $sql . "<br>" . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=phong&type=add'</script>";
					}
				}
				$conn->close();
			}
			if (@$_GET['id']) {
				$id = @$_GET['id'];
				$result = $conn->query("SELECT * FROM PHONG WHERE MaPhong = $id LIMIT 1");
				$row = $result->fetch_assoc();
			}

		?>
		<div class='box'>
			<div class='header'>
				THÊM MỚI PHÒNG
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=phong'">QUAY LẠI</button>
			</div>
			<div class='body'>
				<form action="<?php echo BASE_URL ?>?pages=phong&type=add&id=<?php echo @$row['MaPhong'] ?>" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Tên Phòng</label>
						<div class="col-sm-10">
							<input type="text" name="TenPhong" class="form-control" value="<?php echo @$row['TenPhong'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Giá Phòng</label>
						<div class="col-sm-10">
							<input type="text" name="GiaPhong" class="form-control" value="<?php echo @$row['GiaPhong'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Tình Trạng</label>
						<div class="col-sm-10">
							<input type="text" name="TinhTrang" class="form-control" value="<?php echo @$row['TinhTrang'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Hình Phòng</label>
						<div class="col-sm-10">
							<input type="file" name="HinhPhong" class="form-control">
						</div>
					</div>
					<?php
						if (@$row['HinhPhong']) {
							echo '<div class="form-group">
									<label for="input" class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<img src="' . BASE_UPLOAD . 'phong/' . $row['HinhPhong'] . '" style="width:100px">
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
		$result = $conn->query("SELECT * FROM PHONG WHERE MaPhong = $id LIMIT 1");
		$row = $result->fetch_assoc();
		if (!empty($row)) {
			$sql = "DELETE FROM PHONG WHERE MaPhong=$id";
			if ($conn->query($sql) === TRUE) {
				@unlink('../upload/phong/' . $row['HinhPhong']);
				echo "<script>alert('Xóa thành công');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=phong'</script>";
			} else {
				echo "<script>alert('Xóa thất bại');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=phong'</script>";
			}
		}
		$conn->close();
		exit;
	} else { ?>
		<div class='box'>
			<div class='header'>
				DANH SÁCH PHÒNG
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=phong&type=add'">THÊM MỚI</button>
			</div>
			<div class='body'>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Mã Phòng</th>
							<th>Tên Phòng</th>
							<th>Giá Phòng</th>
							<th>Tình Trạng</th>
							<th>Hình Phòng</th>
							<th>Sửa</th>
							<th>Xóa</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$result = $conn->query("SELECT * FROM PHONG");
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
											<td>$row[MaPhong]</td>
											<td>$row[TenPhong]</td>
											<td>$row[GiaPhong]</td>
											<td>";
										if ($row['TinhTrang'] == 1) echo 'Có';
										else echo 'Không';	
										echo "</td>
											<td><img src='" . BASE_UPLOAD . "phong/$row[HinhPhong]' class='img-imge'></td>
											<td><a href='" . BASE_URL . "?pages=phong&type=add&id=$row[MaPhong]'>Sửa</a></td>
											<td><a href='" . BASE_URL . "?pages=phong&type=del&id=$row[MaPhong]'>Xóa</a></td>
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
			$('.table').dataTable({
				"order": [
					[0, "desc"]
				],
				"aoColumns": [{
						"bSortable": true
					},
					{
						"bSortable": false
					},
					{
						"bSortable": true
					},
					{
						"bSortable": false
					},
					{
						"bSortable": false
					},
				],
			});
		</script>
	<?php } ?>
</div>
<Style>
	.img-imge {
		width: 70px;
	}
</Style>