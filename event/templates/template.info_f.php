<?
function template_f($arr){
	ob_start(); //출력 버퍼링 활성
	global $_CONFIG;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KCR 2023</title>
</head>
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script type="text/javascript" src="/script/user_admin.js"></script>
<script type="text/javascript" src="/script/jquery.qrcode.min.js"></script>
<script>
//<![CDATA[
jQuery(function($) {
	var key = "<?=$arr['sid']?>";
	$(".barcode"+key).qrcode({width: 70,height: 70,text: "<?=$arr['qr_number']?>"}); //I=개인, T=단체
});
//]]>
</script>
<body style="margin: 0; padding: 0;">
<table style="width:700px;max-width:700px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border: 1px solid #ddd;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
	<tbody>
		<tr>
			<td style="height:180px;padding: 0;">
				<img src="https://virtual.kcr4u.org/asset/mail/mail_header.png" alt="KCR 2023" style="display:block;border:0 none;" />
			</td>
		</tr>
		<tr>
			<td style="padding: 30px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 16px;line-height: 26px;font-weight: bold;text-align: justify;letter-spacing: -0.7px;">
				Dear Dr.   <?if($arr['name_kr']){?><?=$arr['name_kr']?><?}else{?><?=$arr['name_eng']?><?}?>,<br><br>

				Thank you for registering for the 79<sup>th</sup> Korean Congress of Radiology 2023(KCR 2023) to be held on September 20 (Wed) - 23 (Sat), 2023 at Coex, Seoul, Korea. We sincerely hope you will enjoy participating in the KCR 2023.
			</td>
		</tr>

		<tr>
			<td style="padding: 10px 30px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #fff;font-size: 18px;line-height: 25px;font-weight: bold;background-color: #314177;">
				How to Participate Onsite
			</td>
		</tr>
		<tr>
			<td style="padding: 20px 30px 50px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
				<div style="padding-bottom: 15px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 19px;line-height: 20px;font-weight: bold;">
					<img src="https://virtual.kcr4u.org/asset/mail/mail_bl.png" alt="" style="display: inline-block;vertical-align: top;border: 0 none;height: 20px;">&nbsp;Registration Information
				</div>

				<table style="width:640px;max-width:640px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border-top: 2px solid #314177;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
					<tbody>
						<tr>
							<td style="width: 200px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;box-sizing: border-box;font-weight: bold;">
								Registration No.
							</td>
							<td style="width: 240px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;">
								<?=$arr['etc_field2']?>
							</td>
							<td rowspan="6" style="width: 200px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;vertical-align: middle;text-align: center;">
								<?if($arr['qr_number']){?>
								<img src="https://kcr4u-event.ezv.kr/upload/qr/<?=$arr['qr_number']?>.png" >
								<?}?>
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;font-weight: bold;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								Name
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;">
								<?if($arr['name_kr']){?><?=$arr['name_kr']?><?}else{?><?=$arr['name_eng']?><?}?>
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;font-weight: bold;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								Affiliation
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;">
							<?if($arr['aff_kor']){?><?=$arr['aff_kor']?><?}else{?><?=$arr['aff_eng']?><?}?>


							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;font-weight: bold;border-bottom: 1px solid #ccc;color: #db1d1d;font-size: 15px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;letter-spacing: -0.5px;">
								Registration Information
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;">
								<?=$arr['etc_field7']?>
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;font-weight: bold;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								Ribbon Information
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 15px;line-height: 20px;">
								<?=$arr['etc_field6']?>
							</td>
						</tr>
					</tbody>
				</table>

				<ul style="margin: 10px 0 0;padding: 0 0 0 14px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
					<li>Please bring your registration QR code and visit the registration desk.</li>
				</ul>
				<br><br>


				<div style="padding-bottom: 15px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 19px;line-height: 20px;font-weight: bold;">
					<img src="https://virtual.kcr4u.org/asset/mail/mail_bl.png" alt="" style="display: inline-block;vertical-align: middle;border: 0 none;height: 20px;">&nbsp;Registration Desk Operation Schedule
				</div>

				<table style="width:640px;max-width:640px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border-top: 2px solid #314177;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
					<tbody>
						<tr>
							<td style="width: 320px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								Operation Hours
							</td>
							<td style="width: 320px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								Place
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								September 20 (Wed) - 23 (Sat), 07:00-17:30
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								Grand Ballroom Left-Lobby, 1F, Coex
							</td>
						</tr>
					</tbody>
				</table>
				<br><br>


				<div style="padding-bottom: 15px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 19px;line-height: 20px;font-weight: bold;">
					<img src="https://virtual.kcr4u.org/asset/mail/mail_bl.png" alt="" style="display: inline-block;vertical-align: top;border: 0 none;height: 20px;">&nbsp;Registration Desk Information
				</div>

				<table style="width:640px;max-width:640px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border-top: 2px solid #314177;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
					<tbody>
						<tr>
							<td style="width: 128px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								Invited Guest
							</td>
							<td style="width: 128px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								Awards <br>& Cashier
							</td>
							<td style="width: 128px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								On-site<br>Registration
							</td>
							<td style="width: 128px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								Kiosk
							</td>
							<td style="width: 128px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								Congress<br>Kit Desk
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								Invited Guest
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								Award winners, <br>
								registration <br>
								payment <br>
								& refunds
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								On-site <br>registrants
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								Participants <br>who have <br>completed <br>their payment
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								Congress Bag,<br> Social Program <br>tickets, ribbon
							</td>
						</tr>
					</tbody>
				</table>

				<ul style="margin: 10px 0 0;padding: 0 0 0 14px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
					<li>Please note that the <span style="font-weight: bold;text-decoration: underline;">Congress Bag, Social Program tickets, Special dietary coupon and ribbon</span> will be distributed at the Congress Kit desk.</li>
					<li>The program book will be produced in PDF format; the printed version will be minimized.</li>
				</ul>

			</td>
		</tr>

		<tr>
			<td style="padding: 10px 30px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #fff;font-size: 20px;line-height: 25px;font-weight: bold;background-color: #314177;">
				How to Access the Virtual Platform
			</td>
		</tr>
		<tr>
			<td style="padding: 20px 30px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
				<div style="padding-bottom: 15px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 19px;line-height: 20px;font-weight: bold;">
					<img src="https://virtual.kcr4u.org/asset/mail/mail_bl.png" alt="" style="display: inline-block;vertical-align: top;border: 0 none;height: 20px;">&nbsp;Login Information
				</div>

				<table style="width:640px;max-width:640px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border-top: 2px solid #314177;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
					<tbody>
						<tr>
							<td style="width: 320px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								ID (E-mail)
							</td>
							<td style="width: 320px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								PW (Last Name)
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								<?=$arr['id']?>
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								<?=$arr['passwd']?>
							</td>
						</tr>
					</tbody>
				</table>

				<ul style="margin: 10px 0 0;padding: 0 0 0 14px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
					<li>It does not matter whether the letters are capitalized or small.</li>
					<li style="font-weight: bold;">Virtual Access is not available for purchase by 1 Day Pass participants.</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td style="padding: 0 76px 30px;font-size: 0;line-height: 0;">
				<a href="https://virtual.kcr4u.org/index.php" target="_blank" style="display: inline-block;vertical-align: top;border: 0 none;"><img src="https://virtual.kcr4u.org/asset/mail/mail_btn_eng.png" style="display: block;border: 0 none;" alt="Go to the Virtual Platform"></a>
				<a href="https://drive.google.com/file/d/1paRjPaoMIyEl1TdfN3sFQe-z0zPQb-lX/view?usp=sharing" target="_blank" style="display: inline-block;vertical-align: top;border: 0 none;"><img src="https://virtual.kcr4u.org/asset/mail/mail_btn_eng2.png" style="display: block;border: 0 none;" alt="User guideline for Virtual Platform"></a>
			</td>
		</tr>

		<tr>
			<td style="padding: 10px 30px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #fff;font-size: 20px;line-height: 25px;font-weight: bold;background-color: #314177;">
				Eco-Friendly KCR 2023
			</td>
		</tr>
		<tr>
			<td style="padding: 30px;">
				<table style="width:640px;max-width:640px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border: 0 none;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;word-break: keep-all;">
					<tbody>
						<tr>
							<td style="padding: 0 30px 0 0;">
								<img src="https://virtual.kcr4u.org/asset/mail/kcr_eco.png" alt="Eco-Friendly KCR 2023" style="display:block;border:0 none;" />
							</td>
							<td style="padding: 0;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;text-align: justify; ">
								<strong style="color: #e47603;">KCR 2023 will be held as an eco-friendly congress.</strong><br><br>
								
								The Korean Society of Radiology seeks to lead the way in organizing an eco-friendly congress as well as raise the awareness of participants.<br><br>
								
								As part of our active efforts, we have created the Eco-friendly KCR emblem to be used throughout KCR 2023.<br><br>
								
								We encourage all participants to join us in holding an Eco-friendly KCR.
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 30px 0 0;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
								<div style="font-weight: bold;color: #4d1cbe;">[Actions]</div>
								<ol style="margin: 0;padding: 0 0 0 14px;">
									<li>The program book will be produced in PDF format; the printed version will be minimized.</li>
									<li>Production of banners in PVC will be avoided and recyclable materials used instead whenever possible.</li>
									<li>Name tags and lanyards will be made of paper and printed using environmentally friendly methods.</li>
									<li>Participants are recommended to use a tumbler.</li>
								</ol>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td style="height:150px;padding: 0;">
				<img src="https://virtual.kcr4u.org/asset/mail/mail_footer.png" alt="KCR Secretariat" style="display:block;border:0 none;" usemap="#Map" />
				<map name="Map" id="Map">
				  <area shape="rect" coords="75,112,162,128" target="_blank" href="ask@kcr4u.org" />
				  <area shape="rect" coords="223,112,278,128" target="_blank" href="https://www.kcr4u.org/" />
				  <area shape="rect" coords="318,112,376,128" target="_blank" href="https://www.facebook.com/kcr4u" />
				  <area shape="rect" coords="380,112,437,128" target="_blank" href="https://www.instagram.com/kcr4u/" />
				  <area shape="rect" coords="444,112,484,128" target="_blank" href="https://twitter.com/i/flow/login?redirect_after_login=%2Fkcr4u" />
				</map>
			</td>
		</tr>
	</tbody>
</table>

</body>
</html>
<?
$html .= ob_get_contents(); //파일내용 변수에 저장
ob_end_clean(); //출력 버퍼 지우고 출력 버퍼링 종료
return $html;
}
?>