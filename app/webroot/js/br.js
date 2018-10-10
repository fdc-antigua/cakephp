$(document).ready(function(){

	$('body').on('focus', '[class*=date-br]', function(){
		
		$(this).datepicker({

			dateFormat		: 'yy-mm-dd',

			numberOfMonths : 1,

        	changeYear: true,
        	changeMonth: true,

			yearRange: '1900:2018' 

		});
	});

	 $.uploadPreview({
	    input_field: "#image-upload",   // Default: .image-upload
	    preview_box: "#image-preview",  // Default: .image-preview
	    label_field: "#image-label",    // Default: .image-label
	    no_label: false    
	});

	$('.btn-send').on('click', function(){
		
		msg = $('.message-send').val();
		convo_id = $('.convo_id').val();
		to = $(this).data('recipient');
		$('message-send').val(" ");

		$.post("/cakephp/messages/reply",{'msg':msg,'to':to,'convo_id':convo_id},function(data){
			$(".messages-list" ).html(data );
		});


	});

//	$('.action-delete').on('click', function(){
	$('body').on('click', '.action-delete' ,function(){
		msg = $(this).data('message');
		msgId = $(this).data('msg-id');
		$('.text-message').html(msg);
		$('.delete-message').val(msgId);

	});

	//$('.btn-delete').on('click', function(){
	$('body').on('click', '.btn-delete' ,function(){
		del = $('.delete-message').val();
		sender = $('.message-sender').val();
		recipient = $('.message-recipient').val();

		$('#myModal').modal('hide'); 

		$('.child-delete').each(function() {
			if($(this).val() <= del){
				$(this).parent().fadeOut(300, function() { $(this).remove(); });
			}
		});

		$.post("/cakephp/messages/delete",{'del':del,'sender':sender,'recipient':recipient},function(data){
			$(".messages-list" ).html(data );
		});
	});

	$('.btn-show-more').on('click', function(){

		btn = $(this);
		nxt_page = btn.data('page');
		btn.data('page',nxt_page + 1);
		url = "/cakephp/messages/index/page:"+nxt_page;

		btn.hide();
		$('.loading-icon').fadeIn();
		$('.loading-icon').fadeOut('1000');

		$.get(url,function(data){
			setTimeout(function() {
				toAppend = $(data).hide().fadeIn();
				$(".view-more-div" ).append(toAppend);
				if(nxt_page+1 > $('.page-limit').val()){
					btn.hide();
				}else{
					btn.fadeIn();
				}
			}, 1000);
			
		});

	});

	$('.check_email').on('change', function(){

		email = $(this).val();

		$.post('/cakephp/users/checkemail', {'email':email}, function(data){
			$('.email_info').html(data);
			if(data == 1){
				$('.email_info').html("This email is already taken!");
				$('.email_info').addClass('email-taken');
				$('.email_info').removeClass('email-available');
				$('btn-reg').attr('disabled');
			}else{
				$('.email_info').html("This email is available!");
				$('.email_info').addClass('email-available');
				$('.email_info').removeClass('email-taken');
				$('btn-reg').removeAttr('disabled');
			}
		});

	});



});

$(document).ready(function(){

	var searchJson;
	timeoutId = 0;
	
	$.getJSON('/cakephp/messages/recipients',function(response){
		searchJson2 = response;
	});
	
	$( ".auto_recipient2" ).autocomplete({
		delay: 0,
		source: function( request, response ) {
			var regex = new RegExp(request.term, 'i');
			response($.map(searchJson, function(item, index) {

				var data = [{ label: item, value: item, idx: index }];

				return(data);

				}));
		}, select: function (e, ui) {
	        console.log(ui.item.idx);
	        $('.recipient').val(ui.item.idx)
	    },minLength: 1

	});

	function autoRecipient(){


		$.post('/cakephp/messages/retrieve', {'searched':searched}, function(response){
			searchJson = JSON.parse(response);
			$('.auto_recipient').autocomplete({
			source: function( request, response ) {
				response($.map(searchJson, function(item, index, image) {

					var data = [{ label: item, value: item, idx: index }];

					return(data);

				}));
			}, select: function (e, ui) {
		        console.log(ui.item.idx);
		        $('.recipient').val(ui.item.idx)
		    },minLength: 1,
		    create: function () {
			   	$(this).data('ui-autocomplete')._renderItem = function (ul, item) {
			      	return $('<li>')
			        .append( "<a class='auto-lists'><img src='/cakephp/img/uploads/user.png' style='width:50px !important; height:40px;'><label class='auto-lists-label'>" + item.label + "</label></a>" )
			        .appendTo(ul);
			    };
			}

		});
		});



	}

	$('.auto_recipient').on('keypress', function(){

		var ds = $(this);
		searched = $(this).val();

		clearTimeout(timeoutId);
		timeoutId = setTimeout(autoRecipient, 1000);

	});

});
