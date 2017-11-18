angular
    .module('dryForms')
    .directive('leftSidebar', leftSidebar);

leftSidebar.$inject = [];

function leftSidebar() {
    return {
        templateUrl: 'frontend/views/layout/left-sidebar.html',
        restrict: 'EA',
        scope: {
        },
        controller: 'MainController',
        controllerAs: 'vm'
    };
}