var app = angular.module('areaApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
}).config(function($sceDelegateProvider) {
});

function MainCtrl($rootScope,$scope, $http, $q) {
    $scope.loading = true;
    $scope.form = {};
    $scope.areas = [];
    $scope.newArea = '';

    $scope.init = function() {
        const apis = [
            $http.get('/admin/standard-areas/form'),
            $http.get('/admin/standard/areas')
        ]

        $q.all(apis)
            .then((res) => {
                $scope.form = res[0].data.form;
                $scope.areas = res[1].data.areas;

                $scope.loading = false
            }).catch(err => {
            })
    }

    $scope.saveForm = _.debounce(function() {
        $http.post('/admin/standard-areas/form-update', this.form).then(response => {
        }).catch(()=>{})
    }, 500)

    $scope.deleteArea = function(id) {
        $http.delete('/admin/standard/areas/' + id)
        .then(() => {
            $scope.areas.splice($scope.areas.findIndex(function(area) {
                return area.id === id
            }), 1)
        })
        .catch(() => {})
    };

    $scope.addArea = function() {
        $http.post('/admin/standard/areas', {
            title: this.newArea
        })
        .then((response) => {
            $scope.areas.push(response.data.area);
            this.newArea = '';
        })
        .catch(() => {})
    };
        
    $scope.init();
}

app.run(function($rootScope) {
    $rootScope._ = _;
})

app.controller('areaCtrl', MainCtrl)