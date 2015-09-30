function initialize() {
    var latlng = new google.maps.LatLng(52.602044, 39.504733);
    var myOptions = {
        zoom: 17,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.HYBRID 
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);
	setMarkers(map, korp);
  }
  
var korp = [
    ['5 корпус', 52.602471,39.500114],
    ['4 корпус', 52.602868,39.500715],
    ['общежитие', 52.602448,39.501445],
    ['переход', 52.602741,39.501933],
    ['3 корпус', 52.60253,39.502507 ],
    ['столовая', 52.603061,39.502775],
    ['спортивный корпус',52.601871,39.502657 ],
    ['1 корпус', 52.602588,39.504116],
    ['лекционный корпус',52.602992,39.504862 ],
    ['административный корпус', 52.602018,39.504808],
    ['2 корпус', 52.602556,39.505554],
    ['9 корпус', 52.602507,39.506541],
    ['дорога жизни', 52.600376,39.507254]
];
function setMarkers(map, locations) {
    for (var i = 0; i < locations.length; i++) {
        var korp = locations[i];
        var myLatLng = new google.maps.LatLng(korp[1], korp[2]);
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: korp[0],
        });
    }
}
$(document).ready(function(){
	initialize();
});