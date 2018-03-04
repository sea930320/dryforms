var app = angular.module('teamsApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
}).config(function($sceDelegateProvider) {
});

function MainCtrl($rootScope,$scope, $http, $q) {
    $scope.loading = true;
    $scope.teams = [];
    $scope.newTeam = '';

    $scope.init = function() {
        $http.get('/admin/standard/teams')
            .then((res) => {
                $scope.teams = res.data.teams;
                $scope.loading = false
            }).catch(err => {
            })
    }

    $scope.deleteTeam = function(id) {
        $http.delete('/admin/standard/teams/' + id)
        .then(() => {
            $scope.teams.splice($scope.teams.findIndex(function(team) {
                return team.id === id
            }), 1)
        })
        .catch(() => {})
    };

    $scope.addTeam = function() {
        $http.post('/admin/standard/teams', {
            name: this.newTeam
        })
        .then((response) => {
            $scope.teams.push(response.data.team);
            this.newTeam = '';
        })
        .catch(() => {})
    };
        
    $scope.init();
}

app.run(function($rootScope) {
    $rootScope._ = _;
})

app.controller('teamsCtrl', MainCtrl)