$(document).ready(function() {
    $('#login_form').submit(function(event) {

        // Check if any required fields are empty
        var formValid = true;
        $(this).find('input[required]').each(function() {
            if ($.trim($(this).val()) === '') {
                formValid = false;
                $(this).addClass('error');
            }
        });

        if (!formValid) {
            event.preventDefault();
        }
		else
		{
			// Serialize form data
			var formData = $(this).serialize();

			// Send data to the server using AJAX
			$.ajax({
				type: 'POST',
				url: $(this).attr('action'), // Use the form's action attribute as the URL
				data: formData,
				error: function(jqXHR, textStatus, errorThrown) {
					console.log('AJAX Error:', textStatus, errorThrown);
				}
			});
		}

    });
});
