<?include "./../header2.php";?>
<script type="text/javascript" src="/script/FileSaver.min.js" charset="utf-8"></script>


<div id="container" style="width:500px">
	<div class="contents" style="width:500px">
		<h2>썸네일 등록</h2><br><br><br><br>

		<div class="conArea" style="width:500px">
			
			<form enctype="multipart/form-data" name="registform" id="registform" action="./photo_post.php" method="post">
			<input type="hidden" name="code" id="code" value="<?=$code?>"/>
			<input type="hidden" name="abstract_sid" id="abstract_sid" value="<?=$sid?>"/>
				<fieldset>
				
					<table class="inputTbl">
						<colgroup>
							<col style="width: 30%;" />
							<col style="width: 70%;" />
						</colgroup>
						<tbody>

							<tr>
								<th rowspan = '2'><label for="">썸네일</label></th>
								<td>
								<?
								$query = "select * from abstract_file_tbl where abstract_sid='".$sid."'";
								$result = mysqli_query($conn, $query);
								while(is_array($col = mysqli_fetch_array($result))){?>
									<?=$col['file']?> <a onclick="javascript:del_photo('<?=$col['sid']?>')"> 삭제</a><br>

								<?}?>

								
								</td>
							</tr>
						
							<tr>
								<td style="height:100px" id="file_zone"></td>
							</tr>
							
						</tbody>
					</table>

					
					

					<div class="btnArea btn">
						
						<input type="button" value="저장" class="btnDef btnBig" onclick="upload()" />
						<input type="reset" onclick="window.close()" value="취소" class="btnGrey btnBig" />
					</div>
				</fieldset>
			</form>

		</div>
		<!--  //conArea -->

	</div>	
</div>


<script>

	var arrayfile = new Array();
	var dropZone = document.getElementById('file_zone');
    dropZone.addEventListener('dragover', handleDragOver, false);
    dropZone.addEventListener('drop', handleFileSelect, false);
	var signdate = Math.floor(new Date().getTime()/1000);
	var cnt=0;
	function handleFileSelect(evt) {
        evt.stopPropagation();
        evt.preventDefault();

		var itemlist = evt.dataTransfer.items;

		evt.preventDefault();
		for (let i=0; i<itemlist.length; i++) {
			let item = itemlist[i].webkitGetAsEntry();
			if (item) {
				
				scanFiles(item);
			}
		}
		//loop_thread(itemlist);
    }

	function del_photo(sid) {
		if(confirm("삭제하시겠습니까?")){
	
			$.ajax({
				type:"POST",
				url:"./del_photo.php",
				data:"sid="+sid,
				success:function(msg){
					alert(msg);
				}
			});


		}
	}



	function upload() {


		if(arrayfile.length>0){
			cnt++;
			var reader = new FileReader();
			var file = arrayfile.shift();
			reader.onload = function(file) 
			{
				//alert(reader.result);
				jQuery.ajax({
				   type:"POST",
				   async: false,
				   url:"./photo_post.php",
				   data: {signdate:signdate,code:document.getElementById('code').value,abstract_sid:document.getElementById('abstract_sid').value,file_idx:cnt,zipfile:reader.result},
				   
				   success : function(data) {
						upload();

				   },
				   error : function(request,status,error) {
						alert("error");
				   }
				});
			

			};
			reader.readAsDataURL(file);
		}
		else
		{
			//opener.location.reload();
			window.close();
		}

	}
    function handleDragOver(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        evt.dataTransfer.dropEffect = 'copy';
    }

	function scanFiles(item) 
	{
		if (item.isDirectory) {
		 
			let directoryReader = item.createReader();
			getreadEntries(directoryReader);
		}
		else if(item.isFile)
		{	
			//alert(item.name.indexOf(".PNG"));
			if(item.name.indexOf(".png")!=-1 || item.name.indexOf(".PNG")!=-1|| item.name.indexOf(".gif")!=-1 || item.name.indexOf(".GIF")!=-1  || item.name.indexOf(".jpeg")!=-1 || item.name.indexOf(".jpg")!=-1 || item.name.indexOf(".JPG")!=-1 || item.name.indexOf(".JPEG")!=-1)
			{
				
			let elem = document.createElement("li");
			elem.innerHTML = item.name;
			elem.id = item.name;
			document.getElementById('file_zone').appendChild(elem);

			item.file (function(file) {
				
				arrayfile.push(file);
			}, function(err) {
			});
			}
			
		}
	}

	function getreadEntries(directoryReader)
	{
		directoryReader.readEntries(function(entries) 
		{
			entries.forEach(function(entry) {
				scanFiles(entry);
			});
			if(entries.length>99)
			{
				getreadEntries(directoryReader);
			}
		});
	}

</script>


<?include "./../footer.php";?>