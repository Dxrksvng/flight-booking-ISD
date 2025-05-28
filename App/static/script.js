document.addEventListener("DOMContentLoaded", function () {
  const goes = document.getElementById("goes");
  const returnDate = document.getElementById("return-date");
  const departureDateInput = document.getElementById("date");
  const returnDateInput = document.getElementById("return");

  $(document).ready(function() {
    const $pasNumInput = $("#pas_num");
    $pasNumInput.on("input", function() {
        let currentValue = parseInt($pasNumInput.val());
        if (currentValue < 1 || isNaN(currentValue)) {
            $pasNumInput.val(1);
        }
    });
});



  goes.addEventListener("change", function () {
    // Show or hide return date based on the selected travel type
    if (goes.value === "go-2") {
      returnDate.classList.remove("hidden");
      returnDateInput.setAttribute("required", "required");
    } else {
      returnDate.classList.add("hidden");
      returnDateInput.removeAttribute("required");
    }
  });

    // Add an event listener to the return date input
    returnDateInput.addEventListener("change", function () {
    // Convert date input values to JavaScript Date objects
    const departureDate = new Date(departureDateInput.value);
    const returnDate = new Date(returnDateInput.value);

    // Check if the return date is earlier than the departure date
    if (returnDate < departureDate) {
      // Set the return date to be the same as the departure date
      returnDateInput.value = departureDateInput.value;
    }
  });
});

// carousel
tailwind.config = {
	theme: {
		extend: {
			fontFamily: {
				cabinetGrotesk: "'Cabinet Grotesk', san-serif",
			}
		}
	}
}
const slidesContainer = document.querySelector(".slides-container");
const slideWidth = slidesContainer.querySelector(".slide").clientWidth;
const prevButton = document.querySelector(".prev");
const nextButton = document.querySelector(".next");

nextButton.addEventListener("click", () => {
	slidesContainer.scrollLeft += slideWidth;
});

prevButton.addEventListener("click", () => {
	slidesContainer.scrollLeft -= slideWidth;
});


$(document).ready(function() {
  $('#search_form').submit(function(event) {

      // Check if any required fields are empty
      var formValid = true;
      $(this).find('input[required]').each(function() {
          if ($.trim($(this).val()) === '') {
              formValid = false;
              $(this).addClass('error');
          }
      });

      $(this).find('select[required]').each(function() {
        if ($(this).val() === null || $(this).val() === '') {
          formValid = false;
          $(this).addClass('error'); // You can style the empty selects as needed
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



