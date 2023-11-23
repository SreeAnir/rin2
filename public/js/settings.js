$(document).ready(function() {
          
	$('#resendOtp').click(function() {

	  $(this).hide();
	  sendOtp();

	});
	  $('#confirmOtp').click(function() {

		  $(this).attr('disabled', true);

		  confirmOtp();
	  });

	  $('#enableSwitch').change(function() {
		  var isEnabled = $(this).prop('checked');
		  if (isEnabled) {
			  // Enable logic (if needed)
			  console.log('Enabled');
		  } else {
			  // Disable logic (if needed)
			  console.log('Disabled');
		  }
	  });
	  // $(".mask-phone").inputmask("+99-9999999999");
	  var options = {
		  onComplete: function(cep) {
			sendOtp();
		  },
		  onInvalid: function(val, e, f, invalid, options) {
			  var error = invalid[0];
			  console.log("Digit: ", error.v, " is invalid for the position: ", error.p,
				  ". We expect something like: ", error.e);
		  }
	  };

	  $('.mask-phone').mask('+99-9999999999', options);

	  var optionsOtp = {
		  onComplete: function(otp) {
			  console.log("Verify Phone number");
			  $('#confirmOtp').removeAttr('disabled');
		  },
		  onInvalid: function(val, e, f, invalid, optionsOtp) {
			  var error = invalid[0];
			  console.log("Digit: ", error.v, " is invalid for the position: ", error.p,
				  ". We expect something like: ", error.e);
		  }
	  };

	  $('#otp').mask('0 - 0 - 0 - 0 - 0 - 0', optionsOtp);

  });
  
  let handleResend = () => {
	$('#resendOtp').show();
	$('#confirmOtp').hide();
	$('#otp').val('');
	$('#otp_validated').val(false);
  }
  function cleanPhoneNumber(phoneNumber) {
    const cleanedNumber = phoneNumber.replace(/[^\w\s]/gi, '');
    const normalizedNumber = cleanedNumber.replace(/\s/g, '');
    return normalizedNumber;
}

function arePhoneNumbersEqual(ph1, ph2) {
    const cleanedNumber1 = cleanPhoneNumber(ph1);
    const cleanedNumber2 = cleanPhoneNumber(ph2);

    return cleanedNumber1 === cleanedNumber2;
}

	//Sendd or resend the OTP
  function sendOtp(){
	if (arePhoneNumbersEqual($('#existing_phone_number').val(),  $(".mask-phone").val() )) {
		return ;
	}
	$('#confirmOtp').show();
	$('#otp_validated').val(false);
			  $.ajax({
				  url: send_otp_url,  
				  method: 'POST',
				  data: {
					  phone_number: $(".mask-phone").val()
				  },  
				  success: function(response) {
					  if (response.status == "success") {
						  $('#otpModal').modal('show');
					  } else {
						  Swal.fire({
							  title: response.message_title,
							  text: response.message,
							  icon: "error"
						  });
					  }
				  },
				  error: function(response) {
					  console.log('Error making AJAX request');
					  Swal.fire({
							  title: "Failed",
							  text: "Failed to Send the code",
							  icon: "error"
						  });
				  }
			  });
  }
  //Conirm the OTP ffrfom recieved in sms
  function confirmOtp() {
	  $.ajax({
		  url: verify_otp ,  
		  method: 'POST',
		  data: {
			  phone_number: $(".mask-phone").val(),
			  otp_code: $('#otp').val()
		  }, // Send the entered phone number to the server
		  success: function(response) {
			  $('#confirmOtp').removeAttr('disabled');
			  if (response.status == "success") {
				$('#otp_validated').val(true);
				$('#otpModal').modal('hide');
				  Swal.fire({
					  title: response.message_title,
					  text: response.message,
					  icon: "success"
				  });

			  } else {
				 handleResend();
				  Swal.fire({
					  title: response.message_title,
					  text: response.message,
					  icon: "error"
				  });
			  }
		  },
		  error: function(response) {
			  // Handle AJAX errors
			  $('#confirmOtp').removeAttr('disabled');
			  handleResend();
			  console.log('Error making AJAX request');
			  Swal.fire({
				  title: "Failed the verification",
				  text: "Failed to verify the code.Please resend the otp.",
				  icon: "error"
			  });
		  }
	  });
  }