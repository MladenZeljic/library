function show_password(){
	var password_input = document.getElementById("log-password-input");
	if (password_input.type === "password") {
		password_input.type = "text";
	} 
	else {
		password_input.type = "password";
	}
}

function fade_element(elementIdFromFade,elementIdToFade){
	var fading_element = document.getElementById(elementIdFromFade);
	var replacing_element = document.getElementById(elementIdToFade);
	
	fading_element.classList.add("fade");
	setTimeout(function(){
		replacing_element.classList.remove("fade");
		replacing_element.classList.remove("form-hide");
		fading_element.classList.add("form-hide");
	},200);
}
function show_selected_view(element){
	
	var views=document.getElementById("views").children;
	var tabs=document.getElementById("tabs").getElementsByTagName('li');
	var numberOfTabs=tabs.length;
	var numberOfViews=views.length;
	if(numberOfTabs==numberOfViews){
		for(var i=0;i<numberOfViews;i++){
			tabs[i].classList.remove('active-tab');
			views[i].classList.remove('tab-view-hide');
			views[i].classList.add('tab-view-hide');
		}
		for(var i=0;i<numberOfTabs;i++){
			if(element.id===tabs[i].id){
				views[i].classList.remove('tab-view-hide');
				element.classList.add('active-tab');
				break;
			}
		}
	}
	else{
		alert("Bad HTML: Tab or tab view missing!");
	}
}
function validate_form(form){
	
	var inputs = form.getElementsByTagName("input");
	for(var i = 0; i < inputs.length; i++){
		console.log(inputs[i].value.trim().length);
		if (inputs[i].type && inputs[i].type === 'checkbox') {
			break;
		}
		else{
			if(inputs[i].value==="" && inputs[i].value.length === 0 || inputs[i].value.trim().length === 0){
				return false;
			}
		}
	}
	return true;		
}
function mark_page_as_active(divId,link){
	var links = document.getElementById(divId).getElementsByTagName('a');
	for (var i = 0; i < links.length; i++) {
		console.log(links[i].classList.contains('page-active'));
		links[i].classList.remove('page-active');
	}
	link.classList.add('page-active');
}
