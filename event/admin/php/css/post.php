<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select count(*) cnt from css_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);


$cnt = $row['cnt'];

if(substr($_POST['menu_bg_on'],0,1)!="#" && strlen($_POST['menu_bg_on'])>2){
	$_POST['menu_bg_on'] = "#".$_POST['menu_bg_on'];
}
if(substr($_POST['menu_bg'],0,1)!="#" && strlen($_POST['menu_bg'])>2){
	$_POST['menu_bg'] = "#".$_POST['menu_bg'];
}
if(substr($_POST['menu_font_on'],0,1)!="#" && strlen($_POST['menu_font_on'])>2){
	$_POST['menu_font_on'] = "#".$_POST['menu_font_on'];
}
if(substr($_POST['menu_font'],0,1)!="#" && strlen($_POST['menu_font'])>2){
	$_POST['menu_font'] = "#".$_POST['menu_font'];
}
if(substr($_POST['question_bg'],0,1)!="#" && strlen($_POST['question_bg'])>2){
	$_POST['question_bg'] = "#".$_POST['question_bg'];
}
if(substr($_POST['question_font'],0,1)!="#" && strlen($_POST['question_font'])>2){
	$_POST['question_font'] = "#".$_POST['question_font'];
}
if(substr($_POST['feedback_bg_bold'],0,1)!="#" && strlen($_POST['feedback_bg_bold'])>2){
	$_POST['feedback_bg_bold'] = "#".$_POST['feedback_bg_bold'];
}
if(substr($_POST['feedback_font_bold'],0,1)!="#" && strlen($_POST['feedback_font_bold'])>2){
	$_POST['feedback_font_bold'] = "#".$_POST['feedback_font_bold'];
}
if(substr($_POST['feedback_bg'],0,1)!="#" && strlen($_POST['feedback_bg'])>2){
	$_POST['feedback_bg'] = "#".$_POST['feedback_bg'];
}
if(substr($_POST['feedback_font'],0,1)!="#" && strlen($_POST['feedback_font'])>2){
	$_POST['feedback_font'] = "#".$_POST['feedback_font'];
}
if(substr($_POST['feedback_btn'],0,1)!="#" && strlen($_POST['feedback_btn'])>2){
	$_POST['feedback_btn'] = "#".$_POST['feedback_btn'];
}
if(substr($_POST['feedback_btn_font'],0,1)!="#" && strlen($_POST['feedback_btn_font'])>2){
	$_POST['feedback_btn_font'] = "#".$_POST['feedback_btn_font'];
}
if(substr($_POST['feedback_font2'],0,1)!="#" && strlen($_POST['feedback_font2'])>2){
	$_POST['feedback_font2'] = "#".$_POST['feedback_font2'];
}
if(substr($_POST['feedback_send'],0,1)!="#" && strlen($_POST['feedback_send'])>2){
	$_POST['feedback_send'] = "#".$_POST['feedback_send'];
}
if(substr($_POST['feedback_send_border'],0,1)!="#" && strlen($_POST['feedback_send_border'])>2){
	$_POST['feedback_send_border'] = "#".$_POST['feedback_send_border'];
}

if(substr($_POST['agenda_bg1'],0,1)!="#" && strlen($_POST['agenda_bg1'])>2){
	$_POST['agenda_bg1'] = "#".$_POST['agenda_bg1'];
}
if(substr($_POST['agenda_bg2'],0,1)!="#" && strlen($_POST['agenda_bg2'])>2){
	$_POST['agenda_bg2'] = "#".$_POST['agenda_bg2'];
}
if(substr($_POST['agenda_bg3'],0,1)!="#" && strlen($_POST['agenda_bg3'])>2){
	$_POST['agenda_bg3'] = "#".$_POST['agenda_bg3'];
}

if(substr($_POST['agenda_bg1_on'],0,1)!="#" && strlen($_POST['agenda_bg1_on'])>2){
	$_POST['agenda_bg1_on'] = "#".$_POST['agenda_bg1_on'];
}
if(substr($_POST['agenda_bg2_on'],0,1)!="#" && strlen($_POST['agenda_bg2_on'])>2){
	$_POST['agenda_bg2_on'] = "#".$_POST['agenda_bg2_on'];
}
if(substr($_POST['agenda_bg3_on'],0,1)!="#" && strlen($_POST['agenda_bg3_on'])>2){
	$_POST['agenda_bg3_on'] = "#".$_POST['agenda_bg3_on'];
}

