function customValidate() {

        var firstname = document.getElementById("firstname");
        var lastname = document.getElementById("lastname");
        var email = document.getElementById("email");
        
        if (firstname.value.length == 0) {
            alert("You must enter your first name");
            firstname.style.border = '1px solid #fa0404';
            firstname.focus();
            return false;   
        }
        if (lastname.value.length == 0) {
            alert("You must enter your last name");
            lastname.style.border = '1px solid #fa0404';
            lastname.focus();
            return false;   
        }
        if (email.value.length == 0) {
            alert("You must enter your email address");
            email.style.border = '1px solid #fa0404';
            email.focus();
            return false;   
        }
}