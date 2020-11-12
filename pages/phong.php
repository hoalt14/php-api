<div class='container-fluid'>
	<h1>Phòng</h1>
	<?php if (@$_GET['type'] == 'add') { ?>
		<?php
			if (@$_POST['submit']) {
				if (@$_GET['id']) {
					$tenChuDe     = $_POST['tenChuDe'];
					$result = $conn->query("SELECT * FROM chude WHERE idChuDe = " . $_GET['id'] . " LIMIT 1");
					$row = $result->fetch_assoc();
					if (!empty($_FILES['hinhChuDe']['name'])) {
						$hinhChuDe    = time() . ".png";
						$sql = "UPDATE chude SET tenChuDe='$tenChuDe', hinhChuDe = '$hinhChuDe' WHERE idChuDe=" . $row['idChuDe'];
					} else {
						$sql = "UPDATE chude SET tenChuDe='$tenChuDe' WHERE idChuDe=" . $row['idChuDe'];
					}

					if ($conn->query($sql) === TRUE) {
						if (!empty($_FILES['hinhChuDe']['name'])) {
							move_uploaded_file($_FILES['hinhChuDe']['tmp_name'], '../upload/chude/' . time() . '.png');
							@unlink('../upload/chude/' . $row['hinhChuDe']);
						}
						echo "<script>alert('Cập nhật Chủ Đề thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=chude&type=add&id=" . $row['idChuDe'] . "'</script>";
					} else {
						echo "Error updating record: " . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=chude&type=add&id=" . $row['idChuDe'] . "'</script>";
					}
				} else {
					$tenChuDe     = $_POST['tenChuDe'];
					if (!empty($_FILES['hinhChuDe']['name']))
						$hinhChuDe    = time() . ".png";
					else $hinhChuDe = '';
					$sql = "INSERT INTO chude (tenChuDe, hinhChuDe) VALUES ('$tenChuDe', '$hinhChuDe')";
					if ($conn->query($sql) === TRUE) {
						$last_id = $conn->insert_id;
						if (!empty($_FILES['hinhChuDe']['name']))
							move_uploaded_file($_FILES['hinhChuDe']['tmp_name'], '../upload/chude/' . $hinhChuDe);
						echo "<script>alert('Thêm Chủ Đề thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=chude&type=add&id=" . $last_id . "'</script>";
					} else {
						// echo "Error: " . $sql . "<br>" . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=chude&type=add'</script>";
					}
				}
				$conn->close();
			}
			if (@$_GET['id']) {
				$id = @$_GET['id'];
				$result = $conn->query("SELECT * FROM chude WHERE idChuDe = $id LIMIT 1");
				$row = $result->fetch_assoc();
			}

			?>
		<div class='box'>
			<div class='header'>
				THÊM MỚI CHỦ ĐỀ
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=chude'">QUAY LẠI</button>
			</div>
			<div class='body'>
				<form action="<?php echo BASE_URL ?>?pages=chude&type=add&id=<?php echo @$row['idChuDe'] ?>" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Tên Chủ Đề</label>
						<div class="col-sm-10">
							<input type="text" name="tenChuDe" class="form-control" value="<?php echo @$row['tenChuDe'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Hình Chủ Đề</label>
						<div class="col-sm-10">
							<input type="file" name="hinhChuDe" class="form-control">
						</div>
					</div>
					<?php
						if (@$row['hinhChuDe']) {
							echo '<div class="form-group">
									<label for="input" class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<img src="' . BASE_UPLOAD . 'chude/' . $row['hinhChuDe'] . '" style="width:100px">
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
		$result = $conn->query("SELECT * FROM chude WHERE idChuDe = $id LIMIT 1");
		$row = $result->fetch_assoc();
		if (!empty($row)) {
			$sql = "DELETE FROM chude WHERE idChuDe=$id";
			if ($conn->query($sql) === TRUE) {
				@unlink('../upload/chude/' . $row['hinhChuDe']);
				echo "<script>alert('Xóa thành công');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=chude'</script>";
			} else {
				echo "<script>alert('Xóa thất bại');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=chude'</script>";
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
											<td>$row[TinhTrang]</td>
											<td><img src='".BASE_UPLOAD."phong/$row[HinhPhong]' class='img-imge'></td>
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