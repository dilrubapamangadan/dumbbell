/**
* Angular Image Fallback
* (c) 2014-2016 Daniel Cohen. http://dcb.co.il
* License: MIT
* https://github.com/dcohenb/angular-img-fallback
*/
(function () {
	angular.module('dcbImgFallback', []).directive('ngSrc', ['imageService', imageService => { return {
		restrict: 'A',
		link: (scope, element, attr) => {

			attr.fallbackSrc = 'ssets/images/default/user.png'; 
			let newSrc = attr.fallbackSrc ? imageService.setMissing(attr.fallbackSrc) : imageService.getMissing(); 
			let errorHandler = () => { 
				let newSrc = attr.fallbackSrc ? imageService.setMissing(attr.fallbackSrc) : imageService.getMissing();

				if (element[0].src !== newSrc) {
					element[0].src = newSrc;
				}
			}; 
			if (element[0].src === imageService.getLoading()) {
				element[0].src = newSrc;
			}

			element.on('error', errorHandler);

			scope.$on('$destroy', () => {
				element.off('error', errorHandler);
			});

		}
	};
}]).directive('ngSrc', ['$interpolate', 'imageService', ($interpolate, imageService) => {

	let linkFunction = (scope, element, attr) => {
		attr.loadingSrc = 'assets/images/default/loading.webp'; 
		element[0].src = attr.loadingSrc ? imageService.setLoading(attr.loadingSrc) : imageService.getLoading();

		let img = new Image();
		img.src = $interpolate(attr.imgSrc)(scope);

		img.onload = () => {
			img.onload = null;
			if (element[0].src !== img.src) {
				element[0].src = img.src;
			}
		};
	};

	return {
		restrict: 'A',
		compile: (el, attr) => { 
			attr.imgSrc = attr.ngSrc;
			delete attr.ngSrc;

			return linkFunction;
		}
	};
}])

.factory('imageService', () => { 
	let base64prefix = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAwIDEwMDAiPjxkZWZzPjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50IiBjeD0iNTAwIiBjeT0iNTAwIiByPSI1MDAiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiNkZmRmZGYiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiM5OTkiLz48L3JhZGlhbEdyYWRpZW50PjwvZGVmcz48cmVjdCBmaWxsPSJ1cmwoI3JhZGlhbC1ncmFkaWVudCkiIHdpZHRoPSIxMDAwIiBoZWlnaHQ9IjEwMDAiLz48cGF0aCBmaWxsPSIjZmZmIiBkPSJNNjAxIDQxNGwwIDBWNTg2bDAgMEgzOTlsMCAwVjQxNGwwIDBINjAxWm0wLTE0SDM5OUExNCAxNCAwIDAgMCAzODUgNDE0djE3M2ExNCAxNCAwIDAgMCAxNCAxNEg2MDFBMTQgMTQgMCAwIDAgNjE1IDU4NlY0MTRhMTQgMTQgMCAwIDAtMTQtMTRoMFpNNTc';
	let loadingDefault = `${base64prefix}1IDUwMmE3NyA3NyAwIDAgMC0yNC01NCA3NiA3NiAwIDAgMC0yNS0xNiA3NSA3NSAwIDAgMC01NyAxQTc0IDc0IDAgMCAwIDQzMCA0NzQgNzMgNzMgMCAwIDAgNDMxIDUzMGE3MiA3MiAwIDAgMCAzOSAzOCA3MCA3MCAwIDAgMCA1NC0xIDY5IDY5IDAgMCAwIDM3LTM4IDY4IDY4IDAgMCAwIDQtMTZsMSAwYTEwIDEwIDAgMCAwIDEwLTEwYzAgMCAwLTEgMC0xaDBabS0xNSAyNmE2NyA2NyAwIDAgMS0zNyAzNSA2NiA2NiAwIDAgMS01MC0xIDY0IDY0IDAgMCAxLTM0LTM1QTYzIDYzIDAgMCAxIDQ0MCA0NzkgNjIgNjIgMCAwIDEgNDU0IDQ1OSA2MiA2MiAwIDAgMSA0NzQgNDQ2YTYxIDYxIDAgMCAxIDIzLTQgNjAgNjAgMCAwIDEgNDIgMTlBNTkgNTkgMCAwIDEgNTUyIDQ4MGE1OCA1OCAwIDAgMSA0IDIyaDBjMCAwIDAgMSAwIDFhMTAgMTAgMCAwIDAgOSAxMCA2NyA2NyAwIDAgMS01IDE1aDBaIi8+PC9zdmc+`;
	let missingDefault = `${base64prefix}yIDQ1MGEyMiAyMiAwIDEgMS0yMi0yMkEyMiAyMiAwIDAgMSA1NzIgNDUwWk01ODYgNTcySDQxNFY1NDNsNTAtODYgNTggNzJoMTRsNTAtNDN2ODZaIi8+PC9zdmc+`;

	return {
		getLoading: () => {
			return loadingDefault;
		},
		getMissing: () => {
			return missingDefault;
		},
		setLoading: (newSrc) => {
			return loadingDefault = newSrc;
		},
		setMissing: (newSrc) => {
			return missingDefault = newSrc;
		}
	};
});
}());