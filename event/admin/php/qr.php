<html>
<body>
<script src="https://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="/admin/script/jquery.qrcode.js"></script>
<script type="text/javascript" src="/admin/script/qrcode.js"></script>
<style>
 
.logo{text-align: center; margin:30px 0 30px;}
.qrborder{width: 400px; border:8px solid #203365 ; text-align: center; margin:0 auto}
.qrtext{ text-align: center; font-size:25px; font-weight: bold;}
</style>

<p class="logo"><img  src="../../image/qr_logo.png"></p>
<div id="gcDiv" class="qrborder"></div>
<p class="qrtext"><a href="http://ezv.kr?<?=$code?>" target="_NEW">http://ezv.kr?<?=$code?></a></p>
<script>
    jQuery("#gcDiv").qrcode({   //qrcode 시작
        render : "canvas",      //table, canvas 형식 두 종류가 있다. 
        width : 400,            //넓이 조절
        height : 400,           //높이 조절
        text   : "http://ezv.kr?<?=$code?>"     //QR코드에 실릴 문자열
    });
</script>
 
</body>
</html>
