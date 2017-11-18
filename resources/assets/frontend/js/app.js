angular
    .module('dryForms', [
        'ngAnimate',
        'ngResource',
        'ngSanitize',
        'ngToast',
        'angular-jwt',
        'ui.router',
        'ngRoute',
        'LocalStorageModule'
    ])
    .config(['$httpProvider', 'jwtOptionsProvider', ($httpProvider, jwtOptionsProvider) => {
        $httpProvider.interceptors.push(() => {
            return {
                'response': (response) => {
                    // Check for authorization headers
                    // And when they exists - override current "apiToken"
                    let authTokenUpdated = response.headers('authorization');
                    if (authTokenUpdated) {
                        window.localStorage.setItem("apiToken", authTokenUpdated);
                    }

                    return response;
                },
                'responseError': (error) => {
                    // When api responds that it cannot refresh token
                    // Then we should redirect user to login screen
                    if (_.has(error, 'data.api.error.message')) {
                        let redirectMessage = 'Token has expired';
                        if (_.includes(error.data.api.error.message, redirectMessage)) {
                            window.location.href = '/auth/logout';
                        }
                    }

                    throw error;
                }
            }
        });
        jwtOptionsProvider.config({
            tokenGetter: function (jwtHelper, $window) {
                let token = window.localStorage.getItem("apiToken");
                // if user has expired authToken then we need to regenerate it.
                // regeneration occurs at login page
                if (token === null) {
                    $window.location.href = '/auth/logout';
                }
                return window.localStorage.getItem("apiToken");
            },
            // whiteListedDomains: ['[A-Za-z-.]+.statscore.com', '[A-Za-z-.]+.softnetsport.com']
        });
        $httpProvider.interceptors.push('jwtInterceptor');
        $httpProvider.defaults.headers.common['Accept'] = 'application/json';
        // $httpProvider.defaults.headers.common['Authorization'] = 'Bearer ' + window.localStorage.getItem('apiToken');
    }])
    .config(['ngToastProvider', function (ngToastProvider) {
        ngToastProvider.configure({
            animation: 'slide' // or 'fade'
        });
    }])
    .config(function ($locationProvider) {
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        });
    })
    .config(function (localStorageServiceProvider) {
        localStorageServiceProvider
            .setPrefix('dryForms')
            .setStorageType('sessionStorage')
            .setNotify(true, true)
    });