if(substr($_POST['agenda_font1'],0,1)!="#" && strlen($_POST['agenda_font1'])>2){
	$_POST['agenda_font1'] = "#".$_POST['agenda_font1'];
}
if(substr($_POST['agenda_font2'],0,1)!="#" && strlen($_POST['agenda_font2'])>2){
	$_POST['agenda_font2'] = "#".$_POST['agenda_font2'];
}
if(substr($_POST['agenda_font3'],0,1)!="#" && strlen($_POST['agenda_font3'])>2){
	$_POST['agenda_font3'] = "#".$_POST['agenda_font3'];
}

if(substr($_POST['agenda_font1_on'],0,1)!="#" && strlen($_POST['agenda_font1_on'])>2){
	$_POST['agenda_font1_on'] = "#".$_POST['agenda_font1_on'];
}
if(substr($_POST['agenda_font2_on'],0,1)!="#" && strlen($_POST['agenda_font2_on'])>2){
	$_POST['agenda_font2_on'] = "#".$_POST['agenda_font2_on'];
}
if(substr($_POST['agenda_font3_on'],0,1)!="#" && strlen($_POST['agenda_font3_on'])>2){
	$_POST['agenda_font3_on'] = "#".$_POST['agenda_font3_on'];
}


if(substr($_POST['session_category_font'],0,1)!="#" && strlen($_POST['session_category_font'])>2){
	$_POST['session_category_font'] = "#".$_POST['session_category_font'];
}
if(substr($_POST['abs_no_font'],0,1)!="#" && strlen($_POST['abs_no_font'])>2){
	$_POST['abs_no_font'] = "#".$_POST['abs_no_font'];
}
if(substr($_POST['abs_sid_font'],0,1)!="#" && strlen($_POST['abs_sid_font'])>2){
	$_POST['abs_sid_font'] = "#".$_POST['abs_sid_font'];
}
if(substr($_POST['session_theme_font'],0,1)!="#" && strlen($_POST['session_theme_font'])>2){
	$_POST['session_theme_font'] = "#".$_POST['session_theme_font'];
}
if(substr($_POST['session_title_font'],0,1)!="#" && strlen($_POST['session_title_font'])>2){
	$_POST['session_title_font'] = "#".$_POST['session_title_font'];
}
if(substr($_POST['glance_theme_font'],0,1)!="#" && strlen($_POST['glance_theme_font'])>2){
	$_POST['glance_theme_font'] = "#".$_POST['glance_theme_font'];
}

if(substr($_POST['session_chair_font'],0,1)!="#" && strlen($_POST['session_chair_font'])>2){
	$_POST['session_chair_font'] = "#".$_POST['session_chair_font'];
}
if(substr($_POST['session_speaker_font'],0,1)!="#" && strlen($_POST['session_speaker_font'])>2){
	$_POST['session_speaker_font'] = "#".$_POST['session_speaker_font'];
}
if(substr($_POST['session_favor'],0,1)!="#" && strlen($_POST['session_favor'])>2){
	$_POST['session_favor'] = "#".$_POST['session_favor'];
}
if(substr($_POST['session_lecture'],0,1)!="#" && strlen($_POST['session_lecture'])>2){
	$_POST['session_lecture'] = "#".$_POST['session_lecture'];
}
if(substr($_POST['session_abstract'],0,1)!="#" && strlen($_POST['session_abstract'])>2){
	$_POST['session_abstract'] = "#".$_POST['session_abstract'];
}
if(substr($_POST['session_cv'],0,1)!="#" && strlen($_POST['session_cv'])>2){
	$_POST['session_cv'] = "#".$_POST['session_cv'];
}
if(substr($_POST['session_memo'],0,1)!="#" && strlen($_POST['session_memo'])>2){
	$_POST['session_memo'] = "#".$_POST['session_memo'];
}

if(substr($_POST['session_evaluation'],0,1)!="#" && strlen($_POST['session_evaluation'])>2){
	$_POST['session_evaluation'] = "#".$_POST['session_evaluation'];
}


