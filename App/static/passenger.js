function validateEmail(email) {
	const regex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
	return regex.test(email);
}
function isThaiName(name) {
    const thaiNameRegex = /^[A-Za-z ]+$/;
	if (name != '')
	{
		return !(thaiNameRegex.test(name));
	}
}
function isEnglishName(name) {
    const englishNameRegex = /^[A-Za-z ]+$/;
	return englishNameRegex.test(name);
}
function isphone(number) {
    const numberRegex = /^(0(6|8|9))\d{8}$/;
    return numberRegex.test(number);
}


//validate form on input change
function validateForm(passengerNumber) {
	const firstname = document.getElementById(`firstname_${passengerNumber}`).value;
    const lastname = document.getElementById(`lastname_${passengerNumber}`).value;
    const firstname_eng = document.getElementById(`firstname_eng_${passengerNumber}`).value;
    const lastname_eng = document.getElementById(`lastname_eng_${passengerNumber}`).value;
    const email = document.getElementById(`email_${passengerNumber}`).value;
    const phone = document.getElementById(`phone_${passengerNumber}`).value;
    const DOB = document.getElementById(`DOB_${passengerNumber}`).value;


	const DOBInput = document.getElementById(`DOB_${passengerNumber}`);
    const DOB_error = document.getElementById(`DOB-error_${passengerNumber}`);

    const firstname_engInput = document.getElementById(`firstname_eng_${passengerNumber}`);
    const lastname_engInput = document.getElementById(`lastname_eng_${passengerNumber}`);
    const firstname_eng_error = document.getElementById(`firstname_eng-error_${passengerNumber}`);
    const lastname_eng_error = document.getElementById(`lastname_eng-error_${passengerNumber}`);

    const firstnameInput = document.getElementById(`firstname_${passengerNumber}`);
    const lastnameInput = document.getElementById(`lastname_${passengerNumber}`);
    const firstname_error = document.getElementById(`firstname-error_${passengerNumber}`);
    const lastname_error = document.getElementById(`lastname-error_${passengerNumber}`);

    const emailInput = document.getElementById(`email_${passengerNumber}`);
    const email_error = document.getElementById(`email-error_${passengerNumber}`);

    const phoneInput = document.getElementById(`phone_${passengerNumber}`);
    const phone_error = document.getElementById(`phone-error_${passengerNumber}`);

    const prefixInput = document.getElementById(`prefix_${passengerNumber}`);

    const nationality = document.getElementById(`nationality_${passengerNumber}`);

	//DOB
	if(DOB != ''){
		DOBInput.classList.remove('error');
        DOBInput.classList.add('valid');
		DOB_error.innerHTML = '';
	}
	else{
		DOBInput.classList.add('error');
        DOBInput.classList.remove('valid');
		DOB_error.innerHTML = 'กรุณาใส่วันเกิด';
	}


	//iseng validate
	if (isEnglishName(firstname_eng)) {
        firstname_engInput.classList.remove('error');
        firstname_engInput.classList.add('valid');
		firstname_eng_error.innerHTML = '';
    } else {
        firstname_engInput.classList.remove('valid');
        firstname_engInput.classList.add('error');
		firstname_eng_error.innerHTML = 'กรุณากรอกภาษาอังกฤษ';
    }
	if (isEnglishName(lastname_eng)) {
        lastname_engInput.classList.remove('error');
        lastname_engInput.classList.add('valid');
		lastname_eng_error.innerHTML = '';
    } else {
        lastname_engInput.classList.remove('valid');
        lastname_engInput.classList.add('error');
		lastname_eng_error.innerHTML = 'กรุณากรอกภาษาอังกฤษ';
    }

	//isthai validate
	if (isThaiName(firstname)) {
        firstnameInput.classList.remove('error');
        firstnameInput.classList.add('valid');
		firstname_error.innerHTML = '';
    } else {
        firstnameInput.classList.remove('valid');
        firstnameInput.classList.add('error');
		firstname_error.innerHTML = 'กรุณากรอกภาษาไทย';
    }
	if (isThaiName(lastname)) {
        lastnameInput.classList.remove('error');
        lastnameInput.classList.add('valid');
		lastname_error.innerHTML = '';
    } else {
        lastnameInput.classList.remove('valid');
        lastnameInput.classList.add('error');
		lastname_error.innerHTML = 'กรุณากรอกภาษาไทย';
    }

	// Validate Email
	if (validateEmail(email)) {
		emailInput.classList.remove('error');
		emailInput.classList.add('valid');
		email_error.innerHTML = '';
	} else {
		emailInput.classList.remove('valid');
		emailInput.classList.add('error');
		email_error.innerHTML = 'รูปแบบอีเมลไม่ถูกต้อง';
	}

	//phone validate
	if(isphone(phone)){
		phoneInput.classList.remove('error');
		phoneInput.classList.add('valid');
		phone_error.innerHTML = '';
	}
	else
	{
		phoneInput.classList.add('error');
		phoneInput.classList.remove('valid');
		phone_error.innerHTML = 'รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง';
	}

	//check prefix
	if(prefixInput.value != ''){
		prefixInput.classList.remove('error');
		prefixInput.classList.add('valid');
	}
	else
	{
		prefixInput.classList.add('error');
		prefixInput.classList.remove('valid');
	}

	//check nation
	if(nationality.value != ''){
		nationality.classList.remove('error');
		nationality.classList.add('valid');
	}
	else
	{
		nationality.classList.add('error');
		nationality.classList.remove('valid');
	}
}
