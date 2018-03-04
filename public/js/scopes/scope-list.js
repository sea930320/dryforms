app.directive('scopeList', ['State', '$rootScope', '$http', function(State, $rootScope, $http) {
    return {
        restrict: 'E',
        scope: {
            leftPageScopes: '=leftPageScopes',
            rightPageScopes: '=rightPageScopes',
            pageIndex: '=pageIndex',
            uoms: '=uoms',
        },
        templateUrl: '../../js/scopes/scope-list.html',
        link: function(scope) {
            scope.dragging = false;
            scope.state = State;
            scope.pending = false;

            scope.mouseOver = function(index, side) {
                if (side === 'left' && index >= scope.leftPageScopes.length) return
                if (side === 'right' && index >= scope.rightPageScopes.length) return
                if (scope.dragging) {
                    if (side === 'left') {
                        scope.leftPageScopes[index].hover = false
                    } else {
                        scope.rightPageScopes[index].hover = false
                    }
                } else {
                    if (side === 'left') {
                        scope.leftPageScopes[index].hover = true
                    } else {
                        scope.rightPageScopes[index].hover = true
                    }
                }
            };
            scope.mouseLeave = function(index, side) {
                if (side === 'left' && index >= scope.leftPageScopes.length) return
                if (side === 'right' && index >= scope.rightPageScopes.length) return
                if (side === 'left') {
                    scope.leftPageScopes[index].hover = false
                } else {
                    scope.rightPageScopes[index].hover = false
                }
            };
            scope.setHeader = function(index, side) {
                this.removeItem(index, side)
                if (side === 'left') {
                    if (scope.leftPageScopes[index].is_header) {
                        scope.leftPageScopes[index].is_header = 0;
                    } else {
                        scope.leftPageScopes[index].is_header = 1;
                    }
                } else {
                    if (scope.rightPageScopes[index].is_header) {
                        scope.rightPageScopes[index].is_header = 0;
                    } else {
                        scope.rightPageScopes[index].is_header = 1;
                    }
                }
                this.watchPendingBeforeScopeSave()
            };
            scope.removeItem = function(index, side) {
                if (side === 'left') {
                    scope.leftPageScopes[index].service = '';
                    scope.leftPageScopes[index].qty = '';
                    scope.leftPageScopes[index].selected = 0;
                    scope.leftPageScopes[index].uom = 0;
                } else {
                    scope.rightPageScopes[index].service = '';
                    scope.rightPageScopes[index].qty = '';
                    scope.rightPageScopes[index].selected = 0;
                    scope.rightPageScopes[index].uom = 0;
                }
                this.watchPendingBeforeScopeSave()
            };
            scope.selectedScope = function(scopeEle) {
                this.selectedEle = scopeEle;
            }
            scope.dragStart = function(scopeEle, index, side) {
                this.state.selected = scopeEle;
                this.state.selected.page_index = this.pageIndex;
                this.state.selected.index = index;
                this.state.selected.side = side;
            }
            scope.updateOrder = function(index, external, side) {
                scope.dragging = false
                if (scope.pageIndex !== scope.state.selected.page_index || side !== scope.state.selected.side) {
                    let totLength = this.leftPageScopes.length + this.rightPageScopes.length
                    if (this.leftPageScopes.length < Math.ceil(totLength / 2)) {
                        let fE = this.rightPageScopes.shift()
                        this.leftPageScopes.push(fE)
                    }
                    if (this.leftPageScopes.length > Math.ceil(totLength / 2)) {
                        let fE = this.leftPageScopes.pop()
                        this.rightPageScopes.unshift(fE)
                    }                    
                    if (scope.pageIndex !== scope.state.selected.page_index) {
                        this.watchPendingBeforePageSave()
                    }
                    $rootScope.$broadcast('removeEle', scope.state.selected);
                } else {
                    if (scope.state.selected.index < index) {
                        $rootScope.$broadcast('removeEle', scope.state.selected);
                    } else {
                        scope.state.selected.index++;
                        $rootScope.$broadcast('removeEle', scope.state.selected);
                    }
                }
                return true;
            };
            scope.watchPendingBeforeScopeSave = _.debounce(function() {
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
                    this.saveScopes()
                }
            }, 200);
            scope.watchPendingBeforePageSave= _.throttle(function() {
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
                    this.saveScopes()
                }
            }, 300);
            scope.saveScopes = function() {
                this.pending = true
                let pageIndex = this.pageIndex === 'misc' ? -1 : this.pageIndex
                let scopes = []
                let no = 0
                this.leftPageScopes.forEach((scope, index) => {
                    scope.page = pageIndex + 1
                    scope.no = ++no
                    scopes.push(scope)
                })
                this.rightPageScopes.forEach((scope, index) => {
                    scope.page = pageIndex + 1
                    scope.no = ++no
                    scopes.push(scope)
                })

                $http.post('/admin/standard/scopes', {
                    scopes: scopes
                }).then(response => {             
                        this.refreshPageScopes(response.data.scopes)
                        this.pending = false
                    }).catch(()=>{})
            };
            scope.refreshPageScopes = function(scopes) {
                let length = scopes.length
                for (let i = 0; i < length; i++) {
                    if (i < this.leftPageScopes.length) {
                        this.leftPageScopes[i].id = scopes[i].id
                    } else {
                        this.rightPageScopes[i - this.leftPageScopes.length].id = scopes[i].id
                    }
                }
            }
            scope.deletePage = function() {
                $rootScope.$broadcast('removePage', {
                    pageIndex: this.pageIndex
                });
            }
        }
    };
}])