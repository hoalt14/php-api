<div class='container-fluid'>
	<h1>Album</h1>
	<?php if (@$_GET['type'] == 'add') { ?>
		<?php
			if (@$_POST['submit']) {

				if (@$_GET['id']) {
					$tenAlbum     = $_POST['tenAlbum'];
					$tenCaSiAlbum = $_POST['tenCaSiAlbum'];

					$result = $conn->query("SELECT * FROM album WHERE idAlbum = " . $_GET['id'] . " LIMIT 1");
					$row = $result->fetch_assoc();
					if (!empty($_FILES['hinhAlbum']['name'])) {
						$hinhAlbum    = time() . ".png";
						$sql = "UPDATE album SET tenAlbum='$tenAlbum', tenCaSiAlbum = '$tenCaSiAlbum', hinhAlbum = '$hinhAlbum' WHERE idAlbum=" . $row['idAlbum'];
					} else {
						$sql = "UPDATE album SET tenAlbum='$tenAlbum', tenCaSiAlbum = '$tenCaSiAlbum' WHERE idAlbum=" . $row['idAlbum'];
					}

					if ($conn->query($sql) === TRUE) {
						if (!empty($_FILES['hinhAlbum']['name'])) {
							move_uploaded_file($_FILES['hinhAlbum']['tmp_name'], '../upload/album/' . time() . '.png');
							@unlink('../upload/album/' . $row['hinhAlbum']);
						}
						echo "<script>alert('Cập nhật Album thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=album&type=add&id=" . $row['idAlbum'] . "'</script>";
					} else {
						echo "Error updating record: " . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=album&type=add&id=" . $row['idAlbum'] . "'</script>";
					}
				} else {
					$tenAlbum     = $_POST['tenAlbum'];
					$tenCaSiAlbum = $_POST['tenCaSiAlbum'];
					if (!empty($_FILES['hinhAlbum']['name']))
						$hinhAlbum    = time() . ".png";
					else $hinhAlbum = '';

					$sql = "INSERT INTO album (tenAlbum, tenCaSiAlbum, hinhAlbum)
					VALUES ('$tenAlbum', '$tenCaSiAlbum', '$hinhAlbum')";
					if ($conn->query($sql) === TRUE) {
						$last_id = $conn->insert_id;
						if (!empty($_FILES['hinhAlbum']['name']))
							move_uploaded_file($_FILES['hinhAlbum']['tmp_name'], '../upload/album/' . $hinhAlbum);
						echo "<script>alert('Thêm Album thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=album&type=add&id=" . $last_id . "'</script>";
					} else {
						// echo "Error: " . $sql . "<br>" . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=album&type=add'</script>";
					}
				}
				$conn->close();
			}

			if (@$_GET['id']) {
				$id = @$_GET['id'];
				$result = $conn->query("SELECT * FROM album WHERE idAlbum = $id LIMIT 1");
				$row = $result->fetch_assoc();
			}

			?>
		<div class='box'>
			<div class='header'>
				THÊM MỚI ALBUM
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=album'">QUAY LẠI</button>
			</div>
			<div class='body'>
				<form action="<?php echo BASE_URL ?>?pages=album&type=add&id=<?php echo @$row['idAlbum'] ?>" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Tên Album</label>
						<div class="col-sm-10">
							<input type="text" name="tenAlbum" class="form-control" value="<?php echo @$row['tenAlbum'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Tên Ca sỉ Album</label>
						<div class="col-sm-10">
							<input type="text" name="tenCaSiAlbum" class="form-control" value="<?php echo @$row['tenCaSiAlbum'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Hình Album</label>
						<div class="col-sm-10">
							<input type="file" name="hinhAlbum" class="form-control">
						</div>
					</div>
					<?php
						if (@$row['hinhAlbum']) {
							echo '<div class="form-group">
									<label for="input" class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<img src="' . BASE_UPLOAD . 'album/' . $row['hinhAlbum'] . '" style="width:100px">
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
		$result = $conn->query("SELECT * FROM album WHERE idAlbum = $id LIMIT 1");
		$row = $result->fetch_assoc();
		if (!empty($row)) {
			$sql = "DELETE FROM album WHERE idAlbum=$id";
			if ($conn->query($sql) === TRUE) {
				@unlink('../upload/album/' . $row['hinhAlbum']);
				echo "<script>alert('Xóa thành công');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=album'</script>";
			} else {
				echo "<script>alert('Xóa thất bại');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=album'</script>";
			}
		}
		$conn->close();
		exit;
	} else { ?>
		<div class='box'>
			<div class='header'>
				DANH SÁCH ALBUM
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=album&type=add'">THÊM MỚI</button>
			</div>
			<div class='body'>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Hình</th>
							<th>Tên Album</th>
							<th>Tên Ca sĩ</th>
							<th>Sửa</th>
							<th>Xóa</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$result = $conn->query("SELECT * FROM album");
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
							    			<td>$row[idAlbum]</td>
											<td><img src='" . BASE_UPLOAD . "album/$row[hinhAlbum]' class='img-imge'></td>
											
											<td>$row[tenAlbum]</td>
											<td>$row[tenCaSiAlbum]</td>
											<td><a href='" . BASE_URL . "?pages=album&type=add&id=$row[idAlbum]'>Sửa</a></td>
											<td><a href='" . BASE_URL . "?pages=album&type=del&id=$row[idAlbum]'>Xóa</a></td>
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