if(substr($_POST['session_bar_bg'],0,1)!="#" && strlen($_POST['session_bar_bg'])>2){
	$_POST['session_bar_bg'] = "#".$_POST['session_bar_bg'];
}
if(substr($_POST['session_select_bg'],0,1)!="#" && strlen($_POST['session_select_bg'])>2){
	$_POST['session_select_bg'] = "#".$_POST['session_select_bg'];
}
if(substr($_POST['session_select_font'],0,1)!="#" && strlen($_POST['session_select_font'])>2){
	$_POST['session_select_font'] = "#".$_POST['session_select_font'];
}
if(substr($_POST['session_day_bg'],0,1)!="#" && strlen($_POST['session_day_bg'])>2){
	$_POST['session_day_bg'] = "#".$_POST['session_day_bg'];
}
if(substr($_POST['session_sub_bg'],0,1)!="#" && strlen($_POST['session_sub_bg'])>2){
	$_POST['session_sub_bg'] = "#".$_POST['session_sub_bg'];
}
if(substr($_POST['glance_top_bg'],0,1)!="#" && strlen($_POST['glance_top_bg'])>2){
	$_POST['glance_top_bg'] = "#".$_POST['glance_top_bg'];
}
if(substr($_POST['glance_top_font'],0,1)!="#" && strlen($_POST['glance_top_font'])>2){
	$_POST['glance_top_font'] = "#".$_POST['glance_top_font'];
}

if(substr($_POST['session_search_bg'],0,1)!="#" && strlen($_POST['session_search_bg'])>2){
	$_POST['session_search_bg'] = "#".$_POST['session_search_bg'];
}
if(substr($_POST['session_search_font'],0,1)!="#" && strlen($_POST['session_search_font'])>2){
	$_POST['session_search_font'] = "#".$_POST['session_search_font'];
}

if(substr($_POST['session_bottom_menu_bg'],0,1)!="#" && strlen($_POST['session_bottom_menu_bg'])>2){
	$_POST['session_bottom_menu_bg'] = "#".$_POST['session_bottom_menu_bg'];
}

if(substr($_POST['session_bar_font'],0,1)!="#" && strlen($_POST['session_bar_font'])>2){
	$_POST['session_bar_font'] = "#".$_POST['session_bar_font'];
}

if(substr($_POST['session_topmenu_bg'],0,1)!="#" && strlen($_POST['session_topmenu_bg'])>2){
	$_POST['session_topmenu_bg'] = "#".$_POST['session_topmenu_bg'];
}

if(substr($_POST['session_topmenu_font'],0,1)!="#" && strlen($_POST['session_topmenu_font'])>2){
	$_POST['session_topmenu_font'] = "#".$_POST['session_topmenu_font'];
}
if(substr($_POST['session_bullet_kor'],0,1)!="#" && strlen($_POST['session_bullet_kor'])>2){
	$_POST['session_bullet_kor'] = "#".$_POST['session_bullet_kor'];
}
if(substr($_POST['session_bullet_eng'],0,1)!="#" && strlen($_POST['session_bullet_eng'])>2){
	$_POST['session_bullet_eng'] = "#".$_POST['session_bullet_eng'];
}

if(substr($_POST['session_sub_session1_bg'],0,1)!="#" && strlen($_POST['session_sub_session1_bg'])>2){
	$_POST['session_sub_session1_bg'] = "#".$_POST['session_sub_session1_bg'];
}
if(substr($_POST['session_sub_session2_bg'],0,1)!="#" && strlen($_POST['session_sub_session2_bg'])>2){
	$_POST['session_sub_session2_bg'] = "#".$_POST['session_sub_session2_bg'];
}

if(substr($_POST['session_sub_session1_font'],0,1)!="#" && strlen($_POST['session_sub_session1_font'])>2){
	$_POST['session_sub_session1_font'] = "#".$_POST['session_sub_session1_font'];
}
if(substr($_POST['session_sub_session2_font'],0,1)!="#" && strlen($_POST['session_sub_session2_font'])>2){
	$_POST['session_sub_session2_font'] = "#".$_POST['session_sub_session2_font'];
}
if(substr($_POST['glance_room_font'],0,1)!="#" && strlen($_POST['glance_room_font'])>2){
	$_POST['glance_room_font'] = "#".$_POST['glance_room_font'];
}
if(substr($_POST['session_question'],0,1)!="#" && strlen($_POST['session_question'])>2){
	$_POST['session_question'] = "#".$_POST['session_question'];
}

