jQuery.fn.hasAttr = function(attr) {
	let value = this.attr(attr);
	return typeof value !== 'undefined' && value !== false;
};

jQuery.fn.toggleProp = function(prop) {
	let state = this.prop(prop);

	return this.prop(prop, ! state);
};