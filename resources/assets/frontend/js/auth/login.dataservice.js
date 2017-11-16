angular
    .module('dryForms')
    .factory('LoginDataService', LoginDataService);

LoginDataService.$inject = ['LoginResource'];

function LoginDataService(LoginResource) {

    return {
        login: login,
        logout: logout
    };

    function login(data) {
        return LoginResource.save(data).$promise;
    }

    function logout() {

    }
}