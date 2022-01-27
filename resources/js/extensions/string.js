String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

String.prototype.uncapitalize = function() {
    return this.charAt(0).toLowerCase() + this.slice(1);
}

String.prototype.slugToCamelCase = function(type, separators) {
    if (!separators || typeof separators != 'string') {
        separators = '-_.';
    }
    var result = this.replace(new RegExp('[' + separators + '][a-z]', 'ig'), function (s) {
	    return s.substr(1, 1).toUpperCase();
	});
    if (type == 'upper') {
        result = result.capitalize();
    }
    else {
        result = result.uncapitalize();
    }
    return result;
}