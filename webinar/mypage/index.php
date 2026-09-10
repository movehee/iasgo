<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'func/config_time.php';
	if(!$kind) {
		if($_COOKIE['wmember_country']=='K') {
			$kind = "score";
		} else {
			$kind = "favor";
		}
	}

//	$My_poster = $conn->getOne("select count(sid) from e_poster where presenter_email='".$_COOKIE['wmember_email']."'");

//	$Nurse = $conn->getOne("select nurse from registration_tbl where sid='".$_COOKIE['wmember_sid']."'");
?>
<div class="contents">
	<div class="mypage">
		<ul class="subMenu ">

			<?if($_COOKIE['wmember_country']=='K'){?>
				<li <?if($kind=='score'){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?kind=score">평점확인</a></li>
			<?}?>
			
			<li <?if($kind=='favor'){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?kind=favor" >Favorites List</a></li>

			<li><a href="/program/session_list.php" target="_blank">Session Evaluation</a></li>

			<li <?if($kind=='down'){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?kind=down">Download Center</a></li>

			<?php if($_COOKIE['wmember_country']=='F' || $_COOKIE['wmember_level']=='M'):?><?php endif;?>
			<li><a href="/load/survey/survey.php"  class="Load_Base" Wsize="1000" Hsize="775" Tsize="50">Survey</a></li>
			

	<!-- 		<li <?if($kind=='booth_event'){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?kind=booth_event">QR Code Event</a></li> -->


			

			

			

			<!-- <li <?if($kind=='info'){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?kind=info"> Personal Information</a></li> -->
			


			<!-- <li <?if($kind=='cert'){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?kind=cert"> Certification</a></li> -->

			<!-- <li <?if($kind=='poster_qna'){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?kind=poster_qna">E-poster Q&A List</a></li>
			<li <?if($kind=='session_qna'){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?kind=session_qna">Session Q&A</a></li>
			<?if($Nurse=='Y'){?>
			<li <?if($kind=='nurse'){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?kind=nurse">Nurse Forum 이수증</a></li>
			<?}?> -->
			
		</ul>
		<?include $kind.".php"?>
	</div>
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>