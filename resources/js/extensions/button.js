jQuery.fn.disable = function() {
	return this.prop('disabled', true);
};

jQuery.fn.enable = function() {
	return this.prop('disabled', false);
};
