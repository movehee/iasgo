<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>CSV Upload</title>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<!-- 부가적인 테마 -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	</head>
	<body>
		 
		 	<div class="container" style="margin-top: 100px;">
        		<div class="row">
			  <div class="col-xs-12 col-sm-6 col-md-8"></div>
			  <div class="col-xs-6 col-md-4"></div>
			</div>
			<div class="row">
			  <div class="col-xs-6 col-sm-4"></div>
			  <div class="col-xs-6 col-sm-4">
				  <p class="text-danger">*행사코드와 CSV를 등록해주세요.</p>
				  
				  
				  <form name="ff" method="post"  action="csv.php" enctype="multipart/form-data" >
					  <input type="text" class="form-control" placeholder="행사코드입력" name="eventcode" id="eventcode" >
				  	<input type="file"  name="csvf" id="csvf"style="margin-top: 10px;" >
				</form>
					
				  <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;" onclick="register()">등록</button>
				  
			  </div>
			  
			  <!-- Optional: clear the XS cols if their content doesn't match in height -->
			  <div class="clearfix visible-xs-block"></div>
			  <div class="col-xs-6 col-sm-4"></div>
			</div>
			        		
        	</div>
        
			<script type="text/javascript">
			
			var register = function() {
				var code = document.getElementById('eventcode')
				var filen = document.getElementById('csvf')
				
				if ( code.value == "" ) {
					alert ('Code 를 입력해주세요')
					code.focus()
					return 
				} 
				
				
				if ( filen.value == "") {
					alert ('file 를 등록해주세요')
					filen.focus();
					return 
				}

				if (  getExtensionOfFilename(filen.value)   !=  ".csv")  {
					alert ('csv 파일을 등록하라고 했잖아요......')
					filen.focus();
					filen.value = ''
					return
				}
				
				document.ff.submit()
				
			}
			
			var  getExtensionOfFilename = function (filename) {
 
			    var _fileLen = filename.length;
			 
			    /** 
			     * lastIndexOf('.') 
			     * 뒤에서부터 '.'의 위치를 찾기위한 함수
			     * 검색 문자의 위치를 반환한다.
			     * 파일 이름에 '.'이 포함되는 경우가 있기 때문에 lastIndexOf() 사용
			     */
			    var _lastDot = filename.lastIndexOf('.');
			 
			    // 확장자 명만 추출한 후 소문자로 변경
			    var _fileExt = filename.substring(_lastDot, _fileLen).toLowerCase();
			 
			    return _fileExt;
			}
		
			</script>
	</body>
</html>









