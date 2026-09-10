<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	//procAdminLoginChk();
	$code = $code;
	$imsi_code = $code;

?>
<body>
<script type="text/javascript" src="/script/jquery-ui.min.js"></script>
<script type="text/javascript" src="/script/jquery-ui.min.js"></script>
<link rel='stylesheet' type='text/css' href='/script/jquery-flick.css'/>
<link rel="stylesheet" href="/script/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />
<script type="text/javascript" src="/script/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/script/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		
		window.resizeTo(re_width,600);
	});
</script>
<script type="text/javascript">

	$(function() {
		var code = $('#code').val();
		
		var file_key = $('#file_key').val();
		var getParam = function(key){
			var _parammap = {};
			document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
				function decode(s) {
					return decodeURIComponent(s.split("+").join(" "));
				}
	 
				_parammap[decode(arguments[1])] = decode(arguments[2]);
			});
	 
			return _parammap[key];
		};
		// Setup html5 version
		$("#uploader").plupload({
			// General settings
			
			runtimes : 'html5,flash,silverlight,html4',
			url : '/script/plupload/examples/upload_faculty.php?code='+code+"&file_key="+file_key,
			chunk_size: '100mb',
			rename : true,
			dragdrop: true,
			// Sort files
			sortable: true,
			
			// User can upload no more then 20 files in one go (sets multiple_queues to false)
			max_file_count: 50,
			
			filters : {
				// Maximum file size
				max_file_size : '100mb',
				// Specify what files to browse for
				mime_types: [
					{title : "files", extensions : "jpeg,JPEG,jpg,JPG,gif,GIF,png,PNG,pdf,PDF"}
				]
			},
			views: {
				list: true,
				thumbs: true, // Show thumbs
				active: 'thumbs'
			},
			// Resize images on clientside if we can
			//resize : {width : 320, height : 240, quality : 90, crop: true},

			flash_swf_url : '/script/plupload/js/Moxie.swf',
			silverlight_xap_url : '/script/plupload/js/Moxie.xap'
		});
		
		$('#uploader').find('div.plupload_buttons a.plupload_button.plupload_start').hide();


		$('#myfileF').submit(function(){
			var realfile = $('#realfile').val();
			if(realfile){
				
			}else{
				if ($('#uploader').plupload('getFiles').length > 0) {
					$('#uploader').on('complete', function() {
						$('#myfileF')[0].submit();
					});
					$('#uploader').plupload('start');
				} else {
					alert("이미지를 한개 이상 선택해주세요");
				}
				return false;
			}

			
		});
	});
	
	

//});

<?
/* 스팸코드 주석
function changeZsfImg() {
	document.getElementById("zsfImg").src="http://<?=$_SERVER['HTTP_HOST']?>/func/zmSpamFree/zmSpamFree.php?re&zsfimg="+new Date().getTime();
}
*/
?>
//]]>
</script>
<style>
.tblDef td{background:#ffffff;padding:5px 0px 5px 10px !important;margin:0px;}
</style>
<div class="popupCon" id="" style="width:900px;padding:20px;background:#ffffff;">
<form name="myfileF" id="myfileF" method="post" action="fileupload_reg.php" enctype="multipart/form-data">
<input type="hidden" name="code" id="code" value="<?=$code?>"/>
<input type="hidden" name="file_key" id="file_key" value="<?=$_COOKIE['wmember_id']."_".rand(1,999999)?>"/>
	<div class="fcRed">포스터 파일명은 Poster No.로 변경 후 업로드 하시면 파일이 자동매칭됩니다. (EX. 2020-0001)</div>
	<table class="tblDef inputTbl" style="width:100%;">

		<colgroup>
			<col style="width: 100%;">
		</colgroup>
		<tbody>
			<tr>
				<td>
					<div id="uploader">
						<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="submit" value="저장" class="btnPoint btnBig">
		<input type="button" value="취소" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
</div>