if(substr($_POST['booth_num_type1'],0,1)!="#" && strlen($_POST['booth_num_type1'])>2){
	$_POST['booth_num_type1'] = "#".$_POST['booth_num_type1'];
}
if(substr($_POST['booth_num_type2'],0,1)!="#" && strlen($_POST['booth_num_type2'])>2){
	$_POST['booth_num_type2'] = "#".$_POST['booth_num_type2'];
}
if(substr($_POST['booth_num_type3'],0,1)!="#" && strlen($_POST['booth_num_type3'])>2){
	$_POST['booth_num_type3'] = "#".$_POST['booth_num_type3'];
}
if(substr($_POST['booth_num_type4'],0,1)!="#" && strlen($_POST['booth_num_type4'])>2){
	$_POST['booth_num_type4'] = "#".$_POST['booth_num_type4'];
}

if(substr($_POST['facutly_top_bg'],0,1)!="#" && strlen($_POST['facutly_top_bg'])>2){
	$_POST['facutly_top_bg'] = "#".$_POST['facutly_top_bg'];
}
if(substr($_POST['facutly_top_font'],0,1)!="#" && strlen($_POST['facutly_top_font'])>2){
	$_POST['facutly_top_font'] = "#".$_POST['facutly_top_font'];
}
if(substr($_POST['facutly_list_group_bg'],0,1)!="#" && strlen($_POST['facutly_list_group_bg'])>2){
	$_POST['facutly_list_group_bg'] = "#".$_POST['facutly_list_group_bg'];
}
if(substr($_POST['facutly_list_group_font'],0,1)!="#" && strlen($_POST['facutly_list_group_font'])>2){
	$_POST['facutly_list_group_font'] = "#".$_POST['facutly_list_group_font'];
}


