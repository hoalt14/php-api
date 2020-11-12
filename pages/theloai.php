<div class='container-fluid'>
	<h1>THỂ LOẠI</h1>
	<?php if(@$_GET['type']=='add'){ ?>
		<?php 
			if(@$_POST['submit']){								

				if(@$_GET['id']){
					$tenTheLoai = $_POST['tenTheLoai'];	
					$idChuDe    = $_POST['idChuDe'];	


					$result = $conn->query("SELECT * FROM theloai WHERE idTheLoai = ".$_GET['id']." LIMIT 1");
					$row = $result->fetch_assoc();

					$update = array(
						"tenTheLoai = '$tenTheLoai'",
						"idChuDe = '$idChuDe'",
					);					

					if(!empty($_FILES['hinhTheLoai']['name'])){
						$hinhTheLoai    = time().".png";
						$update[] = "hinhTheLoai = '$hinhTheLoai'";
					}

					$update = implode(', ', $update);
					$sql = "UPDATE theloai SET $update WHERE idTheLoai=".$row['idTheLoai'];
										
					if ($conn->query($sql) === TRUE) {
						if(!empty($_FILES['hinhTheLoai']['name'])){
							move_uploaded_file($_FILES['hinhTheLoai']['tmp_name'], '../upload/theloai/'. time().'.png');
							@unlink('../upload/theloai/'.$row['hinhTheLoai']);
						}


				     	echo "<script>alert('Cập nhật TheLoai thành công');</script>";
					    echo "<script>window.location='".BASE_URL."?pages=theloai&type=add&id=".$row['idTheLoai']."'</script>";
					} else {
						echo "Error updating record: " . $conn->error;
					    echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
					    echo "<script>window.location='".BASE_URL."?pages=theloai&type=add&id=".$row['idTheLoai']."'</script>";
					}
				}else{
					$tenTheLoai = $_POST['tenTheLoai'];	
					$idChuDe    = $_POST['idChuDe'];


					if(!empty($_FILES['hinhTheLoai']['name']))
						$hinhTheLoai    = time().".png";	
					else $hinhTheLoai='';

					$sql = "INSERT INTO theloai (tenTheLoai, idChuDe, hinhTheLoai)
					VALUES ('$tenTheLoai', $idChuDe, '$hinhTheLoai')";
					if ($conn->query($sql) === TRUE) {
					    $last_id = $conn->insert_id;
					    if(!empty($_FILES['hinhTheLoai']['name']))
	                    	move_uploaded_file($_FILES['hinhTheLoai']['tmp_name'], '../upload/theloai/'. $hinhTheLoai);
					   
					    echo "<script>alert('Thêm TheLoai thành công');</script>";
					    echo "<script>window.location='".BASE_URL."?pages=theloai&type=add&id=".$last_id."'</script>";
					} else {
						// echo "Error: " . $sql . "<br>" . $conn->error;
					    echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
					    echo "<script>window.location='".BASE_URL."?pages=theloai&type=add'</script>";
					}
				}
				$conn->close();
			}

			if(@$_GET['id']){
				$id = @$_GET['id'];
				$result = $conn->query("SELECT * FROM theloai WHERE idTheLoai = $id LIMIT 1");
				$row = $result->fetch_assoc();
			}
			
		?>
		<div class='box'>
			<div class='header'>
				THÊM MỚI THỂ LOẠI
				<button type="button" class="btn btn-default pull-right" 
					style="position: relative;top: -7px;"
					onclick="window.location='<?php echo BASE_URL ?>?pages=theloai'" 
				>QUAY LẠI</button>
			</div>
			<div class='body'>
				<form action="<?php echo BASE_URL ?>?pages=theloai&type=add&id=<?php echo @$row['idTheLoai']?>" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Tên thể loại</label>
						<div class="col-sm-10">
							<input type="text" name="tenTheLoai" class="form-control" value="<?php echo @$row['tenTheLoai']?>" required="required" placeholder="Thể Loại" >
						</div>
					</div>	

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Chủ đề</label>
						<div class="col-sm-10">
							<select name="idChuDe" id="input" class="form-control">
								<option value="">-- Chủ đề --</option>
								<?php 
									$result = $conn->query("SELECT * FROM chude");
									if ($result->num_rows > 0) {
									    while($al = $result->fetch_assoc()) {
									    	echo"<option value='$al[idChuDe]' ".($row['idChuDe'] == $al['idChuDe']?'selected':'').">$al[tenChuDe]</option>";
									    }
									}
								?>				
							</select>						
						</div>
					</div>				
				

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Hình Thể Loại</label>
						<div class="col-sm-10">
							<input type="file" name="hinhTheLoai" class="form-control">
						</div>
					</div>
					<?php 
						if(@$row['hinhTheLoai']){
							echo '<div class="form-group">
									<label for="input" class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<img src="'.BASE_UPLOAD.'theloai/'.$row['hinhTheLoai'].'" style="width:100px">
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
	
	<?php }elseif(@$_GET['type']=='del'){ 
		$id = @$_GET['id'];
		$result = $conn->query("SELECT * FROM theloai WHERE idTheLoai = $id LIMIT 1");
		$row = $result->fetch_assoc();
		if(!empty($row)){
			$sql = "DELETE FROM theloai WHERE idTheLoai=$id";
			if ($conn->query($sql) === TRUE) {
				@unlink('../upload/theloai/'.$row['hinhTheLoai']);
			    echo "<script>alert('Xóa thành công');</script>";
			    echo "<script>window.location='".BASE_URL."?pages=theloai'</script>";
			} else {
			    echo "<script>alert('Xóa thất bại');</script>";
			    echo "<script>window.location='".BASE_URL."?pages=theloai'</script>";
			}
		}		
		$conn->close();
		exit;
	}else{ ?>
		<div class='box'>
			<div class='header'>
				DANH SÁCH BÀI HÁT
				<button type="button" class="btn btn-default pull-right" 
					style="position: relative;top: -7px;"
					onclick="window.location='<?php echo BASE_URL ?>?pages=theloai&type=add'" 
				>THÊM MỚI</button>
			</div>
			<div class='body'>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>	
							<th>Hình</th>							
							<th>Thể Loại</th>
							<th>Album</th>
							<th>Sửa</th>
							<th>Xóa</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$result = $conn->query("SELECT * FROM theloai");
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
							    	echo"<tr>
							    			<td style='width:30px'>$row[idTheLoai]</td>
											<td style='width:100px'><img src='".BASE_UPLOAD."theloai/$row[hinhTheLoai]' class='img-imge'></td>
											
											<td>$row[tenTheLoai]</td>
											<td style='width:50px'>$row[idChuDe]</td>
											<td style='width:30px'><a href='".BASE_URL."?pages=theloai&type=add&id=$row[idTheLoai]'>Sửa</a></td>
											<td style='width:30px'><a href='".BASE_URL."?pages=theloai&type=del&id=$row[idTheLoai]'>Xóa</a></td>
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
	<?php }?>
</div>
<Style>
.img-imge{
	    width: 70px;
}	
</Style>