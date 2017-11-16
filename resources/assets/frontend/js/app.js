angular
    .module('dryForms', [
        'ngAnimate',
        'ngResource',
        'ngSanitize',
        'ngToast'
    ])
    .config(['$httpProvider', $httpProvider => {
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
        $httpProvider.defaults.headers.common['Accept'] = 'application/json';
        $httpProvider.defaults.headers.common['Authorization'] = 'Bearer ' + window.localStorage.getItem('apiToken');
    }])
    .config(['ngToastProvider', function (ngToastProvider) {
        ngToastProvider.configure({
            animation: 'slide' // or 'fade'
        });
    }]);