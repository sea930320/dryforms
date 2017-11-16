angular
    .module('dryForms')
    .factory('ErrorHandlerService', ErrorHandlerService);

ErrorHandlerService.$inject = ['ngToast'];

function ErrorHandlerService(ngToast) {

    return {
        handle: handle
    };

    function handle(errorResponse) {
        let errorMessage = '';
        _.forEach(errorResponse.data.errors, (value, key) => {
            _.forEach(value, (error) => {
                errorMessage += error + '<br>';
            })
        })

        ngToast.create({
            className: 'danger',
            content: errorMessage
        })
    }
}