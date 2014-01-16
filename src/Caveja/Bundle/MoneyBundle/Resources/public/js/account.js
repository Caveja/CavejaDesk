function AccountCtrl($scope, $http) {
    $http.get('/money/accounts').
        success(function(data) {
            $scope.accounts = data;
        });
}