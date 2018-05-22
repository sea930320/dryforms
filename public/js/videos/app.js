var app = angular.module('videosApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
}).config(function($sceDelegateProvider) {
});

function MainCtrl($rootScope,$scope, $http, $q) {
    $scope.loading = true;
    $scope.videos = [];
    $scope.newVideo = '';
    $scope.category_id = document.getElementById("category_id").value;
    $scope.init = function() {

        $http({
            url: '/admin/training/videos',
            method: "GET",
            params: {category_id: this.category_id}
        })
        .then((res) => {
            console.log(res.data);
            $scope.videos = res.data;
            $scope.loading = false;
        }).catch(err => {

        })
    }

    $scope.deleteVideo = function(id) {

        $http.delete('/admin/training/videos/' + id)
        .then((res) => {
            $scope.videos.splice($scope.videos.findIndex(function(video) {
                return video.id === id;
            }), 1);
            
        })
        .catch(() => {})

    };

    $scope.addVideo = function() {
        $http.post('/admin/training/videos', {
            category_id: this.category_id,
            url: this.newVideo
        })
        .then((response) => {
            if(response.data.error){
                return;
            }
            $scope.videos.push(response.data.video);
            this.newVideo = '';
        })
        .catch(() => {})
    };
        
    $scope.init();
}

app.run(function($rootScope) {
    $rootScope._ = _;
})

app.controller('videosCtrl', MainCtrl)