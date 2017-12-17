'use strict';

//controlador principal de toda la aplicacion
miApp.controller('productCtrl', ['$scope','$mdDialog','$mdToast','recursoCrud','upload',function($scope,$mdDialog,$mdToast,recursoCrud,upload) {

	$scope.website = JSON.parse( localStorage.getItem('website') );
	$scope.pro = {};
	$scope.regSel = {};

	$scope.listRegisters = [];

	$scope.list = function (){

		recursoCrud.listar("ProductService.php", {accion:1,WebSitID:$scope.website.WebSitID} ).then(
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
			controller: DialogProduct,
			templateUrl: 'web/dialogProduct.html',
			parent: angular.element(document.body),
			targetEvent: ev,
			clickOutsideToClose:true,
			locals: {title:'Nuevo Producto', data: {}}
		})
		.then(function(res) {
			//guardadno lo cambios hechos
			$scope.pro = res;
			$scope.newRegister();

		}, function() {
			//cancelando la funcion
		});
	};
	$scope.prepareUpdate = function(ev,p){
		$scope.regSel = p;
		$mdDialog.show({
			controller: DialogProduct,
			templateUrl: 'web/dialogProduct.html',
			parent: angular.element(document.body),
			targetEvent: ev,
			clickOutsideToClose:true,
			locals: {title:'Editar Producto', data: p}
		})
		.then(function(res) {
			//guardadno lo cambios hechos

			$scope.updateRegister(res);

		}, function() {
			//cancelando la funcion
		});
	};


	$scope.newRegister = function (){

		$scope.pro.WebSitID = $scope.website.WebSitID;

		recursoCrud.insertar("ProductService.php", $scope.pro ).then(

			function(data) {
				$mdToast.show($mdToast.simple().textContent(data.mensaje).position('top right').hideDelay(2000));
				if(data.estado){
					$scope.pro.ProID = data.ID;
					$scope.listRegisters.push($scope.pro);

					$scope.pro = {};

				}
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}, function(data) {
				$mdToast.show($mdToast.simple().textContent(data).position('top right').hideDelay(6000));
			}
		);
	};

	$scope.updateRegister = function (p){

		var register = {ProNom:p.ProNom, ProDes:p.ProDes, ProInf:p.ProInf, ProPre:p.ProPre, ProPro:p.ProPro, ProVal:p.ProVal, ProCom:p.ProCom, ProImg1:p.ProImg1, ProImg2:p.ProImg2, ProImg3:p.ProImg3};
		var ID = {ProID:p.ProID,WebSitID: $scope.website.WebSitID};

		recursoCrud.actualizar("ProductService.php", {dato:register,ID:ID} ).then(
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
	$scope.deleteRegister = function (p){
		var ID = {ProID:p.ProID,WebSitID: $scope.website.WebSitID};

		recursoCrud.eliminar("ProductService.php", ID ).then(
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

function DialogProduct($scope, $mdDialog,title,data) {
	$scope.title = title;
    $scope.regSel = JSON.parse(JSON.stringify(data));
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
    $scope.save = function() {
        $mdDialog.hide($scope.regSel);
    };
};
