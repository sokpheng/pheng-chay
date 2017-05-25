var app = angular.module('StarterApp', ['ngMaterial']);
var namespace = {};
namespace.app = app;
namespace.domain = location.protocol + '//' + document.domain + ":" + (location.port || (location.protocol === 'http' ? '80' : '443')) + '/';