jQuery(document).ready(function($) {
	
		$('body').on('click','.usearchbtn', function(e) {
			process_data($(this));
			return false;
		});
	
		$('body').on('click','.upagievent', function(e) {
			var pagenumber =  $(this).attr('id');
			var formid = $('#curuform').val();
			upagi_ajax(pagenumber, formid);
			return false;
		});

		$('body').on('keypress','.uwpqsftext',function(e) {
		  if(e.keyCode == 13){
                e.preventDefault();
                var form = $(this).parent().parent().attr('id');
                if (!form) {
                    id = $(this);
                }else{
                    var id = $('#'+form); 
                }
                process_data(id);		   
		  }
		});
		
		window.process_data = function ($obj) {
			var ajxdiv = $obj.closest("form").find("#uajaxdiv").val();	
			var res = {loader:$('<div />',{'class':'umloading'}),container : $(''+ajxdiv+'')};
            var formid = $obj.parent().parent().attr('id'); console.log(formid);
			var getdata = $obj.closest("form").serialize();
			var pagenum = '1';
		
			jQuery.ajax({
				 type: 'POST',	 
				 url: ajax.url,
				 data: ({action : 'uwpqsf_ajax',getdata:getdata, pagenum:pagenum }),
				 beforeSend:function() {$(''+ajxdiv+'').empty();res.container.append(res.loader);$obj.closest("form").find('input, textarea, button, select').attr("disabled", true);},
				 success: function(html) {
					res.container.find(res.loader).remove();
				  $(''+ajxdiv+'').html(html);
				  $obj.closest("form").find('input, textarea, button, select').attr("disabled", false);
				
				 }
				 });
			
		}	
		
		window.upagi_ajax = function (pagenum, formid) {
			var ajxdiv = $(''+formid+'').find("#uajaxdiv").val();	
			var res = {loader:$('<div />',{'class':'umloading'}),container : $(''+ajxdiv+'')};
			var getdata = $(''+formid+'').serialize();
		
			jQuery.ajax({
				 type: 'POST',	 
				 url: ajax.url,
				 data: ({action : 'uwpqsf_ajax',getdata:getdata, pagenum:pagenum }),
				 beforeSend:function() {$(''+ajxdiv+'').empty(); res.container.append(res.loader);},
				 success: function(html) {
				  res.container.find(res.loader).remove();
				  $(''+ajxdiv+'').html(html);
				
				//res.container.find(res.loader).remove();
				 }
				 });
		}
		
	 $('body').on('click', '.chktaxoall, .chkcmfall',function () {
		
	    $(this).closest('.togglecheck').find('input:checkbox').prop('checked', this.checked);
		
         });



});//end of script
