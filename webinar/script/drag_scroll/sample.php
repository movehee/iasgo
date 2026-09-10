<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="style.css">
<title>jQuery Drag To Scroll Plugin</title>
</head>

<body>
        <div class="container" style="width:900px;height:600px;">
            <div class="scroller" style="width:900px;height:600px;">
                <div class="wrapper">
					<?include $DOCUMENT_ROOT."/play/load/program/day3.php"?>
				</div>
            </div>
        </div>
</body>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script src="dragScroll.js"></script>
<script>

    var $container = $(".container");
    var $scroller = $(".scroller");
    var $wrapper = $(".wrapper");

   

    bindDragScroll($container, $scroller);

</script>
</html>