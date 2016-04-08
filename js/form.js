$(document).ready(function() {

	var form = $('form.contact-form');
	var btn = $('button#submit');
	var incoming = $('div#incoming');

	$(btn).click(function() {
		$(btn).html('<i class="fa fa-spinner"></i>');
		$(btn).attr('disabled', true);
		
		setTimeout(function() {
			$.ajax({
				type: 'post',
				url: 'config/mail.php',
				data: $(form).serialize(),
				dataType: 'json',
				cache: false,
				encode: true
			})
			.done(function(data) {
            	if (data.errors == true) {
            		$(btn).attr('disabled', false).html("Send");
                	if (data.fields.name) {
                    	$('#name-field').addClass('has-error').append('<span class="help-block" id="validated">' + data.fields.name + '</span>');
                    	$('input[name="name"]').keydown(function(event){
					    	$(".has-error").removeClass().remove('<span class="help-block" id="validated">' + data.fields.name + '</span>');
				    	});
                	}
                	if (data.fields.email) {
                    	$('#email-field').addClass('has-error').append('<span class="help-block" id="validated">' + data.fields.email + '</span>');
                		$('input[name="email"]').keydown(function(event){
					    	$(".has-error").removeClass().remove('<span class="help-block" id="validated">' + data.fields.email + '</span>');
				    	});
                	}
		            if (data.fields.message) {
		                $('#message-field').addClass('has-error').append('<span class="help-block" id="message-validated">' + data.fields.message + '</span>');
		            	$('textarea').keydown(function(event){
					    	$(".has-error").removeClass().remove('<span class="help-block" id="message-validated">' + data.fields.message + '</span>');
				    	});
		            }
           		} else {
           			$(btn).attr('disabled', false).html("Send");
           			$('.name').val('');
					$('.email').val('');
					$('.message').val('');
					$(incoming).html("<div class='help-block' id='success' ><p>" + data.response + "</p></div>");
            	}
        	})
        	.fail(function(data) {
        		$(btn).attr('disabled', false).html("Send");
            	$(incoming).html("<div class='help-block' id='success'><p>An error has occurred, please try again.</p></div>");
        	});
        }, 1000);	
	});
	return false;
});