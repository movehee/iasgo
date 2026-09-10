<?include "./../header.php";?>

<?
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$query = "SELECT * FROM booth_tbl where code='".$code."' and del='N'";
if(empty($tab))
	$tab=1;

if($tab==1){
	$query .= " and tab in ('1','3') ";	
}else if($tab==2)
{
	$query .= " and tab in ('1','2') ";	
}
$query .= " order by vip asc, orderby asc";
//echo $query;

$result = mysqli_query($conn, $query);
$vip=-1;
?>

<style>




/* 리스트 스타일 */
ul.listBl > li,
.blCircle {padding-left:10px;background:url('../image/bl_dot.png') left 5px no-repeat;background-size:3px;}


p.ing {position:absolute;left:0;top:50%;width:100%;height:172px;margin:-104px 0 0 -86px;}
p.ing img {display: block;width:100%;}


/* Layout */
div.wrapper {width:100%;min-width:320px;font-size:14px;color:#6c6c6c;line-height:1.5;font-family: 'Noto Sans KR', sans-serif;background-color:#fff;word-break:keep-all;}

/* popup */
div#popupWrap {display: none;z-index: 50;overflow: hidden;position: fixed;left: 0;top: 0;width: 100%;height: 100%;padding: 40px 15px;box-sizing:border-box;background-color:rgba(0,0,0,.8);}
div#popupWrap > p {position: absolute;right: 0;top: 0;width: 40px;height: 40px;}
div#popupWrap > p a {display: block;height: 100%;text-indent: -10000px;background: url('../image/btn/popupBtn_close.png') center center no-repeat;background-size: 20px;}

div.imgArea {overflow: auto;width: 100%;height: 100%;}
div.imgArea img {max-width: auto;max-height: 100%;}

div.scrollView {padding: 20px;background-color: rgba(0,0,0,.8);}


div.toggleArea ul {display: none;overflow-x: hidden;overflow-y: scroll;padding: 5px 0px 0px;border: 1px solid #ddd;border-top: 0 none;background-color: #fff;}
div.conMenu {z-index:100;}
div.conMenu ul {max-height: 170px;}
div.toggleArea li {padding: 5px 10px 5px;}
div.toggleArea li a {display: block;}


.toggleCon {display: none;}


table.rwTbl {}
table.rwTbl colgroup,
table.rwTbl col {display:none;}
table.rwTbl tr,
table.rwTbl th,
table.rwTbl td {display:block;text-align:left;}

table.rwTbl th,
table.rwTbl td {padding:10px 0;word-break:normal;}
table.rwTbl th {padding-bottom:0;color:#00386c;font-weight:bold;}
table.rwTbl td {padding-top:5px;border-bottom:1px solid #00386c;color:#3f3f3f;}

table.rwTbl tr {}
table.rwTbl th {font-size: 1.18em;margin-top:10px;padding:5px 10px 7px;border-top:1px solid #00386c;background-color:#f8f8f8;}
table.rwTbl tr:first-child th {border-top-width:2px;margin-top:0;}
table.rwTbl td {padding-left:15px;padding-bottom:0;border-bottom:0 none;    font-size: 1.1em;}
table.rwTbl td.name {font-weight:bold;/* background:url('../image/bl_dot.png') 5px 13px no-repeat;이름앞에 dot빼기 */background-size:3px;    font-size: 1.1em;}


.viewBigger {margin: 10px 10px 31px;border: 1px solid #e5e5e5;}
.viewBigger a {position: relative;display: block;}
.viewBigger .bigger {position: absolute;right: 8px;bottom: -21px;width: 42px;}


.tblCell {display: table-cell;box-sizing:border-box;vertical-align: middle;}

a.conLink {display: inline-block;color: #2400ff;word-break:break-all;}

div.mapArea {height: 180px;border: 1px solid #dcdcdc;margin: 10px;}


/* 팝업 */
div.popupWrap {display: none;overflow-y: hidden;overflow-x: auto;position: fixed;left: 0;top: 0;width: 100%;min-width:320px;height: 100%;padding: 40px;background-color: rgba(0,0,0,.7);box-sizing:border-box;}
div.popupWrap > div {padding: 10px;background-color: #fff;box-sizing:border-box;}



/* Sponsors */
.boothNum {overflow: hidden;display: block;}
.boothNum span {float: left;display: block;width: 30px;height: 20px;margin-left: 5px;padding: 5px 0;text-align: center;color: #fff !important;font-size: 16px;line-height: 20px;}
.boothNum span:first-child {margin-left: 0;}
.boothNum span.type01 {background-color: #0077b4;}
.boothNum span.type02 {background-color: #b41e00;}

dl.sponsors {}
dl.sponsors > dt {padding: 6px 0 8px;font-size: 1.1em;font-weight: bold;text-align: center;color: #fff;}
dl.sponsors > dd {padding: 10px;}
dl.sponsors li {border-top: 1px solid #dcdcdc;}
dl.sponsors li:first-child {border-top: 0 none;}
dl.sponsors .tblCell {position: relative;height:92px;padding: 0 80px  0 130px;color: #000;font-size: 16px;line-height: 1.4;}
dl.sponsors span.logo {position: absolute;left: 0;top: 50%;width: 118px;height: 60px;margin-top: -31px;border: 1px solid #dcdcdc;}
dl.sponsors span.logo img {display: block;width: 100%;height: 100%;}

dl.sponsors span.boothNum {position: absolute;right: 0;top: 50%;margin-top: -15px;}

dl.sponsorInfo {padding-bottom: 10px;}
dl.sponsorInfo dt {color: #000;}
dl.sponsorInfo dt strong {display: block;padding-top: 10px;font-size: 1.2em;}
dl.sponsorInfo dd {padding-top: 10px;}
dl.sponsorInfo dd.btn a {display: block;text-align: center;padding: 10px 0 7px;}
dl.sponsorInfo dd.btn img {display: inline-block;height: 25px;margin: -4px 10px 0 0;vertical-align: top;}

div#popupSponsor {}
div#popupSponsor .popupCon {position: relative;padding-bottom:50px;}
div#popupSponsor .scrollArea {padding: 10px;background-color: #e9e9e9;color: #000;}
div#popupSponsor .scrollArea > * {padding-top: 20px;}
div#popupSponsor .scrollArea > *:first-child {padding-top: 0;}
div#popupSponsor .close {position: absolute;left: 0;bottom: 0;width: 100%;}
div#popupSponsor .close a {display: block;width: 100%;padding: 11px 0 13px;text-align: center;font-weight: bold;}



</style>

<?if(!$include){?>
<div class="titArea">
	<h2>
	<?if($tab==1){?>
		<?=$setting_col['sponsor_txt']?>
	<?}else if($tab==2){?>
		<?=$setting_col['booth_txt']?>
	<?}?>
	
	</h2>
	<p class="fixedBtn">
		<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>
<?}?>

<div class="wrapper">




	<!-- container -->
	<div id="containerWrap">
		

		
		<div class="contents">

			<?=$setting_col['booth_top_text']?>

			<dl class="sponsors">

			<dd>
			<?while(is_array($col = mysqli_fetch_array($result))){
			
					if($vip!= $col['vip']){
						
						$vip = $col['vip'];?>
						</dd>
						<dt style="background-color:<?=$setting_col['vip_color'.$vip]?>;"><?=$setting_col['vip_info'.$vip]?></dt>
						<dd>
					<?}
				?>
				<ul><li><a onclick="javascript:get_booth('<?=$col['sid']?>')" class="tblCell viewPop">
				<?if($col['image']){?>
					<span class="logo"><img src="http://ezv.kr/upload/booth/<?=$col['image']?>" <?if($col['linkurl']){?> onclick="javascript:location.href='<?=$col['linkurl']?>'"<?}?> alt="" /></span>
					
				<?}else{?>
					<span class="logo"></span>
				<?}?>
					<?=$col['name']?>
				<?if($col['booth_num']){
					$temp = split(", ",$col['booth_num']);
					
				?>
					<span class="boothNum">
					<?
					for($i=0;$i< sizeof($temp);$i++){?>
						<span class="type0<?=$col['booth_type']?>"><?=$temp[$i]?></span>
					<?}
					?>
					</span>
				<?}?>
				
				</a></li></ul>
				

				
			<?}?>

			</dl>
		</div>

	</div>
	<!-- //containerWrap -->


<div class="popupWrap" id="popupSponsor">
	<div class="popupCon" style="height: 364px;">
		<dl class="sponsorInfo">
			<dt>
				<span class="boothNum" id="booth_booth_num">
					<span class="type02">21</span>
					<span class="type02">24</span>
				</span>
				<strong id="booth_name"></strong><dd  id="booth_name_en">
				</dd>
			</dt>
			<dd id="booth_link">
				
			</dd>
			<dd class="btn" id="booth_info_pdf">
				
			</dd>
		</dl>

		<div class="scrollArea">
			<p id="booth_content"></p>
			<p id="booth_info_image"></p>
		</div>

		<div class="btn close"><a href="#" class="btnGrey">Close</a></div>
	</div>
</div>
	

</div>


<script>
	function get_booth(sid){
		$.ajax({
			type:"POST",
			url:"./get_booth.php",
			data:"sid="+sid,
			success:function(msg){
				var dog = JSON.parse(msg);   
				
				document.getElementById("booth_name").innerHTML=dog.name;
				document.getElementById("booth_name_en").innerHTML=dog.name_en;
				document.getElementById("booth_link").innerHTML="";
				if(dog.linkurl){
					document.getElementById("booth_link").innerHTML="<a href='"+dog.linkurl+"' target='_blank' class='conLink'>"+dog.linkurl+"</a>";
				}
				document.getElementById("booth_info_pdf").innerHTML="";
				if(dog.info_pdf){
					document.getElementById("booth_info_pdf").innerHTML="<a href='/upload/booth/"+dog.info_pdf+"' class='btnBdGrey'><img src='/ksic/2019s/image/btn/icon_file.png'>자료보기</a>";
				}
				document.getElementById("booth_content").innerHTML="";
				if(dog.content){
					document.getElementById("booth_content").innerHTML=dog.content;
				}
				document.getElementById("booth_info_image").innerHTML="";
				if(dog.info_image){
					document.getElementById("booth_info_image").innerHTML="<img src='/upload/booth/"+dog.info_image+"'>";
				}

				document.getElementById("booth_booth_num").innerHTML="";
				if(dog.booth_num){
					var temp = dog.booth_num.split(", ");
					var temp2= "";
					for (var i=0;i<temp.length;i++) {
						temp2 += "<span class='type02'>"+temp[i]+"</span>";
					}
					document.getElementById("booth_booth_num").innerHTML=temp2;

				}


				var win_h = $(window).height(),
				popup_reH = win_h - 80;

				$("div.wrapper").css({
					"overflow":"hidden",
					"height":win_h
				});
				$("div.popupCon").outerHeight(popup_reH);
				$("div.popupWrap").show();

				//Sponsors 팝업
				if ($("div.popupWrap").attr("id") == "popupSponsor") {
					var reH = popup_reH - parseInt($("div.popupCon").css("padding-top")) - parseInt($("div.popupCon").css("padding-bottom")) - $("dl.sponsorInfo").outerHeight() - 20;
					$("#popupSponsor div.scrollArea").height(reH);
				}

			}
		});
	}
	//팝업 보기
	$("a.viewPop").on("click", function(){
		


		/*
		var win_h = $(window).height(),
			header_h = $("div#headerWrap").outerHeight(),
			popupCon_reHeight = win_h - 80,
			sClass = $(this).attr("class"),
			viewPop = sClass.substr(12, 1);

		$("div.wrapper").css({
			"overflow":"hidden",
			"height":win_h
		});
		$("div#popupWrap").eq(viewPop).show();
		$("div#popupWrap > div").height(popupCon_reHeight);
	*/
		return false
	});

		$("a.viewPop").on("click", function(){
			/*
		var win_h = $(window).height(),
			popup_reH = win_h - 80;

		$("div.wrapper").css({
			"overflow":"hidden",
			"height":win_h
		});
		$("div.popupCon").outerHeight(popup_reH);
		$("div.popupWrap").show();

		//Sponsors 팝업
		if ($("div.popupWrap").attr("id") == "popupSponsor") {
			var reH = popup_reH - parseInt($("div.popupCon").css("padding-top")) - parseInt($("div.popupCon").css("padding-bottom")) - $("dl.sponsorInfo").outerHeight() - 20;
			$("#popupSponsor div.scrollArea").height(reH);
		}
		*/
		return false
	});
	
	

</script>


<?include "./../footer.php";?>