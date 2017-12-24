'use strict';

//controlador principal de toda la aplicacion
miApp.controller('serviceCtrl', ['$scope','$mdDialog','$mdToast','recursoCrud','upload',function($scope,$mdDialog,$mdToast,recursoCrud,upload) {

	$scope.website = JSON.parse( localStorage.getItem('website') );
	$scope.ser = {};
	$scope.regSel = {};

	$scope.listRegisters = [];

	$scope.list = function (){

		recursoCrud.listar("ServiceService.php", {accion:1,WebSitID:$scope.website.WebSitID} ).then(
			function(data) {
				$scope.listRegisters = data.data;
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}
		);
	};


	$scope.prepareNew = function(ev){
		$mdDialog.show({
			controller: DialogService,
			templateUrl: 'web/dialogService.html',
			parent: angular.element(document.body),
			targetEvent: ev,
			clickOutsideToClose:true,
			locals: {title:'Nuevo Servicio', data: {}}
		})
		.then(function(res) {
			//guardadno lo cambios hechos
			$scope.ser = res;
			$scope.newRegister();

		}, function() {
			//cancelando la funcion
		});
	};
	$scope.prepareUpdate = function(ev,s){
		$scope.regSel = s;
		$mdDialog.show({
			controller: DialogService,
			templateUrl: 'web/dialogService.html',
			parent: angular.element(document.body),
			targetEvent: ev,
			clickOutsideToClose:true,
			locals: {title:'Editar Servicio', data: s}
		})
		.then(function(res) {
			//guardadno lo cambios hechos

			$scope.updateRegister(res);

		}, function() {
			//cancelando la funcion
		});
	};


	$scope.newRegister = function (){

		$scope.ser.WebSitID = $scope.website.WebSitID;

		recursoCrud.insertar("ServiceService.php", $scope.ser ).then(

			function(data) {
				$mdToast.show($mdToast.simple().textContent(data.mensaje).position('top right').hideDelay(2000));
				if(data.estado){
					$scope.ser.SerID = data.ID;
					$scope.listRegisters.push($scope.ser);

					$scope.ser = {};

				}
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}
		);
	};

	$scope.updateRegister = function (s){

		var register = {Nom:s.Nom, Des:s.Des, Det:s.Det, Img1:s.Img1, Img2:s.Img2, Img3:s.Img3};
		var ID = {SerID:s.SerID,WebSitID: $scope.website.WebSitID};

		recursoCrud.actualizar("ServiceService.php", {dato:register,ID:ID} ).then(
			function(data) {
				$mdToast.show($mdToast.simple().textContent(data.mensaje).position('top right').hideDelay(2000));
				if(data.estado){
					recursoCrud.copiar($scope.regSel,register);
                }
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}
		);
	};
	$scope.deleteRegister = function (s){
		var ID = {SerID:s.SerID,WebSitID: $scope.website.WebSitID};

		recursoCrud.eliminar("ServiceService.php", ID ).then(
			function(data) {
				$mdToast.show($mdToast.simple().textContent(data.mensaje).position('top right').hideDelay(2000));
				if(data.estado)
					$scope.listRegisters.splice(i,1);
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}
		);
	};

}]);

function DialogService($scope, $mdDialog,title,data) {
	$scope.title = title;
    $scope.regSel = JSON.parse(JSON.stringify(data));
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
    $scope.save = function() {
        $mdDialog.hide($scope.regSel);
    };
};
