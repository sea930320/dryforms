angular
    .module('dryForms')
    .controller('LoginController', LoginController);

LoginController.$inject = ['LoginDataService', 'ngToast', 'ErrorHandlerService', '$window', 'localStorageService'];

function LoginController(LoginDataService, ngToast, ErrorHandlerService, $window, localStorageService) {
    let vm = this;

    vm.user = {
        email: null,
        password: null
    }

    vm.login = () => {
        console.log(vm.user)
        LoginDataService.login(vm.user)
            .then(response => {
                $window.localStorage.setItem('apiToken', response.token);
                localStorageService.set('authenticated', true)
                localStorageService.set('apiToken', response.token)
                // $window.location.href = '/';
            })
            .catch(response => {
                ErrorHandlerService.handle(response)
            })
    }
}