<div class='container-fluid'>
	<h1>PHÒNG</h1>
		<div class='box'>
			<div class='header'>
				DANH SÁCH PHÒNG
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
											<td><img src='" . BASE_UPLOAD . "phong/$row[HinhPhong]' class='img-imge'></td>
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