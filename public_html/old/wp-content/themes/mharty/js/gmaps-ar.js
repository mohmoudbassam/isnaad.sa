Object.keys = Object.keys || function (o) {
    var result = [];
    for (var name in o) {
        if (o.hasOwnProperty(name))
            result.push(name);
    }
    return result;
};
jQuery(document).ready(function ($) {
    var mapStyle,
        mapColor,
        markerIcon,
        centerlng,
        centerlat,
        zoomLevel,
        latLng,
        infoWindows,
        mh_map_mobile_device = navigator.userAgent.match(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/) !== null,
        mh_google_api_key = mh_theme_map.google_api_key;
    var map = [];
    var infoWindows = [];

    window.mapAPI_Loaded = function () {

            for (var i = 0; i < $('.mhc_map').length; i++) {
                infoWindows[i] = [];
            }

            $('.mhc_map').each(function (i) {
                zoomLevel = parseFloat($(this).attr('data-zoom'));
                centerlat = parseFloat($(this).attr('data-center-lat'));
                centerlng = parseFloat($(this).attr('data-center-lng'));
                markerIcon = $(this).attr('data-pin-image');
                mousewheel = $(this).attr('data-mouse-wheel') == 'on' ? true : false;
                mapStyle = $(this).attr('data-map-style');
                mapColor = $(this).attr('data-map-color');

                if (isNaN(zoomLevel)) {
                    zoomLevel = 12;
                }
                if (isNaN(centerlat)) {
                    centerlat = 51.47;
                }
                if (isNaN(centerlng)) {
                    centerlng = -0.268199;
                }
                latLng = new google.maps.LatLng(centerlat, centerlng);

                //style dark
                if (mapStyle == '2') {
                    styles = [{
                        "featureType": "all",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "saturation": 36
						}, {
                            "color": "#000000"
						}, {
                            "lightness": 40
						}]
					}, {
                        "featureType": "all",
                        "elementType": "labels.text.stroke",
                        "stylers": [{
                            "visibility": "on"
						}, {
                            "color": "#000000"
						}, {
                            "lightness": 16
						}]
					}, {
                        "featureType": "all",
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
						}]
					}, {
                        "featureType": "administrative",
                        "elementType": "geometry.fill",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 20
						}]
					}, {
                        "featureType": "administrative",
                        "elementType": "geometry.stroke",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 17
						}, {
                            "weight": 1.2
						}]
					}, {
                        "featureType": "landscape",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 20
						}]
					}, {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 21
						}]
					}, {
                        "featureType": "road.highway",
                        "elementType": "geometry.fill",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 17
						}]
					}, {
                        "featureType": "road.highway",
                        "elementType": "geometry.stroke",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 29
						}, {
                            "weight": 0.2
						}]
					}, {
                        "featureType": "road.arterial",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 18
						}]
					}, {
                        "featureType": "road.local",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 16
						}]
					}, {
                        "featureType": "transit",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 19
						}]
					}, {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#000000"
						}, {
                            "lightness": 17
						}]
					}];

                    //style light with color
                } else if (mapStyle == '3') {
                    styles = [{
                        "featureType": "administrative",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#444444"
						}]
					}, {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [{
                            "color": "#f2f2f2"
						}]
					}, {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "off"
						}]
					}, {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [{
                            "saturation": -100
						}, {
                            "lightness": 45
						}]
					}, {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "simplified"
						}]
					}, {
                        "featureType": "road.arterial",
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
						}]
					}, {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "off"
						}]
					}, {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [{
                            "color": mapColor
						}, {
                            "visibility": "on"
						}]
					}];

                    //style 4 dark with color
                } else if (mapStyle == '4') {
                    styles = [{
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#343434"
						}]
					}, {
                        "featureType": "landscape",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": mapColor
						}]
					}, {
                        "featureType": "poi",
                        "stylers": [{
                            "color": mapColor
						}, {
                            "lightness": -7
						}]
					}, {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": mapColor
						}, {
                            "lightness": -28
						}]
					}, {
                        "featureType": "road.arterial",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": mapColor
						}, {
                            "visibility": "on"
						}, {
                            "lightness": -15
						}]
					}, {
                        "featureType": "road.local",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": mapColor
						}, {
                            "lightness": -18
						}]
					}, {
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#ffffff"
						}]
					}, {
                        "elementType": "labels.text.stroke",
                        "stylers": [{
                            "visibility": "off"
						}]
					}, {
                        "featureType": "transit",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": mapColor
						}, {
                            "lightness": -34
						}]
					}, {
                        "featureType": "administrative",
                        "elementType": "geometry",
                        "stylers": [{
                            "visibility": "on"
						}, {
                            "color": "#343434"
						}, {
                            "weight": 0.8
						}]
					}, {
                        "featureType": "poi.park",
                        "stylers": [{
                            "color": mapColor
						}]
					}, {
                        "featureType": "road",
                        "elementType": "geometry.stroke",
                        "stylers": [{
                            "color": "#343434"
						}, {
                            "weight": 0.3
						}, {
                            "lightness": 10
						}]
					}];
                    //default style 1
                } else {
                    styles = [];
                }

                var styledMap = new google.maps.StyledMapType(styles, {
                    name: "Styled Map"
                });

                var mapOptions = {
                    center: latLng,
                    zoom: zoomLevel,
                    mapTypeControlOptions: {
                        mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                    },
                    scrollwheel: mousewheel,
                    panControl: false,
                    zoomControl: true,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.LARGE,
                        position: google.maps.ControlPosition.LEFT_CENTER
                    },
                    mapTypeControl: false,
                    scaleControl: true,
                    streetViewControl: true,
                    gestureHandling: 'cooperative',

                };

                map[i] = new google.maps.Map(document.getElementById($(this).attr('id')), mapOptions);

                map[i].mapTypes.set('map_style', styledMap);
                map[i].setMapTypeId('map_style');

                var $count = i;

                google.maps.event.addListenerOnce(map[i], 'tilesloaded', function () {

                    var map_id = $(map[i].getDiv()).attr('id');

                    if (markerIcon.length > 0) {
                        var markerIconLoad = new Image();
                        markerIconLoad.src = markerIcon;

                        $(markerIconLoad).load(function () {
                            setMarkers(map[i], map_id, $count);
                        });

                    } else {
                        setMarkers(map[i], map_id, $count);
                    }
                });

                google.maps.event.addListenerOnce(map[i], 'idle', function () {
                    google.maps.event.trigger(map[i], 'resize');
                });

            });

        }
        //&signed_in=true
    if (typeof google == 'undefined') {
        $.getScript('https://maps.googleapis.com/maps/api/js?key=' + mh_google_api_key + '&v=3.20&sensor=false&callback=mapAPI_Loaded&language=ar');
    } else {
        $(window).on("pronto.render", function () {
            mapAPI_Loaded();
        });
    }
    //add map pins
    function setMarkers(map, map_id, count) {

        $('.mhc_map_pins.' + map_id).each(function () {

            $(this).find('.mhc_map_pin').each(function (i) {

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng($(this).attr('data-lat'), $(this).attr('data-lng')),
                    map: map,
                    visible: false,
                    mapIndex: count,
                    infoWindowIndex: i,
                    icon: $('#' + map_id).attr('data-pin-image'),
                    optimized: false
                });

                marker.setOptions({
                    visible: true
                });

                if ($(this).attr('data-title') != '' && $(this).attr('data-title') != '<br />' && $(this).attr('data-title') != '<br/>') {
                    var infowindow = new google.maps.InfoWindow({
                        content: $(this).html()
                    });

                    infoWindows[count].push(infowindow);

                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            infoWindows[this.mapIndex][this.infoWindowIndex].open(map, this);
                        }

                    })(marker, i));
                }


            });

        });


    } //pins

});