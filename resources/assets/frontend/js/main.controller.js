angular
    .module('dryForms')
    .controller('MainController', MainController);

MainController.$inject = ['localStorageService'];

function MainController(localStorageService) {
    let vm = this;

    vm.userAuthenticated = () => {
        return localStorageService.get('authenticated');
    }
}