if($cnt>0)
{
	$query = "update css_tbl SET ";
	$query .= " menu_bg_on='".$_POST['menu_bg_on']."'";
	$query .= ", menu_bg='".$_POST['menu_bg']."'";
	$query .= ", menu_font_on='".$_POST['menu_font_on']."'";
	$query .= ", menu_font='".$_POST['menu_font']."'";
	$query .= ", question_bg='".$_POST['question_bg']."'";
	$query .= ", question_font='".$_POST['question_font']."'";
	$query .= ", feedback_bg_bold='".$_POST['feedback_bg_bold']."'";
	$query .= ", feedback_font_bold='".$_POST['feedback_font_bold']."'";
	$query .= ", feedback_bg='".$_POST['feedback_bg']."'";
	$query .= ", feedback_font='".$_POST['feedback_font']."'";
	$query .= ", feedback_btn='".$_POST['feedback_btn']."'";
	$query .= ", feedback_btn_font='".$_POST['feedback_btn_font']."'";
	$query .= ", feedback_font2='".$_POST['feedback_font2']."'";
	$query .= ", feedback_send='".$_POST['feedback_send']."'";
	$query .= ", feedback_send_border='".$_POST['feedback_send_border']."'";
	$query .= ", agenda_bg1='".$_POST['agenda_bg1']."'";
	$query .= ", agenda_bg2='".$_POST['agenda_bg2']."'";
	$query .= ", agenda_bg3='".$_POST['agenda_bg3']."'";

	$query .= ", agenda_bg1_on='".$_POST['agenda_bg1_on']."'";
	$query .= ", agenda_bg2_on='".$_POST['agenda_bg2_on']."'";
	$query .= ", agenda_bg3_on='".$_POST['agenda_bg3_on']."'";

	$query .= ", agenda_font1='".$_POST['agenda_font1']."'";
	$query .= ", agenda_font2='".$_POST['agenda_font2']."'";
	$query .= ", agenda_font3='".$_POST['agenda_font3']."'";

	$query .= ", agenda_font1_on='".$_POST['agenda_font1_on']."'";
	$query .= ", agenda_font2_on='".$_POST['agenda_font2_on']."'";
	$query .= ", agenda_font3_on='".$_POST['agenda_font3_on']."'";

	$query .= ", session_bullet_kor='".$_POST['session_bullet_kor']."'";
	$query .= ", session_bullet_eng='".$_POST['session_bullet_eng']."'";

	$query .= ", session_category_font='".$_POST['session_category_font']."'";
	$query .= ", abs_no_font='".$_POST['abs_no_font']."'";
	$query .= ", abs_sid_font='".$_POST['abs_sid_font']."'";
	$query .= ", session_theme_font='".$_POST['session_theme_font']."'";
	$query .= ", session_title_font='".$_POST['session_title_font']."'";
	$query .= ", glance_theme_font='".$_POST['glance_theme_font']."'";
	$query .= ", glance_theme_font_size='".$_POST['glance_theme_font_size']."'";
	$query .= ", session_chair_font='".$_POST['session_chair_font']."'";
	$query .= ", session_speaker_font='".$_POST['session_speaker_font']."'";
	$query .= ", session_favor='".$_POST['session_favor']."'";
	$query .= ", session_lecture='".$_POST['session_lecture']."'";
	$query .= ", session_abstract='".$_POST['session_abstract']."'";
	$query .= ", session_cv='".$_POST['session_cv']."'";
	$query .= ", session_memo='".$_POST['session_memo']."'";
	$query .= ", session_evaluation='".$_POST['session_evaluation']."'";
	$query .= ", session_question='".$_POST['session_question']."'";



	$query .= ", session_bar_bg='".$_POST['session_bar_bg']."'";
	$query .= ", session_select_bg='".$_POST['session_select_bg']."'";
	$query .= ", session_select_font='".$_POST['session_select_font']."'";
	$query .= ", session_day_bg='".$_POST['session_day_bg']."'";
	$query .= ", session_sub_bg='".$_POST['session_sub_bg']."'";
	$query .= ", glance_top_bg='".$_POST['glance_top_bg']."'";
	$query .= ", glance_top_font='".$_POST['glance_top_font']."'";
	$query .= ", glance_top_font_size='".$_POST['glance_top_font_size']."'";
	$query .= ", session_search_bg='".$_POST['session_search_bg']."'";
	$query .= ", session_search_font='".$_POST['session_search_font']."'";
	
	$query .= ", session_bottom_menu_bg='".$_POST['session_bottom_menu_bg']."'";
	$query .= ", session_bar_font='".$_POST['session_bar_font']."'";
	$query .= ", session_category_radius='".$_POST['session_category_radius']."'";
	$query .= ", session_topmenu_bg='".$_POST['session_topmenu_bg']."'";
	$query .= ", session_topmenu_font='".$_POST['session_topmenu_font']."'";

	$query .= ", session_sub_session1_bg='".$_POST['session_sub_session1_bg']."'";
	$query .= ", session_sub_session1_font='".$_POST['session_sub_session1_font']."'";
	$query .= ", session_sub_session2_bg='".$_POST['session_sub_session2_bg']."'";
	$query .= ", session_sub_session2_font='".$_POST['session_sub_session2_font']."'";

	$query .= ", glance_room_font='".$_POST['glance_room_font']."'";
	$query .= ", glance_room_font_size='".$_POST['glance_room_font_size']."'";

	$query .= ", booth_num_type1='".$_POST['booth_num_type1']."'";
	$query .= ", booth_num_type2='".$_POST['booth_num_type2']."'";
	$query .= ", booth_num_type3='".$_POST['booth_num_type3']."'";
	$query .= ", booth_num_type4='".$_POST['booth_num_type4']."'";

	$query .= ", facutly_top_bg='".$_POST['facutly_top_bg']."'";
	$query .= ", facutly_top_font='".$_POST['facutly_top_font']."'";
	$query .= ", facutly_list_group_bg='".$_POST['facutly_list_group_bg']."'";
	$query .= ", facutly_list_group_font='".$_POST['facutly_list_group_font']."'";

	$query .= " where code='".$code."'";
}
else
{

	$query = "INSERT INTO css_tbl SET ";
	$query .= "code='".$_COOKIE['code']."'";
	$query .= ", menu_bg_on='".$_POST['menu_bg_on']."'";
	$query .= ", menu_bg='".$_POST['menu_bg']."'";
	$query .= ", menu_font_on='".$_POST['menu_font_on']."'";
	$query .= ", menu_font='".$_POST['menu_font']."'";
	$query .= ", question_bg='".$_POST['question_bg']."'";
	$query .= ", question_font='".$_POST['question_font']."'";
	$query .= ", feedback_bg_bold='".$_POST['feedback_bg_bold']."'";
	$query .= ", feedback_font_bold='".$_POST['feedback_font_bold']."'";
	$query .= ", feedback_bg='".$_POST['feedback_bg']."'";
	$query .= ", feedback_font='".$_POST['feedback_font']."'";
	$query .= ", feedback_btn='".$_POST['feedback_btn']."'";
	$query .= ", feedback_btn_font='".$_POST['feedback_btn_font']."'";
	$query .= ", feedback_font2='".$_POST['feedback_font2']."'";
	$query .= ", feedback_send='".$_POST['feedback_send']."'";
	$query .= ", feedback_send_border='".$_POST['feedback_send_border']."'";
	$query .= ", agenda_bg='".$_POST['agenda_bg']."'";
	$query .= ", agenda_bg_on='".$_POST['agenda_bg_on']."'";
	$query .= ", agenda_font='".$_POST['agenda_font']."'";
	$query .= ", agenda_font_on='".$_POST['agenda_font_on']."'";
	$query .= ", session_bullet_kor='".$_POST['session_bullet_kor']."'";
	$query .= ", session_bullet_eng='".$_POST['session_bullet_eng']."'";

	$query .= ", session_category_font='".$_POST['session_category_font']."'";
	$query .= ", abs_no_font='".$_POST['abs_no_font']."'";
	$query .= ", abs_sid_font='".$_POST['abs_sid_font']."'";
	$query .= ", session_theme_font='".$_POST['session_theme_font']."'";
	$query .= ", session_title_font='".$_POST['session_title_font']."'";
	$query .= ", glance_theme_font='".$_POST['glance_theme_font']."'";
	$query .= ", glance_theme_font_size='".$_POST['glance_theme_font_size']."'";
	$query .= ", session_chair_font='".$_POST['session_chair_font']."'";
	$query .= ", session_speaker_font='".$_POST['session_speaker_font']."'";
	$query .= ", session_favor='".$_POST['session_favor']."'";
	$query .= ", session_lecture='".$_POST['session_lecture']."'";
	$query .= ", session_abstract='".$_POST['session_abstract']."'";
	$query .= ", session_cv='".$_POST['session_cv']."'";
	$query .= ", session_memo='".$_POST['session_memo']."'";
	$query .= ", session_evaluation='".$_POST['session_evaluation']."'";
	$query .= ", session_question='".$_POST['session_question']."'";
	
	$query .= ", session_bar_bg='".$_POST['session_bar_bg']."'";
	$query .= ", session_select_bg='".$_POST['session_select_bg']."'";
	$query .= ", session_select_font='".$_POST['session_select_font']."'";
	$query .= ", session_day_bg='".$_POST['session_day_bg']."'";
	$query .= ", session_sub_bg='".$_POST['session_sub_bg']."'";
	$query .= ", glance_top_bg='".$_POST['glance_top_bg']."'";
	$query .= ", glance_top_font='".$_POST['glance_top_font']."'";
	$query .= ", glance_top_font_size='".$_POST['glance_top_font_size']."'";
	$query .= ", session_search_bg='".$_POST['session_search_bg']."'";
	$query .= ", session_search_font='".$_POST['session_search_font']."'";
	$query .= ", session_bottom_menu_bg='".$_POST['session_bottom_menu_bg']."'";
	$query .= ", session_bar_font='".$_POST['session_bar_font']."'";
	$query .= ", session_category_radius='".$_POST['session_category_radius']."'";
	$query .= ", session_sub_session1_bg='".$_POST['session_sub_session1_bg']."'";
	$query .= ", session_sub_session1_font='".$_POST['session_sub_session1_font']."'";
	$query .= ", session_sub_session2_bg='".$_POST['session_sub_session2_bg']."'";
	$query .= ", session_sub_session2_font='".$_POST['session_sub_session2_font']."'";

	$query .= ", glance_room_font='".$_POST['glance_room_font']."'";
	$query .= ", glance_room_font_size='".$_POST['glance_room_font_size']."'";

	$query .= ", booth_num_type1='".$_POST['booth_num_type1']."'";
	$query .= ", booth_num_type2='".$_POST['booth_num_type2']."'";
	$query .= ", booth_num_type3='".$_POST['booth_num_type3']."'";
	$query .= ", booth_num_type4='".$_POST['booth_num_type4']."'";

	$query .= ", facutly_top_bg='".$_POST['facutly_top_bg']."'";
	$query .= ", facutly_top_font='".$_POST['facutly_top_font']."'";
	$query .= ", facutly_list_group_bg='".$_POST['facutly_list_group_bg']."'";
	$query .= ", facutly_list_group_font='".$_POST['facutly_list_group_font']."'";

}
//echo  $query;
mysqli_query($conn, $query);
?>

<script>
	alert("저장되었습니다.");
	location.href="./view.php";
</script>