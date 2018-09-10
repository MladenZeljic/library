function show_password(){
	var password_input = document.getElementById("log-password-input");
	console.log(password_input);
	if (password_input.type === "password") {
		password_input.type = "text";
	} 
	else {
		password_input.type = "password";
	}
}
function fade_register(){
	console.log("A");
	var login_form = document.getElementById("login-form");
	var register_form = document.getElementById("register-form");
	
	register_form.classList.add("fade");	
	setTimeout(function(){
		login_form.classList.remove("fade");
		login_form.classList.remove("form-hide");
		register_form.classList.add("form-hide");
	},200);	
			
}
function fade_login(){
	var login_form = document.getElementById("login-form");
	var register_form = document.getElementById("register-form");
	
	login_form.classList.add("fade");
	setTimeout(function(){
		register_form.classList.remove("fade");
		login_form.classList.add("form-hide");	
		register_form.classList.remove("form-hide");
	},200);
}
