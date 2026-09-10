
if($("#article_id_number").val())
{
	$.ajax({
		url:"/PubReader/pubreader_ref.php",
		type : "post",
		dataType:"json",
		data : $("#ref_value_list").serialize() ,		
		success:addRefLinkOut
	});
}



function addRefLinkOut(json)
{
	for(var i = 0; i < json.length; i++)
	{		
		if(json[i].text)
		{
			$("#" + json[i].id).append(" "+json[i].text);	
		}		
	}	
}