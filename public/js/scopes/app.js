var app = angular.module('scopesApp', ['infinite-scroll', 'dndLists'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
}).config(function($sceDelegateProvider) {
    $sceDelegateProvider.resourceUrlWhitelist([
        // Allow same origin resource loads.
        'self',
        // Allow loading from our assets domain.  Notice the difference between * and **.
        'https://api.reddit.com/**'
    ]);
});

app.factory('State', function() {
    var State = function() {
        this.selected = null;
    }
    return State;
})

function MainCtrl($rootScope,$scope, $http, $q, State) {
    $scope.loading = true;
    $scope.form = {};
    $scope.uoms = [];
    $scope.busy = false;
    $scope.endPageFetch = false;
    $scope.curPageNum = 0;
    $scope.pageCount = 0;
    $scope.left_scopes= [];
    $scope.right_scopes= [];
    $scope.leftMiscScopes = [];
    $scope.rightMiscScopes = [];
    $scope.defLen = 50;
    $scope.noteRowStart = this.defLen;
    $scope.state = State;
    $scope.pending = false;
    $scope.isbusy = false;
    // $scope.$watch('models', function(model) {
    //     $scope.modelAsJson = angular.toJson(model, true);
    // }, true);
    $scope.$on('removeEle', function(evt, data) {
        if (data.page_index === 'misc') {
            if (data.side === 'left') {
                $scope.leftMiscScopes.splice(data.index, 1);
            } else {
                $scope.rightMiscScopes.splice(data.index, 1);
            }
            let totLength = $scope.leftMiscScopes.length + $scope.rightMiscScopes.length
            if ($scope.leftMiscScopes.length < Math.ceil(totLength / 2)) {
                let fE = $scope.rightMiscScopes.shift()
                $scope.leftMiscScopes.push(fE)
            }
            if ($scope.leftMiscScopes.length > Math.ceil(totLength / 2)) {
                let fE = $scope.leftMiscScopes.pop()
                $scope.rightMiscScopes.unshift(fE)
            }
        } else {
            if (data.side === 'left') {
                $scope.left_scopes[data.page_index].splice(data.index, 1);
            } else {
                $scope.right_scopes[data.page_index].splice(data.index, 1);
            }
            let totLength = $scope.left_scopes[data.page_index].length + $scope.right_scopes[data.page_index].length
            if ($scope.left_scopes[data.page_index].length < Math.ceil(totLength / 2)) {
                let fE = $scope.right_scopes[data.page_index].shift()
                $scope.left_scopes[data.page_index].push(fE)
            }
            if ($scope.left_scopes[data.page_index].length > Math.ceil(totLength / 2)) {
                let fE = $scope.left_scopes[data.page_index].pop()
                $scope.right_scopes[data.page_index].unshift(fE)
            }
        }
        $scope.watchPendingBeforePageSave(data.page_index)
    })
    $scope.$on('removePage', function(evt, data) {
        let pageIndex = data.pageIndex
        $scope.left_scopes.splice(pageIndex, 1)
        $scope.right_scopes.splice(pageIndex, 1)
        $scope.pageCount--
        $scope.curPageNum = $scope.pageCount
        $http.delete('/admin/standard/scopes/' + (pageIndex + 1))
        .then(response => {
        }).catch(()=>{})
    })
    $scope.watchPendingBeforePageSave = function(pageIndex) {
        let downCount = 15
        if (this.pending) {
            var pendingCheck = setInterval(() => {
                if (downCount < 0) {
                    clearInterval(pendingCheck)
                    // notifiy error
                }
                downCount--
                if (!this.pending) {
                    clearInterval(pendingCheck)
                    this.saveScopes()
                }
            }, 100)
        } else {
            this.saveScopes(pageIndex)
        }
    }
    $scope.saveScopes = function(pageIndex) {
        this.pending = true
        let page = pageIndex === 'misc' ? 0 : pageIndex
        let scopes = []
        let no = 0
        if (pageIndex === 'misc') {
            this.leftMiscScopes.forEach((scope, index) => {
                scope.page = page
                scope.no = ++no
                scopes.push(scope)
            })
            this.rightMiscScopes.forEach((scope, index) => {
                scope.page = page
                scope.no = ++no
                scopes.push(scope)
            })
        } else {
            this.left_scopes[pageIndex].forEach((scope, index) => {
                scope.page = pageIndex + 1
                scope.no = ++no
                scopes.push(scope)
            })
            this.right_scopes[pageIndex].forEach((scope, index) => {
                scope.page = pageIndex + 1
                scope.no = ++no
                scopes.push(scope)
            })
        }

        $http.post('/admin/standard/scopes', {
            scopes: scopes
        }).then(response => {
                this.refreshPageScopes(pageIndex, response.data.scopes)
                this.pending = false
            }).catch(()=>{})
    }
    $scope.refreshPageScopes = function(pageIndex, scopes) {
        let length = scopes.length
        if (pageIndex !== 'misc') {
            for (let i = 0; i < length; i++) {
                if (i < this.left_scopes[pageIndex].length) {
                    this.left_scopes[pageIndex][i].id = scopes[i].id
                } else {
                    this.right_scopes[pageIndex][i - this.left_scopes[pageIndex].length].id = scopes[i].id
                }
            }
        } else {
            for (let i = 0; i < length; i++) {
                if (i < this.leftMiscScopes.length) {
                    this.leftMiscScopes[i].id = scopes[i].id
                } else {
                    this.rightMiscScopes[i - this.leftMiscScopes.length].id = scopes[i].id
                }
            }
        }
    }
    $scope.init = function() {
        const apis = [
            $http.get('/admin/standard-scopes/form'),
            $http.get('/admin/uoms/jsonResult')
        ]

        $q.all(apis)
            .then((res) => {
                $scope.form = res[0].data.form
                let uoms = res[1].data.uoms
                $scope.uoms = ['----']
                uoms.forEach((uom) => {
                    $scope.uoms[uom.id] = uom.title
                })
                $scope.loading = false
            }).catch(err => {
            })
    }
    $scope.nextPage = function() {
        if ($scope.busy) return;
        $scope.busy = true;
        $scope.curPageNum++;
        
        var url = "/admin/standard/scopes/" + $scope.curPageNum;
        $http.get(url).then(function(res) {
            $scope.pageCount = res.data.maxPage;
            if ($scope.curPageNum > $scope.pageCount) {
                $scope.curPageNum = $scope.pageCount;                
                $scope.loadingCompleted();
                return 1;
            }
            $scope.addLoadedScopes(res.data.curPageScopes);            
            return 0;
        }.bind($scope));
    };
    $scope.loadingCompleted = function() {
        var url = "/admin/standard/scopes/0";
        $http.get(url)
            .then(response => {
                $scope.pageCount = response.data.maxPage
                let miscPageScopes = response.data.curPageScopes
                let length = miscPageScopes.length
                for (let i = 0; i < $scope.defLen - length; i++) {
                    miscPageScopes.push({
                        page: 0,
                        service: '',
                        units: '',
                        uom: 0
                    })
                }
                length = miscPageScopes.length
                // $scope.noteRowStart = $scope.form.additional_notes_show === 1 ? length * 3 / 4 : length

                for (let i = 0; i < length; i++) {
                    miscPageScopes[i].uom = miscPageScopes[i].uom ? miscPageScopes[i].uom : 0
                    if (i < length / 2) {
                        $scope.leftMiscScopes.push(miscPageScopes[i])
                    } else {
                        $scope.rightMiscScopes.push(miscPageScopes[i])
                    }
                }
                $scope.endPageFetch = true;
                $scope.busy = false;
            }).catch(err => {
            })        
    };
    $scope.addLoadedScopes = function(curPageScopes) {
        let leftPageScopes = []
        let rightPageScopes = []
        let length = curPageScopes.length
        for (let i = 0; i < $scope.defLen - length; i++) {
            curPageScopes.push({
            page: $scope.curPageNum,
            service: '',
            units: '',
            uom: 0
            })
        }
        length = curPageScopes.length

        for (let i = 0; i < length; i++) {
            curPageScopes[i].uom = curPageScopes[i].uom ? curPageScopes[i].uom : 0
            if (i < length / 2) {
            leftPageScopes.push(curPageScopes[i])
            } else {
            rightPageScopes.push(curPageScopes[i])
            }
        }

        $scope.left_scopes.push(leftPageScopes)
        $scope.right_scopes.push(rightPageScopes)
        $scope.busy = false;
    };
    $scope.addNewPage = function() {
        let scopes = []
        let no = 0
        this.isbusy = true
        
        for (let i = 0; i < this.defLen; i++) {
            scopes.push({
                page: this.curPageNum + 1,
                service: '',
                units: '',
                uom: 0,
                no: ++no
            })
            if (i === 0 || i === Math.floor(this.defLen / 2)) {
                scopes[i].is_header = 1
            }
        }
        $http.post('/admin/standard/scopes', {
            scopes: scopes
        }).then(response => {
                this.refreshNewPageScopes(response.data.scopes)
            }).catch(()=>{})
      };
    $scope.refreshNewPageScopes = function(scopes) {
        let leftPageScopes = []
        let rightPageScopes = []
        let length = scopes.length

        for (let i = 0; i < length; i++) {
            scopes[i].uom = scopes[i].uom ? scopes[i].uom : 0
            if (i < length / 2) {
                leftPageScopes.push(scopes[i])
            } else {
                rightPageScopes.push(scopes[i])
            }
        }
        $scope.pageCount++
        $scope.curPageNum = $scope.pageCount
        $scope.left_scopes.push(leftPageScopes)
        $scope.right_scopes.push(rightPageScopes)
        $scope.isbusy = false
    };

    $scope.saveForm = _.debounce(function() {
        $http.post('/admin/standard-scopes/form-update', this.form).then(response => {
        }).catch(()=>{})
      }, 500)
    $scope.init();
}

app.run(function($rootScope) {
    $rootScope._ = _;
})

app.controller('scopesCtrl', MainCtrl)

