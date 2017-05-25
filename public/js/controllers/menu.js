(function() {
    app.controller('MenuCtrl', function($scope, $timeout, $mdSidenav,
        $mdUtil, $log, $mdDialog, MockService, $rootScope, CoResource,
        $mdToast) {
        var tabs = [],
            selected = null,
            previous = null;

        function loadData (parent_id){
            parent_id = parent_id || 0;
            $scope.tabs = CoResource.resources.Item.list({ parent_id: parent_id, type: 'menu', 'ignore-offset': 1 }, function (){
                $scope.tabs = $scope.tabs.result;                
                $scope.tabs = _.sortBy($scope.tabs, function (v){
                    return v.seq_number;
                });
            });    
        }
        
        loadData();

        $scope.chains = [];
        $scope.viewMenu = function (item){
            $scope.chains.push(item);
            $scope.current = item;
            loadData(item.id);
        };

        $scope.selectChain = function (item){
            if (item == 'main'){
                loadData();
                $scope.chains = [];
                $scope.current = null;
            }
            else{
                var index = $scope.chains.indexOf(item);
                $scope.chains.splice(index + 1, $scope.chains.length - 1 - index);                
                $scope.current = item;
                loadData(item.id);
            }
        };


        $rootScope.$on('dataMenuSaved', function ($e, data){          
            if (data && data.mode === 'edit'){
                $scope.current.display_name = data.$current.display_name;
                $scope.current.description = data.$current.description;
                $scope.current.name = data.$current.name;
            }
            if (!$scope.current){
                loadData();
            }
            else{
                $scope.selectChain($scope.current || 'main');    
            }
            
        });

        $scope.createMenu = function(current, ev) {
            $mdDialog.show({
                controller: 'MenuDialogCtrl',
                templateUrl: '/templates/new-menu',
                parent: angular.element(document.body),
                targetEvent: ev,
                locals : {
                    $current : null
                }
            })
            .then(function(answer) {
                $scope.alert = 'You said the information was "' + answer + '".';
            }, function() {
                $scope.alert = 'You cancelled the dialog.';
            });
        };

        $scope.removeMenu = function(current, ev) {
            // Appending dialog to document.body to cover sidenav in docs app
            if (!$scope.current){
                return;
            }
            var confirm = $mdDialog.confirm()
                .parent(angular.element(document.body))
                .title('Delete this menu `' + $scope.current.display_name + '` ?')
                .content('Are sure to delete this?')
                .ariaLabel('Delete Menu')
                .ok('Yes')
                .cancel('No')
                .targetEvent(ev);
            $mdDialog.show(confirm).then(function() {
                // MockService.menu.remove($scope.current.id);
                $rootScope.loading('show');
                CoResource.resources.Item.delete({
                    itemId: $scope.current.id
                }, function (s){
                    $rootScope.loading('hide');
                    $scope.chains.splice($scope.chains.length - 1, 1);
                    $scope.current = $scope.chains[$scope.chains.length - 1] || null;
                    $rootScope.$emit('dataMenuSaved');

                    $mdToast.show(
                        $mdToast.simple()
                            .content('Menu deleted')
                            .position($scope.getToastPosition())
                            .hideDelay(3000)
                    );
                }, function (e){
                    $rootScope.loading('hide');
                    alert('There was an error while trying to delete a menu');
                });
            }, function() {
            });
        };

        $scope.updateMenuSeqNumber = function (){
            _.each($scope.tabs, function (menu, key){
                menu.seq_number = key + 1;
                var menuTmp = CoResource.resources.Item.update({ itemId: menu.id }, {
                    seq_number: key + 1
                }, function (s){
                    console.log('item updated');
                });
            });
        };

        $scope.editMenu = function (current, $event){

            $mdDialog.show({
                controller: 'MenuDialogCtrl',
                templateUrl: '/templates/new-menu',
                parent: angular.element(document.body),
                targetEvent: $event,
                locals : {
                    $current : $scope.current || null
                }
            })
            .then(function(answer) {
                $scope.alert = 'You said the information was "' + answer + '".';
            }, function() {
                $scope.alert = 'You cancelled the dialog.';
            });
        };

    });
}());