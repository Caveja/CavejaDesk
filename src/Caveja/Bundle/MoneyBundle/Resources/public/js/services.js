var moneyServices = angular.module('moneyServices', ['ngResource']);
moneyServices.factory('Account', ['$resource', function($resource) {
    return $resource(siteRoot + 'money/accounts');
}]);