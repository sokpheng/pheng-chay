var app = angular.module('StarterApp', ['ngMaterial',  'uiGmapgoogle-maps', 'ngRoute', 'ngSanitize', 
	'dndLists', 'ngResource', 'ngFileUpload', 'ngMap' , 'md.data.table', 'cl.paging', 'ngMaterialDatePicker']);
var namespace = {};
namespace.app = app;
namespace.domain = location.protocol + '//' + document.domain + ":" + (location.port || (location.protocol === 'http' ? '80' : '443')) + '/';
namespace.guid = function () {
  	function s4() {
    	return Math.floor((1 + Math.random()) * 0x10000)
      	.toString(16)
      	.substring(1);
  	}
  	return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
};
namespace.urlify = function (field){
	if (field){
		return field.toLowerCase().replace(/[^a-zA-Z0-9]/g, " ").replace(/ /g, '-');
	}
	else{
		return '';
	}
};
namespace.phoneToArray = function(string){
	string = string || '';
	var tmp = _.map(string.split('; '), function(v){
		var phone = v.split(' ');
		return {
			country_code: phone.length == 2 ? phone[0] * 1 : '855',
			number: phone.length == 2 ? phone[1] : phone[0] //phone[1] * 1
		};
	});

	tmp = _.filter(tmp, function (v){
		return v.country_code && v.number;
	});

	tmp = tmp.concat([{
		number: '',
		country_code: 855
	}]);
	
	return tmp;
};
namespace.phoneArrayToString = function (array){
	return _.map(array, function (v){
		return v.trim()
	}).join(', ');
};
namespace.phoneToString = function (arrays, formatted){
	return _.map(_.filter(arrays, function (v, k){
		return (k != arrays.length - 1 && v.country_code && v.number);
	}), function(v){
		// var needFormatPhoneNumber = v.number.indexOf('-') == -1 && v.number.indexOf(' ') == -1;
		// var formatPhoneNumber = needFormatPhoneNumber ? text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3') : v.number.replace(/ /g, '-');
		
		var formatPhoneNumber = ((v.number || '') + '').replace( /[^\d]/g, '' );
		var number = formatPhoneNumber.length;
		if (number == 9){
			formatPhoneNumber = formatPhoneNumber.replace(/(\d{3})(\d{3})(\d{3})/, '$1-$2-$3');
		}
		else{
			formatPhoneNumber = formatPhoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
		}
		return (formatted ? ('(' + v.country_code + ')') : v.country_code) + ' ' + formatPhoneNumber;
	}).join('; ');
};
namespace.phoneToStringNoCountryCode = function (arrays, formatted){
	return _.map(_.filter(arrays, function (v, k){
		return (k != arrays.length - 1 && v.country_code && v.number);
	}), function(v){
		// var needFormatPhoneNumber = v.number.indexOf('-') == -1 && v.number.indexOf(' ') == -1;
		// var formatPhoneNumber = needFormatPhoneNumber ? text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3') : v.number.replace(/ /g, '-');
		
		var formatPhoneNumber = ((v.number || '') + '').replace( /[^\d]/g, '' );
		var number = formatPhoneNumber.length;
		if (number == 9){
			formatPhoneNumber = formatPhoneNumber.replace(/(\d{3})(\d{3})(\d{3})/, '$1-$2-$3');
		}
		else{
			formatPhoneNumber = formatPhoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
		}
		if ((v.country_code + '') == '855'){
			return (formatPhoneNumber[0] != '0' ? '0' : '') + formatPhoneNumber;
		}
		else{
			return (formatted ? ('(' + v.country_code + ')') : v.country_code) + ' ' + formatPhoneNumber;
		}
	}).join('; ');
}