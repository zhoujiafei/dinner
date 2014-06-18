/**
 *一些公用的操作 
 */
$(function(){
	//删除
	$('.remove_row').click(function(){
		if(confirm('你确定要删除吗？'))
		{
			var url = $(this).attr('_href');
			window.location.href = url;
		}
	})
	
	//审核
	$('.status_row').click(function(){
		var url = $(this).attr('_url');
		var _obj = $(this);
		$.get(url,function(data){
			var obj = eval('('+data+')');
			if(obj.errorCode)
			{
				alert(obj.errorText);
				return;
			}
			else if(obj.status)
			{
				_obj.html(obj.status_text).css({color:obj.status_color});
			}
		})
		
	})
})