<div class='container-fluid'>
	<h1>BÀI HÁT</h1>
	<?php if(@$_GET['type']=='add'){ ?>
		<?php 
			if(@$_POST['submit']){								

				if(@$_GET['id']){
					$tenBaiHat  = $_POST['tenBaiHat'];
					$caSi       = $_POST['caSi'];	
					$idAlbum    = $_POST['idAlbum'];	
					$idPlayList = $_POST['idPlayList'];	
					$idTheLoai  = $_POST['idTheLoai'];	
					$loiBaiHat  = $_POST['loiBaiHat'];
				

					$result = $conn->query("SELECT * FROM baihat WHERE idBaiHat = ".$_GET['id']." LIMIT 1");
					$row = $result->fetch_assoc();

					$update = array(
						"tenBaiHat = '$tenBaiHat'",
						"caSi = '$caSi'",
						"idAlbum = $idAlbum",
						"idPlayList = $idPlayList",
						"idTheLoai = $idTheLoai",
						"loiBaiHat = '$loiBaiHat'",
					);					

					if(!empty($_FILES['hinhBaiHat']['name'])){
						$hinhBaiHat    = time().".png";
						$update[] = "hinhBaiHat = '$hinhBaiHat'";
					}

					if(!empty($_FILES['linkBaiHat']['name'])){
						$linkBaiHat    = strtolower($_FILES['linkBaiHat']['name']);
						$update[] = "linkBaiHat = '$linkBaiHat'";
					}

					$update = implode(', ', $update);
					$sql = "UPDATE baihat SET $update WHERE idBaiHat=".$row['idBaiHat'];
										
					if ($conn->query($sql) === TRUE) {
						if(!empty($_FILES['hinhBaiHat']['name'])){
							move_uploaded_file($_FILES['hinhBaiHat']['tmp_name'], '../upload/baihat/'. time().'.png');
							@unlink('../upload/baihat/'.$row['hinhBaiHat']);
						}

						if(!empty($_FILES['linkBaiHat']['name'])){
							move_uploaded_file($_FILES['linkBaiHat']['tmp_name'], '../upload/file/'. $linkBaiHat);
							@unlink('../upload/file/'.$row['linkBaiHat']);
						}

				     	echo "<script>alert('Cập nhật BaiHat thành công');</script>";
					    echo "<script>window.location='".BASE_URL."?pages=baihat&type=add&id=".$row['idBaiHat']."'</script>";
					} else {
						echo "Error updating record: " . $conn->error;
					    echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
					    echo "<script>window.location='".BASE_URL."?pages=baihat&type=add&id=".$row['idBaiHat']."'</script>";
					}
				}else{
					$tenBaiHat  = $_POST['tenBaiHat'];
					$caSi       = $_POST['caSi'];	
					$idAlbum    = $_POST['idAlbum'];	
					$idPlayList = $_POST['idPlayList'];	
					$idTheLoai  = $_POST['idTheLoai'];	
					$loiBaiHat  = $_POST['loiBaiHat'];


					if(!empty($_FILES['hinhBaiHat']['name']))
						$hinhBaiHat    = time().".png";	
					else $hinhBaiHat='';

					if(!empty($_FILES['linkBaiHat']['name']))
						$linkBaiHat    = strtolower($_FILES['linkBaiHat']['name']);
					else $linkBaiHat='';

					$sql = "INSERT INTO baihat (tenBaiHat, caSi, idAlbum,loiBaiHat,hinhBaiHat,linkBaiHat, idPlayList,idTheLoai)
					VALUES ('$tenBaiHat', '$caSi', $idAlbum, '$loiBaiHat', '$hinhBaiHat', '$linkBaiHat', $idPlayList,$idTheLoai)";
					if ($conn->query($sql) === TRUE) {
					    $last_id = $conn->insert_id;
					    if(!empty($_FILES['hinhBaiHat']['name']))
	                    	move_uploaded_file($_FILES['hinhBaiHat']['tmp_name'], '../upload/baihat/'. $hinhBaiHat);
					   
	                    if(!empty($_FILES['linkBaiHat']['name'])){
							move_uploaded_file($_FILES['linkBaiHat']['tmp_name'], '../upload/file/'. $linkBaiHat);
						}
					    echo "<script>alert('Thêm BaiHat thành công');</script>";
					    echo "<script>window.location='".BASE_URL."?pages=baihat&type=add&id=".$last_id."'</script>";
					} else {
						// echo "Error: " . $sql . "<br>" . $conn->error;
					    echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại');</script>";
					    echo "<script>window.location='".BASE_URL."?pages=baihat&type=add'</script>";
					}
				}
				$conn->close();
			}

			if(@$_GET['id']){
				$id = @$_GET['id'];
				$result = $conn->query("SELECT * FROM baihat WHERE idBaiHat = $id LIMIT 1");
				$row = $result->fetch_assoc();
			}
			
		?>
		<div class='box'>
			<div class='header'>
				THÊM MỚI BÀI HÁT
				<button type="button" class="btn btn-default pull-right" 
					style="position: relative;top: -7px;"
					onclick="window.location='<?php echo BASE_URL ?>?pages=baihat'" 
				>QUAY LẠI</button>
			</div>
			<div class='body'>
				<form action="<?php echo BASE_URL ?>?pages=baihat&type=add&id=<?php echo @$row['idBaiHat']?>" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Tên bài hát</label>
						<div class="col-sm-10">
							<input type="text" name="tenBaiHat" class="form-control" value="<?php echo @$row['tenBaiHat']?>" required="required">
						</div>
					</div>	

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Album</label>
						<div class="col-sm-10">
							<select name="idAlbum" id="input" class="form-control" required="">
								<option value="">-- Album --</option>
								<?php 
									$result = $conn->query("SELECT * FROM album");
									if ($result->num_rows > 0) {
									    while($al = $result->fetch_assoc()) {
									    	echo"<option value='$al[idAlbum]' ".($row['idAlbum'] == $al['idAlbum']?'selected':'').">$al[tenAlbum]</option>";
									    }
									}
								?>				
							</select>						
						</div>
					</div>	

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Thể Loại</label>
						<div class="col-sm-10">
							<select name="idTheLoai" id="input" class="form-control" required>
								<option value="">-- Thể Loại --</option>
								<?php 
									$result = $conn->query("SELECT * FROM theloai");
									if ($result->num_rows > 0) {
									    while($al = $result->fetch_assoc()) {
									    	echo"<option value='$al[idTheLoai]' ".($row['idTheLoai'] == $al['idTheLoai']?'selected':'').">$al[tenTheLoai]</option>";
									    }
									}
								?>				
							</select>						
						</div>
					</div>	

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">PlayList</label>
						<div class="col-sm-10">
							<select name="idPlayList" id="input" class="form-control" required>
								<option value="">-- PlayList --</option>
								<?php 
									$result = $conn->query("SELECT * FROM playlist");
									if ($result->num_rows > 0) {
									    while($al = $result->fetch_assoc()) {
									    	echo"<option value='$al[idPlayList]' ".($row['idPlayList'] == $al['idPlayList']?'selected':'').">$al[tenPlayList]</option>";
									    }
									}

								?>				
							</select>						
						</div>
					</div>	

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Ca sỉ</label>
						<div class="col-sm-10">
							<input type="text" name="caSi" class="form-control" value="<?php echo @$row['caSi']?>" required="required">
						</div>
					</div>	

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Lời bài hát</label>
						<div class="col-sm-10">
							<textarea name="loiBaiHat" class="form-control" rows="3" required="required"><?php echo @$row['loiBaiHat']?></textarea>						
						</div>
					</div>	

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">File Nhạc</label>
						<div class="col-sm-10">
							<input type="file" name="linkBaiHat" class="form-control">
						</div>
					</div>
					<?php 
						if(@$row['hinhBaiHat']){
							echo '<div class="form-group">
									<label for="input" class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<audio controls>
											<source src="'.BASE_UPLOAD.'file/'.$row['linkBaiHat'].'" type="audio/ogg">
											<source src="'.BASE_UPLOAD.'file/'.$row['linkBaiHat'].'" type="audio/mpeg">
										Your browser does not support the audio element.
										</audio>
									</div>
								</div>';
						}
					?>	

					<div class="form-group">
						<label for="input" class="col-sm-2 control-label">Hình BaiHat</label>
						<div class="col-sm-10">
							<input type="file" name="hinhBaiHat" class="form-control">
						</div>
					</div>
					<?php 
						if(@$row['hinhBaiHat']){
							echo '<div class="form-group">
									<label for="input" class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<img src="'.BASE_UPLOAD.'baihat/'.$row['hinhBaiHat'].'" style="width:100px">
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
		$result = $conn->query("SELECT * FROM baihat WHERE idBaiHat = $id LIMIT 1");
		$row = $result->fetch_assoc();
		if(!empty($row)){
			$sql = "DELETE FROM baihat WHERE idBaiHat=$id";
			if ($conn->query($sql) === TRUE) {
				@unlink('../upload/baihat/'.$row['hinhBaiHat']);
				@unlink('../upload/file/'.$row['linkBaiHat']);
			    echo "<script>alert('Xóa thành công');</script>";
			    echo "<script>window.location='".BASE_URL."?pages=baihat'</script>";
			} else {
			    echo "<script>alert('Xóa thất bại');</script>";
			    echo "<script>window.location='".BASE_URL."?pages=baihat'</script>";
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
					onclick="window.location='<?php echo BASE_URL ?>?pages=baihat&type=add'" 
				>THÊM MỚI</button>
			</div>
			<div class='body'>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>	
							<th>Hình</th>							
							<th>Bài Hát</th>
							<th>Ca sĩ</th>
							<th>Album</th>
							<th>Thê loại</th>
							<th>Thê Playlist</th>
							<th>Sửa</th>
							<th>Xóa</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$result = $conn->query("SELECT * FROM baihat");
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
							    	echo"<tr>
							    			<td style='width:30px'>$row[idBaiHat]</td>
											<td  style='width:80px'><img src='".BASE_UPLOAD."baihat/$row[hinhBaiHat]' class='img-imge'></td>
											
											<td>$row[tenBaiHat]</td>
											<td>$row[caSi]</td>
											<td style='width:50px'>$row[idAlbum]</td>
											<td style='width:50px'>$row[idTheLoai]</td>
											<td style='width:50px'>$row[idPlayList]</td>
											<td style='width:30px'><a href='".BASE_URL."?pages=baihat&type=add&id=$row[idBaiHat]'>Sửa</a></td>
											<td style='width:30px'><a href='".BASE_URL."?pages=baihat&type=del&id=$row[idBaiHat]'>Xóa</a></td>
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
				"order": [[ 0, "desc" ]],
				"aoColumns":[		
					{"bSortable": true},
					{"bSortable": false, "width": "80px"},
					{"bSortable": true},
					{"bSortable": true},
					{"bSortable": true},
					{"bSortable": true},
					{"bSortable": true},
					{"bSortable": false},
					{"bSortable": false},					
				],
			});		
		</script>
	<?php }?>
</div>
<Style>
.img-imge{
	    width: 70px;
}	
</Style>