angular
    .module('dryForms')
    .controller('LoginController', LoginController);

LoginController.$inject = ['LoginDataService', 'ngToast', 'ErrorHandlerService', '$window'];

function LoginController(LoginDataService, ngToast, ErrorHandlerService, $window) {
    let vm = this;

    vm.user = {
        email: null,
        password: null,
        rememberMe: false
    }

    vm.login = () => {
        console.log(vm.user)
        LoginDataService.login(vm.user)
            .then(response => {
                $window.localStorage.setItem('apiToken', response.access_token);
                $window.location.href = '/';
            })
            .catch(response => {
                ErrorHandlerService.handle(response)
            })
    }
}