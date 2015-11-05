var app = angular.module('puentesApp', []);

app.controller('experienciaCtrl', ['$scope', '$http','$timeout', function($scope, $http, $timeout){
	$http.get('data/actualidad.json').then(function(data){
		$scope.actualidad = data.data;
	});

	$http.get('data/trayectoria.json').then(function(data){
		$scope.trayectoria = data.data;
	});

	angular.element(document).ready(function (){
		$timeout(function (){
			$('.cbp-ntaccordion' ).cbpNTAccordion();
		}, 0, false);
	});

	$scope.tabIndex = 3;
	$scope.setTab = function(index){
		$scope.tabIndex = index;
	}

	$scope.checkTab= function(index){
		return $scope.tabIndex === index
	}



}]);


app.controller('profesionalismoCtrl', ['$scope', function($scope){
	$scope.tabIndex = 1;
	$scope.setTab = function(index){
		$scope.tabIndex = index;
	}

	$scope.checkTab= function(index){
		return $scope.tabIndex === index
	}
}]);

function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex ;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}

app.controller('cercaniaCtrl', ['$scope', '$http', '$timeout', function($scope, $http, $timeout){
	$scope.tabIndex = 1;
	$scope.setTab = function(index){
		$scope.tabIndex = index;
		$timeout(function(){
			setupTestimony();
			new CBPGridGallery( document.getElementById( 'grid-gallery' ) );
		}, 100, false);
	}

	$scope.checkTab= function(index){
		return $scope.tabIndex === index
	}

	$http.get('data/testimonios.json').then(function(data){
		$scope.testimonios = shuffle(data.data);
		
	});


}]);

function setupTestimony(){
	jQuery(document).ready(function($){
	//create the slider
	$('.cd-testimonials-wrapper').flexslider({
		selector: ".cd-testimonials > li",
		animation: "slide",
		controlNav: false,
		slideshow: false,
		smoothHeight: true,
		start: function(){
			$('.cd-testimonials').children('li').css({
				'opacity': 1,
				'position': 'relative'
			});
		}
	});

	//open the testimonials modal page
	$('.cd-see-all').on('click', function(){
		$('.cd-testimonials-all').addClass('is-visible');
	});

	//close the testimonials modal page
	$('.cd-testimonials-all .close-btn').on('click', function(){
		$('.cd-testimonials-all').removeClass('is-visible');
	});
	$(document).keyup(function(event){
		//check if user has pressed 'Esc'
		if(event.which=='27'){
			$('.cd-testimonials-all').removeClass('is-visible');	
		}
	});

	//build the grid for the testimonials modal page
	$('.cd-testimonials-all-wrapper').children('ul').masonry({
		itemSelector: '.cd-testimonials-item'
	});
});
}