var app = angular.module('StarterApp', ['ngMaterial', 'ngResource']);
var namespace = {};
namespace.domain = location.protocol + '//' + document.domain + ":" + (location.port || (location.protocol === 'http' ? '80' : '443')) + '/';
namespace.app = app;
