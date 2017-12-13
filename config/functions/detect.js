/*!
 * Developed by Kevin Warren, https://twitter.com/SkynetWebS
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 * Detect Device 1.0.3
 *
 * Last Modification Date: 28/04/2016
 */
var detect = {
	screenWidth: function () {
		return window.screen.width;
	},
	screenHeight: function () {
		return window.screen.height;
	},
	viewportWidth: function () {
		return document.documentElement.clientWidth;
	},
	viewportHeight: function () {
		return document.documentElement.clientHeight;
	},
	latitude:function(id){
		if (navigator.geolocation && navigator.geolocation.getCurrentPosition){
			navigator.geolocation.getCurrentPosition(function(position){
				document.getElementById(id).innerHTML=position.coords.latitude;
			});
		} else {
			document.getElementById(id).innerHTML='N/A';
		}
	},
	longitude:function(id){
		if (navigator.geolocation && navigator.geolocation.getCurrentPosition){
			navigator.geolocation.getCurrentPosition(function(position){
				document.getElementById(id).innerHTML=position.coords.longitude;
			});
		} else {
			document.getElementById(id).innerHTML='N/A';
		}
	},
	address:function(id){
		var accuracy=0;
		if (navigator.geolocation && navigator.geolocation.getCurrentPosition){
			navigator.geolocation.getCurrentPosition(function(position){
				$.get('http://maps.googleapis.com/maps/api/geocode/json?latlng='+position.coords.latitude+','+position.coords.longitude+'&sensor=false',function(response){
					document.getElementById(id).innerHTML=response.results[accuracy].formatted_address;
				},'json');
			});
		} else {
			document.getElementById(id).innerHTML='N/A';
		}
	}
};