<div class='container-fluid'>
	<h1>QUẢNG CÁO</h1>
	<?php if (@$_GET['type'] == 'add') { ?>
		<?php
			if (@$_POST['submit']) {

				if (@$_GET['id']) {
					$idBaiHat        = $_POST['idBaiHat'];
					$noiDungQuangCao = $_POST['noiDungQuangCao'];


					$result = $conn->query("SELECT * FROM quangcao WHERE idQuangCao = " . $_GET['id'] . " LIMIT 1");
					$row = $result->fetch_assoc();

					$update = array(
						"idBaiHat = $idBaiHat",
						"noiDungQuangCao = '$noiDungQuangCao'",
					);

					if (!empty($_FILES['hinhQuangCao']['name'])) {
						$hinhQuangCao    = time() . ".png";
						$update[] = "hinhQuangCao = '$hinhQuangCao'";
					}

					$update = implode(', ', $update);
					$sql = "UPDATE quangcao SET $update WHERE idQuangCao=" . $row['idQuangCao'];

					if ($conn->query($sql) === TRUE) {
						if (!empty($_FILES['hinhQuangCao']['name'])) {
							move_uploaded_file($_FILES['hinhQuangCao']['tmp_name'], '../upload/quangcao/' . time() . '.png');
							@unlink('../upload/quangcao/' . $row['hinhQuangCao']);
						}


						echo "<script>alert('Cập nhật QuangCao thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=quangcao&type=add&id=" . $row['idQuangCao'] . "'</script>";
					} else {
						echo "Error updating record: " . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=quangcao&type=add&id=" . $row['idQuangCao'] . "'</script>";
					}
				} else {
					$idBaiHat        = $_POST['idBaiHat'];
					$noiDungQuangCao = $_POST['noiDungQuangCao'];


					if (!empty($_FILES['hinhQuangCao']['name']))
						$hinhQuangCao    = time() . ".png";
					else $hinhQuangCao = '';

					$sql = "INSERT INTO quangcao (idBaiHat, noiDungQuangCao, hinhQuangCao)
					VALUES ($idBaiHat, '$noiDungQuangCao', '$hinhQuangCao')";
					if ($conn->query($sql) === TRUE) {
						$last_id = $conn->insert_id;
						if (!empty($_FILES['hinhQuangCao']['name']))
							move_uploaded_file($_FILES['hinhQuangCao']['tmp_name'], '../upload/quangcao/' . $hinhQuangCao);

						echo "<script>alert('Thêm QuangCao thành công');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=quangcao&type=add&id=" . $last_id . "'</script>";
					} else {
						// echo "Error: " . $sql . "<br>" . $conn->error;
						echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=quangcao&type=add'</script>";
					}
				}
				$conn->close();
			}

			if (@$_GET['id']) {
				$id = @$_GET['id'];
				$result = $conn->query("SELECT * FROM quangcao WHERE idQuangCao = $id LIMIT 1");
				$row = $result->fetch_assoc();
			}



			?>
		<div class='box'>
			<div class='header'>
				THÊM MỚI ALBUM
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=quangcao'">QUAY LẠI</button>
			</div>
			<div class='body'>
				<form action="<?php echo BASE_URL ?>?pages=quangcao&type=add&id=<?php echo @$row['idQuangCao'] ?>" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Bài Hát</label>
						<div class="col-sm-10">
							<select name="idBaiHat" id="input" class="form-control">
								<option value="">-- Bài Hát --</option>
								<?php
									$result = $conn->query("SELECT * FROM baihat");
									if ($result->num_rows > 0) {
										while ($al = $result->fetch_assoc()) {
											echo "<option value='$al[idBaiHat]' " . ($row['idBaiHat'] == $al['idBaiHat'] ? 'selected' : '') . ">$al[tenBaiHat]</option>";
										}
									}
									$conn->close();
									?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Nội Dung Quảng Cáo</label>
						<div class="col-sm-10">
							<textarea name="noiDungQuangCao" class="form-control" rows="3" required="required"><?php echo @$row['noiDungQuangCao'] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Hình Quảng Cáo</label>
						<div class="col-sm-10">
							<input type="file" name="hinhQuangCao" class="form-control">
						</div>
					</div>
					<?php
						if (@$row['hinhQuangCao']) {
							echo '<div class="form-group">
									<label for="input" class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<img src="' . BASE_UPLOAD . 'quangcao/' . $row['hinhQuangCao'] . '" style="width:100px">
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
		$result = $conn->query("SELECT * FROM quangcao WHERE idQuangCao = $id LIMIT 1");
		$row = $result->fetch_assoc();
		if (!empty($row)) {
			$sql = "DELETE FROM quangcao WHERE idQuangCao=$id";
			if ($conn->query($sql) === TRUE) {
				@unlink('../upload/quangcao/' . $row['hinhQuangCao']);
				echo "<script>alert('Xóa thành công');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=quangcao'</script>";
			} else {
				echo "<script>alert('Xóa thất bại');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=quangcao'</script>";
			}
		}
		$conn->close();
		exit;
	} else { ?>
		<div class='box'>
			<div class='header'>
				DANH SÁCH BÀI HÁT
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=quangcao&type=add'">THÊM MỚI</button>
			</div>
			<div class='body'>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Hình</th>
							<th>Nội Dung</th>
							<th>BaiHat</th>
							<th>Sửa</th>
							<th>Xóa</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$result = $conn->query("SELECT * FROM quangcao");
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
							    			<td style='width:30px'>$row[idQuangCao]</td>
											<td style='width:100px'><img src='" . BASE_UPLOAD . "quangcao/$row[hinhQuangCao]' class='img-imge'></td>
											
											<td>$row[noiDungQuangCao]</td>
											<td style='width:50px'>$row[idBaiHat]</td>
											<td style='width:30px'><a href='" . BASE_URL . "?pages=quangcao&type=add&id=$row[idQuangCao]'>Sửa</a></td>
											<td style='width:30px'><a href='" . BASE_URL . "?pages=quangcao&type=del&id=$row[idQuangCao]'>Xóa</a></td>
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