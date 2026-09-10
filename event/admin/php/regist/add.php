<?
	include "./../header2.php";

if($sid){
	$query="SELECT * FROM regist_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
}

$regist_query="SELECT * FROM regist_set_tbl where code='".$code."' and del='N' order by orderby asc";
$regist_result = mysqli_query($conn, $regist_query);
$cnt=0;

$isadmin=true;
?>

<style>
body{background-color: #ffffff;}
.registrWrap{background-color: #ffffff; width:100%;}
.registList{border-collapse:collapse;  background-color:#ffffff; width: 100%; margin: 0 auto; }
.regist_th {width:20%;background-color:#eeeeee;padding: 10px; }
.regist_td {width:80%;background-color:#ffffff;padding: 10px; }
.regist_th,.regist_td{border-top: 1px solid #9e9e9e}
.regist_th,.regist_td:last-child{border-bottom: 1px solid #9e9e9e;}
.regist_td input.email {width:40%;margin-right:5px;}
.regist_td input.phone {width:15%;margin-right: 5px;}
.regist_td input.idW30{width:30%;}
.regist_td .small {width:30%;}
.regist_th span.necessary {color:#ff0000;vertical-align: middle;}
.regist_td span.inputMemo{font-size: 13px; margin-top: 5px;color: #003ae4; display: inline-block;}
.regist_td select {height:30px;}
.regist_td select.selectW20{width:20%;}
.regist_td select.selectW30{width:30%;}
.regist_td select.selectW40{width:40%;}
.regist_td select.selectW50{width:50%;}
.regist_td select.selectW70{width:70%;}
.regist_td input[type=text].textW20{width:20%;}
.regist_td input[type=text].textW30{width:30%;}
.regist_td input[type=text].textW50{width:50%;}
.regist_td input[type=text].textW80{width:80%;}
.regist_td input[type=text].textW100{width:100%;} 
.regist_td input[type=password].passW30{width:30%;} 
tr#kor {display:none;}
div.registBtn{padding: 20px; width: 50%; margin: 0 auto;}
span.overlap{ cursor: pointer; font-size: 12px;  padding: 4px 10px;  border: 1px solid #cb1d3b;}
span.overlap:hover{background-color: #cb1d3b; color: #ffffff;}
 

</style>

<? require_once("${DOCUMENT_ROOT}/php/regist/inc.php"); ?>
	
<script type="text/javascript">

	function overlapchk(key,sid) {
		
		val = document.getElementById("val_"+key).value;
		
		if(document.getElementById("type_"+key).value=="40"){
			val = $("input[name='val_"+key+"[0]']").val() + "@" + $("input[name='val_"+key+"[1]']").val();
		}

		if(document.getElementById("type_"+key).value=="50" || document.getElementById("type_"+key).value=="60"){
			val = $("input[name='val_"+key+"[0]']").val() + "-" + $("input[name='val_"+key+"[1]']").val()+ "-" + $("input[name='val_"+key+"[2]']").val();
		}
		
		$.ajax({
			type:"POST",
			url:"./chk_overlap.php",
			data:"key="+key+"&val="+val+"&code="+document.getElementById("code").value+"&sid="+sid,
			success:function(msg){
				if(msg>0){
					alert("중복된 데이터가 있습니다.");
				}else{
					document.getElementById("overlapchk_"+key).value="Y";
					alert("사용가능합니다.");
				}
			}
		});	

	}

	jQuery(function($) {
		/*
		$('#registform').submit(function() {
			
			
			var chk_cnt=0;
				
			for(i=1;i<=$("#regist_cnt").val();i++)
			{

				
		
				
				if(document.getElementById("type_"+i).value=="40"){
					//alert($("input[name='val_"+i+"[0]']").val());
					//alert($("input[name='val_"+i+"[1]']").val());
				}
				
				
				
				if(document.getElementById("val_"+i).value=="" && document.getElementById("necessary_"+i).value=="Y"){
					alert("필수값을 입력해주세요.");
					return false;
				}

				if(document.getElementById("overlap_"+i).value=="Y" && document.getElementById("overlapchk_"+i).value=="N"){
					alert("중복체크를 해주세요.");
					return false;
				}
				
				

			}
			
			

			
		});
		*/
		
		$("#sel_email").on("change", function() {

			var $val = $(this).val();

			if($val == "self") {
				$(".email_etc").val("").show().focus();
			} else {
				$(".email_etc").val($val).hide();
			}
			
			
		});


		/*기타 입력 부분*/
		$(":radio").on("click", function(){
			
			$has_etc = $(this).parent().find("input[type='radio']:visible").hasClass("etc");
			if($has_etc) {
				$radioId = "text_etc_" + $(this).attr("value");
				$radioArr = $(this).attr("name").split("_");
				$radioNum = $radioArr[1]

				$(".text_etc_"+$radioNum).not("#"+$radioId).val("").hide();

				if($("input[name='val_"+$radioNum+"']:checked").hasClass("etc")) {
					$("#text_etc_"+$("input[name='val_"+$radioNum+"']:checked").val()).show();
				}
			}
		});

	});


	$( function(){
		$('#eventdate').datepicker({dateFormat:"yy-mm-dd"});
	});


	function val_change(sid,val){
		$("div.parent"+sid).css({"display":"none"});
		$("div.parent"+sid+ ".parent_val"+val).css({"display":"block"});
	}

	function country_change(val){
		if(val.value=="80"){
			$("tr#kor").css({"display":"table-row"});
			$("tr#eng").css({"display":"none"});
		}else{
			$("tr#kor").css({"display":"none"});
			$("tr#eng").css({"display":"table-row"});
		}
	}

	function money_change(parent) {
		/*기타 입력 부분*/
		$(".text_etc_"+parent).val("").hide();

		if($("input[name='val_"+parent+"']:checked").hasClass("etc")) {
			$("#text_etc_"+$("input[name='val_"+parent+"']:checked").val()).show();
		}
	}

</script>
<?include "./../footer.php";?>