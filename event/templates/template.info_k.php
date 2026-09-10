<?
function template_k($arr){
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
			<td style="padding: 30px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;font-weight: bold;letter-spacing: -0.5px;">
				<?=$arr['name_kr']?> 선생님께,<br><br>

				안녕하세요. 제 79차 대한영상의학회 학술대회 (KCR 2023) 사무국입니다.<br><br>

				KCR 2023이 9월 20일(수)부터 23일(토)까지 서울 코엑스에서 개최됩니다.<br><br>

				아래 QR 코드 등록 정보는 카카오톡 알림톡으로도 발송 될 예정이며, 
				<span style="color: #db1d1d;">본 이메일 또는 카카오톡 알림톡을 학술대회 당일에 지참하여 등록데스크로 오시면, 더욱 빠르게 네임택을 받으실 수 있습니다.</span>
			</td>
		</tr>

		<tr>
			<td style="padding: 12px 30px 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #fff;font-size: 18px;line-height: 20px;font-weight: bold;background-color: #314177;">
				현장 참가 방법
			</td>
		</tr>
		<tr>
			<td style="padding: 20px 30px 50px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
				<div style="padding-bottom: 15px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 19px;line-height: 20px;font-weight: bold;">
					<img src="https://virtual.kcr4u.org/asset/mail/mail_bl.png" alt="" style="display: inline-block;vertical-align: top;border: 0 none;">&nbsp;개인 등록 사항
				</div>

				<table style="width:640px;max-width:640px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border-top: 2px solid #314177;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
					<tbody>
						<tr>
							<td style="width: 180px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								등록번호
							</td>
							<td style="width: 260px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;">
								<?=$arr['etc_field2']?>
							</td>
							<td rowspan="7" style="width: 200px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;vertical-align: middle;text-align: center;">
								<?if($arr['qr_number']){?>
								<img src="https://kcr4u-event.ezv.kr/upload/qr/<?=$arr['qr_number']?>.png" >
								<?}?>
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								성명
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;">
								<?=$arr['name_kr']?>
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								소속
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;">
								<?=$arr['aff_kor']?>
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								면허 번호
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;">
							<?=$arr['license_number']?>

							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #db1d1d;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								등록데스크 세부 위치
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;">
								<?=$arr['etc_field7']?>
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								리본 안내
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;">
								<?=$arr['etc_field6']?>
							</td>
						</tr>
					</tbody>
				</table>

				<ul style="margin: 10px 0 0;padding: 0 0 0 14px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
					<li><strong style="text-decoration: underline;font-weight: bold;">QR 코드 지참</strong>하시어 해당 <span style="color: #db1d1d;font-weight: bold;">등록 데스크 세부 위치</span>에서 네임택 수령 및 발급 부탁드립니다.</li>
				</ul>
				<br><br>


				<div style="padding-bottom: 15px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 19px;line-height: 20px;font-weight: bold;">
					<img src="https://virtual.kcr4u.org/asset/mail/mail_bl.png" alt="" style="display: inline-block;vertical-align: top;border: 0 none;">&nbsp;등록 데스크 운영 일정
				</div>

				<table style="width:640px;max-width:640px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border-top: 2px solid #314177;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
					<tbody>
						<tr>
							<td style="width: 320px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								운영 일시
							</td>
							<td style="width: 320px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								장소
							</td>
						</tr>
						<tr>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								9월 20일(수) ~ 23일(토), 07:00-17:30
							</td>
							<td style="padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								코엑스 1층 그랜드볼룸 좌측 로비
							</td>
						</tr>
					</tbody>
				</table>

				<br><br>


				<div style="padding-bottom: 15px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 19px;line-height: 20px;font-weight: bold;">
					<img src="https://virtual.kcr4u.org/asset/mail/mail_bl.png" alt="" style="display: inline-block;vertical-align: top;border: 0 none;">&nbsp;등록 데스크 안내
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
								On-site<br>registration
							</td>
							<td style="width: 128px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								Kiosk
							</td>
							<td style="width: 128px;padding: 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: center;">
								Congress<br> Kit Desk
							</td>
						</tr>
						<tr>
							<td style="padding: 10px 5px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								초청자
							</td>
							<td style="padding: 10px 5px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								수상 대상자,<br>
								등록비 미납자 <br>
								및 환불 대상자
							</td>
							<td style="padding: 10px 5px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								현장 등록자
							</td>
							<td style="padding: 10px 5px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								사전등록비를 <br>완납한 일반 <br>참가자
							</td>
							<td style="padding: 10px 5px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;text-align: center;">
								Congress Bag, <br>Social Program Tickets, 리본 수령
							</td>
						</tr>
					</tbody>
				</table>

				<ul style="margin: 10px 0 0;padding: 0 0 0 14px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
					<li><strong style="text-decoration: underline;font-weight: bold;">Congress Bag, Social Program Tickets, 식단 쿠폰, 리본의 경우,</strong> Congress Kit Desk에서 배부할 예정입니다.</li>
					<li>Eco-Friendly KCR 2023을 위해 프로그램북 인쇄를 최소화할 예정입니다. KCR 2023 홈페이지 및 Virtual Platform에서 다운로드 가능한 점 참고 바랍니다.</li>
				</ul>
			</td>
		</tr>

		<tr>
			<td style="padding: 12px 30px 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #fff;font-size: 18px;line-height: 20px;font-weight: bold;background-color: #314177;">
				Virtual Platform 참가 방법
			</td>
		</tr>
		<tr>
			<td style="padding: 20px 30px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
				<div style="padding-bottom: 15px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 19px;line-height: 20px;font-weight: bold;">
					<img src="https://virtual.kcr4u.org/asset/mail/mail_bl.png" alt="" style="display: inline-block;vertical-align: top;border: 0 none;">&nbsp;Virtual Platform 로그인 정보
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
					<li><span style="font-weight: bold;">Live Session은 Virtual Access 구매자만 수강 가능합니다.</span></li>
					<li>Password 대문자 소문자 상관없이 기입 부탁드립니다.</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td style="padding: 0 76px 50px;">
				<a href="https://virtual.kcr4u.org/index.php" target="_blank" style="display: inline-block;vertical-align: top;border: 0 none;"><img src="https://virtual.kcr4u.org/asset/mail/mail_btn.png" style="display: block;border: 0 none;" alt="Virtual Platform 바로가기"></a>
				&nbsp;&nbsp;
				<a href="https://drive.google.com/file/d/1g0brXUTjwFU5dHEbvPx1VQ4x_rFkTM5L/view?usp=sharing" target="_blank" style="display: inline-block;vertical-align: top;border: 0 none;"><img src="https://virtual.kcr4u.org/asset/mail/mail_btn2.png" style="display: block;border: 0 none;" alt="Virtual Platform 가이드라인 바로가기"></a>
			</td>
		</tr>

		<tr>
			<td style="padding: 12px 30px 10px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #fff;font-size: 18px;line-height: 20px;font-weight: bold;background-color: #314177;">
				대회 관련 정보 안내
			</td>
		</tr>
		<tr>
			<td style="padding: 20px 30px 50px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
				<div style="font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 19px;line-height: 20px;font-weight: bold;">
					<img src="https://virtual.kcr4u.org/asset/mail/mail_bl.png" alt="" style="display: inline-block;vertical-align: top;border: 0 none;">&nbsp;KCR 2023 평점 안내
				</div>
				<ul style="margin: 10px 0 0;padding: 0 0 0 14px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;letter-spacing: -0.5px;">
					<li>연수 평점은 세션 참석한 시간에 따라 이수 가능한 평점이 달라집니다.</li>
					<li>현장 참가자는 세션에 참석한 시간을 확인하기 위해 반드시 <span style="color: #db1d1d;">세션 시작과 종료 시 강의장에 위치한 QR 코드 리더기에 네임택을 태그 하시기 바랍니다. (1일 2회 이상)</span></li>
					<li>Virtual Access 참가자는 세션 시작과 종료 시 <span style="color: #db1d1d;">온라인 강의실 내 입장/퇴장 버튼을 클릭해야 합니다.</span></li>
					<li>온라인 평점은 Virtual Access 결제자에 한해 제공되며 당일 세션이 모두 종료된 2시간 이후부터 확인 <br>가능합니다. </li>
					<li>필수평점은 코엑스 현장에서만 관람이 가능합니다. 필수평점 이수 시에 참고 바랍니다.</li>
					<li>필수평점교육 당일 일반 평점 인정 기준은 하기 내용 확인 바랍니다.</li>
					<li>일일등록자는 Virtual Platform 입장이 불가합니다.</li>
				</ul><br>

				<table style="width:640px;max-width:640px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border-top: 2px solid #314177;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
					<tbody>
						<tr>
							<td style="width: 180px;padding: 10px 10px 10px 40px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;box-sizing: border-box;">
								취득 가능 평점
							</td>
							<td style="padding: 10px 20px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;">
								<span style="font-weight: bold;">1일 최대 6평점, 4일 총 24평점</span><br>
								단 9월 23일(토) 평점 기준은 하기와 같습니다.<br>
								→ 필수평점 2평점 이수 시, 일반평점 최대 4평점까지 이수 가능<br>
								→ 필수평점 1평점 이수 시, 일반평점 최대 5평점까지 이수 가능<br>
								→ 필수평점 미 이수 시, 일반평점 최대 6평점까지 이수 가능
							</td>
						</tr>
						<tr>
							<td style="padding: 10px 10px 10px 40px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;background-color: #f4f7fa;font-weight: bold;text-align: left;">
								평점 지급 기준
							</td>
							<td style="padding: 10px 20px;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;border-bottom: 1px solid #ccc;color: #0d1729;font-size: 14px;line-height: 20px;">
								<span style="font-weight: bold;">[세션 수강 시간 기준]</span><br>
								→ 1시간 이상 – 2시간 미만: 1평점<br>
								→ 2시간 이상 – 3시간 미만: 2평점<br>
								→ 3시간 이상 – 4시간 미만: 3평점<br>
								→ 4시간 이상 – 5시간 미만: 4평점<br>
								→ 5시간 이상 – 6시간 미만: 5평점<br>
								→ 6시간 이상: 6평점
							</td>
						</tr>
					</tbody>
				</table>
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
							<td style="padding: 0;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;text-align: justify;">
								<strong style="color: #e47603;">KCR 2023은 친환경 학술대회로 진행될 예정입니다.</strong><br><br>
								
								대한영상의학회는 친환경 학술대회를 주최하여 참가자들의 인식을 높이는데 앞장서고 있습니다.<br><br>
								
								이러한 노력의 일환으로, KCR 2023 대회 기간 동안 사용될 친환경 KCR 엠블럼을 만들었습니다.<br><br>
								
								KCR 2023 참가자분들께서도 친환경 KCR 2023에 동참해 주시기를 바랍니다.
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 30px 0 0;font-family: 'Arial', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #0d1729;font-size: 14px;line-height: 20px;">
								<div style="font-weight: bold;color: #4d1cbe;">[Actions]</div>
								<ol style="margin: 0;padding: 0 0 0 14px;">
									<li>프로그램북은 PDF 형식으로 제공되며 인쇄본은 최소화 될 예정입니다.</li>
									<li>가능한 경우 PVC 형식의 배너 사용을 피하고, 재활용 가능한 자원을 활용하여 제작할 예정입니다.</li>
									<li>참가자의 네임택과 랜야드는 종이로 제작되며, 친환경 방식으로 인쇄될 예정입니다.</li>
									<li>참가자들께서는 텀블러를 사용하실 것을 권장 드립니다.</li>
								</ol>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
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