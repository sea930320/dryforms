angular
    .module('dryForms')
    .config(function ($stateProvider, $urlRouterProvider, $locationProvider, $routeProvider) {
        $stateProvider
            .state('login', {
                    url: '/login',
                    fullPath: '/login',
                    templateUrl: "frontend/views/auth/login.html"
                }
            );

        $urlRouterProvider.otherwise('/');
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        });
    })