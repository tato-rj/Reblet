require('./bootstrap/setup');
require('./bootstrap/extensions');
require('./bootstrap/utilities');
require('./bootstrap/components');

//////////////////////////////////////
//// CUSTOM JS BELOW
//////////////////////////////////////

window.log = function(message) {
	console.log(message);
}