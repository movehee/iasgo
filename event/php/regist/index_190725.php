<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/func/include.function.php';
$isadmin=false;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="kor" xml:lang="kor"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<title>관리자</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link type="text/css" rel="stylesheet" href="/admin/css/common_v2.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/voting.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/feedback.css" />
<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->
<script type="text/javascript" src="/admin/script/jquery.min.1.7.1.js"></script>
<script type="text/javascript" src="/admin/script/jquery.placeholder.js"></script>
<script type="text/javascript" src="/admin/script/user.js"></script>

<script src="/script/1.7.1.jquery.min.js"></script>  
<script src="/script/1.8.18.jquery-ui.min.js"></script>  

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script>
  $( function() {
    $( document ).tooltip();
  } );
  </script>

<style>
.tooltipPoint{cursor: help !important;}


.ui-tooltip {
  padding: 5px 10px;
  color: #0034ce;
  box-shadow: 0 0 10px #ce1d1d;
 
  font-size:13px;
}

</style>
 
<!--
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />  
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  
<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
-->




</head>
<body>

<?
if($sid){
	$query="SELECT * FROM regist_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
}

$regist_query = "SELECT * FROM regist_set_tbl where code='".$code."' and del='N' ";

$regist_query .= " and adminchk='N' ";

$regist_query .= " order by orderby asc";
$regist_result = mysqli_query($conn, $regist_query);
$cnt=0;
?>

