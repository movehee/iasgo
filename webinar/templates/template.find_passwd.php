<?
function template($arr){
	ob_start(); //출력 버퍼링 활성
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KCR 2023</title>
</head>

<body style="margin: 0; padding: 0;">
<table style="width:700px;max-width:700px; margin: 0 auto;padding:0;border-collapse: collapse;border-spacing:0;border: 1px solid #ddd;font-family: 'Calibri', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
	<tbody>
		<tr>
			<td style="height:180px;padding: 0;">
				<img src="https://virtual.kcr4u.org/asset/layout/mail_header.png" alt="KCR 2023 Virtual Congress" style="display:block;border:0 none;" />
			</td>
		</tr>

        <tr>
			<td style="padding: 20px 30px 5px;font-family: 'Calibri', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #222;font-size: 16px;line-height: 25px;">
				<span style="line-height: 40px; font-weight: bold;">Dear. <?=$arr['name_eng'] ? $arr['name_eng'] : $arr['name_eng']?></span>				
			</td>
		</tr>
		<tr>
			<td style="padding: 0 30px 5px;font-family: 'Calibri', 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;color: #222;font-size: 16px;line-height: 25px;">
				Your password is <span style="color: #ec2a2a;"><?=$arr['passwd']?></span><br>
				Please log in after accessing the site
			</td>
		</tr>
		
		<tr>
			<td style="padding:30px;font-family: 'Malgun Gothic', '맑은고딕', '돋움', 'dotum', sans-serif;">
				<table style="width:640px;min-width:640px;margin: 0;border-top:2px solid #222;padding:0;border-collapse: collapse;border-spacing:0;">
					<tbody>
						<tr>
							<td style="width: 200px;padding: 10px 0 10px 20px;border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;background-color: #f5f5f5;color: #222;font-family: 'Callibri', 'Malgun Gothic', sans-serif;font-size: 16px; font-weight: bold;">
								*ID(Email Address)
							</td>
							<td style="padding: 10px;border-bottom: 1px solid #ddd;color: #222;font-family: 'Callibri', 'Malgun Gothic', sans-serif; font-size: 16px;">			
                                <?=$arr['id']?>
							</td>
						</tr>
						<tr>
							<td style="padding: 10px 0 10px 20px;border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;background-color: #f5f5f5;color: #222;font-family: 'Callibri', 'Malgun Gothic', sans-serif;font-size: 16px; font-weight: bold;">
								*Password
							</td>
							<td style="padding: 10px;border-bottom: 1px solid #ddd;color: #222;font-family: 'Callibri', 'Malgun Gothic', sans-serif; font-size: 16px;">			
                                <?=$arr['passwd']?>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
        
		<tr>
			<td style="padding: 40px 190px;">
				<a href="https://virtual.kcr4u.org/index.php" style="display: block;border: 0 none;"><img src="https://virtual.kcr4u.org/asset/layout/mail_btn.png" style="display: block;border: 0 none;" alt="KCR 2023 Virtual Congress"></a>
			</td>
		</tr>
		<tr>
			<td style="height:150px;padding: 0;">
				<img src="https://virtual.kcr4u.org/asset/layout/mail_footer.png" alt="KCR Secretariat" style="display:block;border:0 none;" />
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