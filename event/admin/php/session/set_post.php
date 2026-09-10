<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select count(*) cnt from session_set_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);


$cnt = $row['cnt'];

if(!$_POST['glance_height']) {
	$_POST['glance_height']="144";
}
if(!$_POST['glance_width']) {
	$_POST['glance_width']="120";
}


if($cnt>0)
{
	$query = "update session_set_tbl SET ";

	$query .= " chair='".$_POST['chair']."'";
	$query .= ", chair2='".$_POST['chair2']."'";
	$query .= ", panel='".$_POST['panel']."'";
	$query .= ", discusser='".$_POST['discusser']."'";
	$query .= ", speaker='".$_POST['speaker']."'";
	$query .= ", etc_faculty='".$_POST['etc_faculty']."'";
	$query .= ", selected_box='".$_POST['selected_box']."'";

	$query .= ", faculty_style_chair='".$_POST['faculty_style_chair']."'";
	$query .= ", faculty_style_speaker='".$_POST['faculty_style_speaker']."'";
	$query .= ", faculty_style_speaker_gubun='".$_POST['faculty_style_speaker_gubun']."'";
	$query .= ", glance_view_style='".$_POST['glance_view_style']."'";
	
	

	$query .= ", category1='".$_POST['category1']."'";
	$query .= ", category2='".$_POST['category2']."'";
	$query .= ", theme='".$_POST['theme']."'";
	$query .= ", sub_theme='".$_POST['sub_theme']."'";

	$query .= ", session_title_style='".$_POST['session_title_style']."'";
	$query .= ", session_title_txt='".$_POST['session_title_txt']."'";
	
	$query .= ", title='".$_POST['title']."'";

	$query .= ", abs_sid='".$_POST['abs_sid']."'";
	$query .= ", abs_no='".$_POST['abs_no']."'";
	$query .= ", abs_info='".$_POST['abs_info']."'";
	$query .= ", purpose='".$_POST['purpose']."'";
	$query .= ", methods='".$_POST['methods']."'";
	$query .= ", memo='".$_POST['memo']."'";
	$query .= ", memo_type='".$_POST['memo_type']."'";
	$query .= ", session_question='".$_POST['session_question']."'";
	$query .= ", session_evaluation='".$_POST['session_evaluation']."'";
	$query .= ", isshare='".$_POST['isshare']."'";

	$query .= ", qna_sesstion_style='".$_POST['qna_sesstion_style']."'";
	$query .= ", qna_lecture_style='".$_POST['qna_lecture_style']."'";
	
	$query .= ", evaluation='".$_POST['evaluation']."'";
	$query .= ", islike='".$_POST['islike']."'";
	$query .= ", sub_favor='".$_POST['sub_favor']."'";
	
	$query .= ", results='".$_POST['results']."'";
	$query .= ", conclusions='".$_POST['conclusions']."'";
	$query .= ", keywords='".$_POST['keywords']."'";
	$query .= ", category_view='".$_POST['category_view']."'";
	$query .= ", faculty_type='".$_POST['faculty_type']."'";
	/*
	$query .= ", faculty_style='".$_POST['faculty_style']."'";
	$query .= ", faculty_style1='".$_POST['faculty_style1']."'";
	*/
	$query .= ", faculty_style2='".$_POST['faculty_style2']."'";
	$query .= ", glance_height='".$_POST['glance_height']."'";
	$query .= ", glance_width='".$_POST['glance_width']."'";
	$query .= ", glance_full='".$_POST['glance_full']."'";
	$query .= ", bullet_type='".$_POST['bullet_type']."'";
	$query .= ", bullet_txt_kor='".$_POST['bullet_txt_kor']."'";
	$query .= ", bullet_txt_eng='".$_POST['bullet_txt_eng']."'";


	$query .= ", session_top_txt='".$_POST['session_top_txt']."'";

	
	
	$query .= ", program_view_type='".$_POST['program_view_type']."'";
	$query .= ", category_text_font='".$_POST['category_text_font']."'";
	$query .= ", sub_theme_type='".$_POST['sub_theme_type']."'";
	
	$query .= ", bottom_menu='".$_POST['bottom_menu']."'";

	$query .= ", bottom_menu_now='".$_POST['bottom_menu_now']."'";
	$query .= ", bottom_menu_program='".$_POST['bottom_menu_program']."'";
	$query .= ", bottom_menu_glance='".$_POST['bottom_menu_glance']."'";
	$query .= ", bottom_menu_myfav='".$_POST['bottom_menu_myfav']."'";
	$query .= ", bottom_menu_category='".$_POST['bottom_menu_category']."'";
	$query .= ", session_show='".$_POST['session_show']."'";

	
	
	$query .= ", alarm='".$_POST['alarm']."'";
	$query .= ", speaker_info='".$_POST['speaker_info']."'";

	

	$query .= ", day_type='".$_POST['day_type']."'";
	$query .= ", time_type='".$_POST['time_type']."'";
	$query .= ", glance_type='".$_POST['glance_type']."'";
	$query .= ", cv_file='".$_POST['cv_file']."'";

	$query .= ", etc_speaker='".$_POST['etc_speaker']."'";
	$query .= ", language='".$_POST['language']."'";
	$query .= ", session_etc_info='".$_POST['session_etc_info']."'";
	//$query .= ", glance_view_type='".$_POST['glance_view_type']."'";

	$query .= " where code='".$code."'";
}
else
{

	$query = "INSERT INTO session_set_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ", chair='".$_POST['chair']."'";
	$query .= ", chair2='".$_POST['chair2']."'";
	$query .= ", panel='".$_POST['panel']."'";
	$query .= ", discusser='".$_POST['discusser']."'";
	$query .= ", speaker='".$_POST['speaker']."'";
	$query .= ", etc_faculty='".$_POST['etc_faculty']."'";
	$query .= ", selected_box='".$_POST['selected_box']."'";


	$query .= ", faculty_style_chair='".$_POST['faculty_style_chair']."'";
	$query .= ", faculty_style_speaker='".$_POST['faculty_style_speaker']."'";
	$query .= ", faculty_style_speaker_gubun='".$_POST['faculty_style_speaker_gubun']."'";
	$query .= ", glance_view_style='".$_POST['glance_view_style']."'";

	$query .= ", category1='".$_POST['category1']."'";
	$query .= ", category2='".$_POST['category2']."'";
	$query .= ", theme='".$_POST['theme']."'";
	$query .= ", sub_theme='".$_POST['sub_theme']."'";
	$query .= ", title='".$_POST['title']."'";

	$query .= ", session_title_style='".$_POST['session_title_style']."'";
	$query .= ", session_title_txt='".$_POST['session_title_txt']."'";

	$query .= ", abs_sid='".$_POST['abs_sid']."'";
	$query .= ", abs_no='".$_POST['abs_no']."'";
	$query .= ", abs_info='".$_POST['abs_info']."'";
	$query .= ", purpose='".$_POST['purpose']."'";
	$query .= ", methods='".$_POST['methods']."'";
	$query .= ", memo='".$_POST['memo']."'";
	$query .= ", memo_type='".$_POST['memo_type']."'";
	$query .= ", session_question='".$_POST['session_question']."'";
	$query .= ", session_evaluation='".$_POST['session_evaluation']."'";
	$query .= ", isshare='".$_POST['isshare']."'";

	$query .= ", qna_sesstion_style='".$_POST['qna_sesstion_style']."'";
	$query .= ", qna_lecture_style='".$_POST['qna_lecture_style']."'";

	$query .= ", evaluation='".$_POST['evaluation']."'";
	$query .= ", islike='".$_POST['islike']."'";
	$query .= ", sub_favor='".$_POST['sub_favor']."'";
	$query .= ", session_top_txt='".$_POST['session_top_txt']."'";

	$query .= ", results='".$_POST['results']."'";
	$query .= ", conclusions='".$_POST['conclusions']."'";
	$query .= ", keywords='".$_POST['keywords']."'";
	$query .= ", category_view='".$_POST['category_view']."'";
	$query .= ", faculty_type='".$_POST['faculty_type']."'";
	/*
	$query .= ", faculty_style='".$_POST['faculty_style']."'";
	$query .= ", faculty_style1='".$_POST['faculty_style1']."'";
	*/
	$query .= ", faculty_style2='".$_POST['faculty_style2']."'";
	$query .= ", bottom_menu='".$_POST['bottom_menu']."'";
	$query .= ", bottom_menu_now='".$_POST['bottom_menu_now']."'";
	$query .= ", bottom_menu_program='".$_POST['bottom_menu_program']."'";
	$query .= ", bottom_menu_glance='".$_POST['bottom_menu_glance']."'";
	$query .= ", bottom_menu_myfav='".$_POST['bottom_menu_myfav']."'";
	$query .= ", bottom_menu_category='".$_POST['bottom_menu_category']."'";
	$query .= ", session_show='".$_POST['session_show']."'";

	$query .= ", alarm='".$_POST['alarm']."'";
	$query .= ", speaker_info='".$_POST['speaker_info']."'";
	$query .= ", glance_height='".$_POST['glance_height']."'";
	$query .= ", glance_width='".$_POST['glance_width']."'";
	$query .= ", glance_full='".$_POST['glance_full']."'";
	$query .= ", bullet_type='".$_POST['bullet_type']."'";
	$query .= ", bullet_txt_kor='".$_POST['bullet_txt_kor']."'";
	$query .= ", bullet_txt_eng='".$_POST['bullet_txt_eng']."'";

	$query .= ", program_view_type='".$_POST['program_view_type']."'";
	$query .= ", category_text_font='".$_POST['category_text_font']."'";
	$query .= ", sub_theme_type='".$_POST['sub_theme_type']."'";


	$query .= ", day_type='".$_POST['day_type']."'";
	$query .= ", time_type='".$_POST['time_type']."'";
	$query .= ", glance_type='".$_POST['glance_type']."'";
	$query .= ", cv_file='".$_POST['cv_file']."'";

	$query .= ", etc_speaker='".$_POST['etc_speaker']."'";
	$query .= ", language='".$_POST['language']."'";
	$query .= ", session_etc_info='".$_POST['session_etc_info']."'";
	//$query .= ", glance_view_type='".$_POST['glance_view_type']."'";

}

//echo $query;exit;
mysqli_query($conn, $query);

?>
<script>
	opener.location.reload();
	window.close();
</script>