var moneyControllers = angular.module('moneyControllers', ['moneyServices']);

moneyControllers.controller('AccountListCtrl', ['$scope', 'Account', function($scope, Account) {
    $scope.accounts = Account.query();
}]);