angular
    .module('dryForms')
    .directive('topNav', topNav);

topNav.$inject = [];

function topNav() {
    return {
        templateUrl: 'frontend/views/layout/top-nav.html',
        restrict: 'EA',
        scope: {
        },
        controller: 'MainController',
        controllerAs: 'vm'
    };
}