angular
    .module('dryForms')
    .factory('LoginResource', function ($resource) {
        return $resource('/api/login', {});
    });