<style>
.registrWrap{background-color: #ffffff;padding:10px;width:98%;}
.registList{border-collapse:collapse;  background-color:#ffffff; width: 98%; margin: 0 auto; }
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


	function money_change(parent) {


		money_info = document.getElementById("money_info").value;

		code = document.getElementById("code").value;


		type0 = document.getElementById("pre_regist_val").value;
		type1="0";
		type2="0";
		type3="0";
		
		//alert(parent);
		if(document.getElementsByName("parent_"+parent)){
			//alert(document.getElementById("parent_"+parent).value);
			temp = document.getElementsByName("parent_"+parent).value+",";

			var fileValue = $("input[name='parent_"+parent+"']").length;
			for(var i=0; i<fileValue; i++){                          
				
				if($("input[name='val_"+parent+"']:checked").val()>0){
					temps = $("input[name='val_"+parent+"']:checked").val()+",";
				}else{
					temps = document.getElementById("val_"+parent).value+",";
				}

				if($("input[name='val_"+parent+"']:checked").val()>0){
					temps = $("input[name='val_"+parent+"']:checked").val()+",";
				}else{
					temps = document.getElementById("val_"+parent).value+",";
				}
				var temp = $("input[name='parent_"+parent+"']")[i].value+",";
				var temp_id = document.getElementsByName("parent_"+parent)[i].id;



				if (temp.indexOf(temps) != -1) {
					$("tr.parent_"+parent+temp_id.substr(6)).css({"display":"table-row"});
				}else{
					$("tr.parent_"+parent+temp_id.substr(6)).css({"display":"none"});
				}





				 //alert($("input[name='parent_"+parent+"']")[i].attr('id'));
			}


			
		}
		

		if(document.getElementById("money_type1")){
			money_type1 = document.getElementById("money_type1").value;
			
			if($("input[name='val_"+money_type1+"']:checked").val()>0){
				type1 = $("input[name='val_"+money_type1+"']:checked").val(); 
			}else{
				type1 = document.getElementById("val_"+money_type1).value;
			}
			
		}
		if(document.getElementById("money_type2")){
			money_type2 = document.getElementById("money_type2").value;

			if($("input[name='val_"+money_type1+"']:checked").val()>0){
				type2 = $("input[name='val_"+money_type2+"']:checked").val(); 
			}else{
				type2 = document.getElementById("val_"+money_type2).value;
			}

			
		}

		if(document.getElementById("money_type3")){
			money_type3 = document.getElementById("money_type3").value;

			if($("input[name='val_"+money_type1+"']:checked").val()>0){
				type3 = $("input[name='val_"+money_type3+"']:checked").val(); 
			}else{
				type3 = document.getElementById("val_"+money_type3).value;
			}

			
		}

		$.ajax({
			type:"POST",
			url:"./get_money.php",
			data:"code="+code+"&type0="+type0+"&type1="+type1+"&type2="+type2+"&type3="+type3,
			success:function(msg){
				document.getElementById("val_"+money_info).value=msg;
			}
		});	
	}



	function overlapchk(key,sid) {
		
		val = document.getElementById("val_"+key).value;
		alert(val);
		
		if(document.getElementById("type_"+key).value=="40"){
			val = $("input[name='val_"+key+"[0]']").val() + "@" + $("input[name='val_"+key+"[1]']").val();
		}

		if(document.getElementById("type_"+key).value=="50" || document.getElementById("type_"+key).value=="60"){
			val = $("input[name='val_"+key+"[0]']").val() + "-" + $("input[name='val_"+key+"[1]']").val()+ "-" + $("input[name='val_"+key+"[2]']").val();
		}
		alert("key="+key+"&val="+val+"&code="+document.getElementById("code").value+"&sid="+sid);
		
		$.ajax({
			type:"POST",
			url:"./chk_overlap.php",
			data:"key="+key+"&val="+val+"&code="+document.getElementById("code").value+"&sid="+sid,
			success:function(msg){
				alert(msg);
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


		
		$('#registform').submit(function() {
			
			
			var chk_cnt=0;
				
			for(i=1;i<=40;i++)
			{
				
				if(document.getElementById("type_"+i)){
					if(document.getElementById("type_"+i).value<1000){
					
						if(document.getElementById("necessary_"+i).value=="Y"){

							if($("input[name='necessary_"+i+"']").parents("tr").css("display") != "none"){
								if(document.getElementById("type_"+i).value=="40"){
									if($("input[name='val_"+i+"[0]']").val()==""){
										alert("필수값을 입력해주세요.");
										return false;
									} else if ($("input[name='val_"+i+"[1]']").val()==""){
										alert("필수값을 입력해주세요.");
										return false;
									}
								
								}else if(document.getElementById("type_"+i).value=="50" || document.getElementById("type_"+i).value=="60"){
									if($("input[name='val_"+i+"[0]']").val()==""){
										alert("필수값을 입력해주세요.");
										return false;
									} else if ($("input[name='val_"+i+"[1]']").val()==""){
										alert("필수값을 입력해주세요.");
										return false;
									} else if ($("input[name='val_"+i+"[2]']").val()==""){
										alert("필수값을 입력해주세요.");
										return false;
									}
								}else{
									if(document.getElementById("val_"+i).value==""){
										alert("필수값을 입력해주세요.");
										return false;
									}
								}
							}
						}
					}else{
						if($("input[name='necessary_"+i+"']").parents("tr").css("display") != "none"){
							if($("input[name='val_"+i+"']:checked").val()>0){
								temp = $("input[name='val_"+i+"']:checked").val(); 
							}else{
								if(document.getElementById("val_"+i)){
									temp = document.getElementById("val_"+i).value;
								}else{
									temp = "";
								}
							}
							if(temp=="" && document.getElementById("necessary_"+i).value=="Y"){
								
								alert("필수값을 입력해주세요.");
								return false;
							}
						}

					}
					

					if(document.getElementById("overlap_"+i).value=="Y" && document.getElementById("overlapchk_"+i).value=="N"){
						alert("중복체크를 해주세요.");
						return false;
					}
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
			$("tr#count_sel").css({"display":""});
			$("input#kor").css({"display":""});
			$("input#eng").css({"display":"none"});
			$("span#kor").css({"display":""});
			$("span#eng").css({"display":"none"});
			$("option#kor").css({"display":""});
			$("option#eng").css({"display":"none"});
		}else if(val.value==""){
			$("tr#count_sel").css({"display":"none"});
		}else{
			$("tr#count_sel").css({"display":""});
			$("tr#kor").css({"display":"none"});
			$("tr#eng").css({"display":"table-row"});
			$("input#eng").css({"display":""});
			$("input#kor").css({"display":"none"});
			$("span#kor").css({"display":"none"});
			$("span#eng").css({"display":""});
			$("option#kor").css({"display":"none"});
			$("option#eng").css({"display":""});
		}
	}





</script>
	
</div> <!-- //wrapper -->



</body>
</html>