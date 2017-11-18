angular
    .module('dryForms')
    .directive('rightSidebar', rightSidebar);

rightSidebar.$inject = [];

function rightSidebar() {
    return {
        templateUrl: 'frontend/views/layout/right-sidebar.html',
        restrict: 'EA',
        scope: {
        },
        controller: 'MainController',
        controllerAs: 'vm'
    };
}