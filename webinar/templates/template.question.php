<!-- <?
function template($arr){
	ob_start(); //출력 버퍼링 활성
	global $_CONFIG;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IMKASID 2022</title>
</head>

<body style="margin: 0; padding: 0;">
<table style="font-family: 'Calibri', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;width:650px;max-width:650px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;">
	<tbody>
		<tr>
			<td style="height:160px;padding: 0;">
				<img src="<?=$_CONFIG['URL']?>/asset/layout/mail_header.png" alt="IMKASID 2022" style="display:block;border:0 none;" />
			</td>
		</tr>
		<tr>
			<td style="padding: 20px 20px 5px;font-family: 'Calibri', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #222;font-size: 22px;line-height: 40px;font-weight: bold;">
				Dear. <?=$arr['name_kr']?>
			</td>
		</tr>
		<tr>
			<td style="padding:0 20px;font-family: 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
				<table style="width:610px;border-collapse: collapse;">
					<tbody>
						<tr>
							<td style="padding: 25px 50px;background-color: #fef5ef;font-size: 17px;line-height: 28px;color: #333;font-family: 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
								<?=$arr['session_question']?>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td style="padding: 40px 200px 130px;">
				<a href="<?=$_CONFIG['URL']?>" target="_blank" style="display: block;border: 0 none;"><img src="<?=$_CONFIG['URL']?>/asset/layout/mail_btn.png" style="display: block;border: 0 none;" alt="Go to IMKASID 2022"></a>
			</td>
		</tr>
		<tr>
			<td style="height:100 px;padding: 0;">
				<img src="<?=$_CONFIG['URL']?>/asset/layout/mail_footer.png" alt="IMKASID 2022 Secretariat Tel. +82-2-6411-7380, 7311   l   Fax. +82-2-6411-7399   l   Email. imkasid@innon.co.kr" style="display:block;border:0 none;" />
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
?> -->