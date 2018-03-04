var app = angular.module('moistureApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
}).config(function($sceDelegateProvider) {
});

function MainCtrl($rootScope,$scope, $http, $q) {
    $scope.loading = true;
    $scope.form = {};
    $scope.structures = [];
    $scope.materials = [];
    $scope.newStructure = '';
    $scope.newMaterial = '';

    $scope.init = function() {
        const apis = [
            $http.get('/admin/standard-moisture/form'),
            $http.get('/admin/standard/structure'),
            $http.get('/admin/standard/material'),
        ]

        $q.all(apis)
            .then((res) => {
                $scope.form = res[0].data.form;
                $scope.structures = res[1].data.structures;
                $scope.materials = res[2].data.materials;

                $scope.loading = false
            }).catch(err => {
            })
    }

    $scope.saveForm = _.debounce(function() {
        $http.post('/admin/standard-moisture/form-update', this.form).then(response => {
        }).catch(()=>{})
    }, 500)

    $scope.deleteStructure = function(id) {
        $http.delete('/admin/standard/structure/' + id)
        .then(() => {
            $scope.structures.splice($scope.structures.findIndex(function(structure) {
                return structure.id === id
            }), 1)
        })
        .catch(() => {})
    };

    $scope.addStructure = function() {
        $http.post('/admin/standard/structure', {
            title: this.newStructure
        })
        .then((response) => {
            $scope.structures.push(response.data.structure);
            this.newStructure = '';
        })
        .catch(() => {})
    };

    $scope.deleteMaterial = function(id) {
        $http.delete('/admin/standard/material/' + id)
        .then(() => {
            $scope.materials.splice($scope.materials.findIndex(function(material) {
                return material.id === id
            }), 1)
        })
        .catch(() => {})
    };

    $scope.addMaterial = function() {
        $http.post('/admin/standard/material', {
            title: this.newMaterial
        })
        .then((response) => {
            $scope.materials.push(response.data.material);
            this.newMaterial = '';
        })
        .catch(() => {})
    };
    
    $scope.init();
}

app.run(function($rootScope) {
    $rootScope._ = _;
})

app.controller('moistureCtrl', MainCtrl)