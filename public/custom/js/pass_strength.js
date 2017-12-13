// custom controls

// DOM nodes
var form = {
	register:	document.getElementById("register"),
	password:		document.getElementById("password"),
	password_again:		document.getElementById("password_again"),
	strength:	document.getElementById("strength")
};


// form submit
form.register.addEventListener( "submit", CheckForm );



// stop space character
form.password.addEventListener( "keypress", NoSpaces );
form.password_again.addEventListener( "keypress", NoSpaces );


// password strength
form.password.addEventListener( "keyup", PasswordStrength );


// stop spaces being entered
function NoSpaces(e) {
	if (e.charCode == 32) e.preventDefault();
}


// check password strength
var strtext = ["weak", "average", "strong"];
var strcolor = ["#c00", "#f80", "#080"];
function PasswordStrength(e) {

	var pass = form.password.value;

	// count uppercase
	var uc = pass.match(/[A-Z]/g);
	uc = (uc && uc.length || 0);

	// count numbers
	var nm = pass.match(/\d/g);
	nm = (nm && nm.length || 0);

	// count symbols
	var nw = pass.match(/\W/g);
	nw = (nw && nw.length || 0);

	// determine strength
	var s = pass.length + uc + (nm * 2) + (nw * 3);
	s = Math.min(Math.floor(s / 10), 2);

	form.strength.textContent = strtext[s];
	form.strength.style.color = strcolor[s];

}


