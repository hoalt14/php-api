<div class='container-fluid'>
	<h1>ROOM</h1>
	<?php if (@$_GET['type'] == 'empty') { ?>
		<?php
			if (@$_POST['submit']) {
				if (@$_GET['id']) {
					$roomName     = $_POST['roomName'];
					$roomPrice     = $_POST['roomPrice'];
					$roomStatus    = $_POST['roomStatus'];

					$result = $conn->query("SELECT * FROM room WHERE roomID = " . $_GET['id'] . " LIMIT 1");
					$row = $result->fetch_assoc();

					if (!empty($_FILES['roomPicture']['name'])) {
						$roomPicture    = time() . ".png";
						$sql = "UPDATE room SET roomName='$roomName', roomPrice=$roomPrice, roomStatus=$roomStatus, roomPicture = '$roomPicture' WHERE roomID=" . $row['roomID'];
					} else {
						$sql = "UPDATE room SET roomName='$roomName', roomPrice=$roomPrice, roomStatus=$roomStatus WHERE roomID=" . $row['roomID'];
					}

					if ($conn->query($sql) === TRUE) {
						if (!empty($_FILES['roomPicture']['name'])) {
							move_uploaded_file($_FILES['roomPicture']['tmp_name'], '../upload/room/' . time() . '.png');
							@unlink('../upload/room/' . $row['roomPicture']);
						}
						echo "<script>alert('Update success!');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=room&type=add&id=" . $row['roomID'] . "'</script>";
					} else {
						// echo "Error updating record: " . $conn->error;
						echo "<script>alert('Fail, please try again!');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=room&type=add&id=" . $row['roomID'] . "'</script>";
					}
				} else {
					$roomName     = $_POST['roomName'];
					$roomPrice     = $_POST['roomPrice'];
					$roomStatus    = $_POST['roomStatus'];

					if (!empty($_FILES['roomPicture']['name']))
						$roomPicture    = time() . ".png";
					else $roomPicture = '';

					$sql = "INSERT INTO room (roomName, roomPrice, roomStatus, roomPicture) VALUES ('$roomName', $roomPrice, $roomStatus, '$roomPicture')";

					if ($conn->query($sql) === TRUE) {
						$last_id = $conn->insert_id;
						if (!empty($_FILES['roomPicture']['name']))
							move_uploaded_file($_FILES['roomPicture']['tmp_name'], '../upload/room/' . $roomPicture);
						echo "<script>alert('Insert success!');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=room&type=add&id=" . $last_id . "'</script>";
					} else {
						// echo "Error: " . $sql . "<br>" . $conn->error;
						echo "<script>alert('Fail, please try again!');</script>";
						echo "<script>window.location='" . BASE_URL . "?pages=room&type=add'</script>";
					}
				}
				$conn->close();
			}
			if (@$_GET['id']) {
				$id = @$_GET['id'];
				$result = $conn->query("SELECT * FROM room WHERE roomID = $id LIMIT 1");
				$row = $result->fetch_assoc();
			}

			?>
		<div class='box'>
			<div class='header'>
				INSERT A NEW ROOM
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=room'">BACK</button>
			</div>
			<div class='body'>
				<form action="<?php echo BASE_URL ?>?pages=room&type=add&id=<?php echo @$row['roomID'] ?>" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" name="roomName" class="form-control" value="<?php echo @$row['roomName'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10">
							<input type="text" name="roomPrice" class="form-control" value="<?php echo @$row['roomPrice'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
							<input type="text" name="roomStatus" class="form-control" value="<?php echo @$row['roomStatus'] ?>" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Picture</label>
						<div class="col-sm-10">
							<input type="file" name="roomPicture" class="form-control">
						</div>
					</div>
					<?php
						if (@$row['roomPicture']) {
							echo '<div class="form-group">
									<label for="input" class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<img src="' . BASE_UPLOAD . 'room/' . $row['roomPicture'] . '" style="width:100px">
									</div>
								</div>';
						}
						?>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input type="submit" name="submit" class='btn btn-primary' value="CONFIRM">
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
		$result = $conn->query("SELECT * FROM room WHERE roomID = $id LIMIT 1");
		$row = $result->fetch_assoc();
		if (!empty($row)) {
			$sql = "DELETE FROM room WHERE roomID=$id";
			if ($conn->query($sql) === TRUE) {
				@unlink('../upload/room/' . $row['roomPicture']);
				echo "<script>alert('Delete success!');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=room'</script>";
			} else {
				echo "<script>alert('Delete fail!');</script>";
				echo "<script>window.location='" . BASE_URL . "?pages=room'</script>";
			}
		}
		$conn->close();
		exit;
	} else { ?>
		<div class='box'>
			<div class='header'>
				LIST
				<button type="button" class="btn btn-default pull-right" style="position: relative;top: -7px;" onclick="window.location='<?php echo BASE_URL ?>?pages=room&type=add'">INSERT NEW</button>
			</div>
			<div class='body'>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Price</th>
							<th>Status</th>
							<th>Picture</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$result = $conn->query("SELECT * FROM room");
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
											<td>$row[roomID]</td>
											<td>$row[roomName]</td>
											<td>$row[roomPrice]</td>
											<td>";
									if ($row['roomStatus'] == 1) echo 'empty';
									else echo 'hired';
									echo "</td>
											<td><img src='" . BASE_UPLOAD . "room/$row[roomPicture]' class='img-imge'></td>
											<td><a href='" . BASE_URL . "?pages=room&type=add&id=$row[roomID]'>Edit</a></td>
											<td><a href='" . BASE_URL . "?pages=room&type=del&id=$row[roomID]'>Delete</a></td>
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