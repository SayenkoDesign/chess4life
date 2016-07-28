/**
 * @fileoverview This demo is used for MarkerClusterer. It will show 100 markers
 * using MarkerClusterer and count the time to show the difference between using
 * MarkerClusterer and without MarkerClusterer.
 * @author Luke Mahe (v2 author: Xiaoxi Wu)
 */

function $(element) {
  return document.getElementById(element);
}

var speedTest = {};

speedTest.pics = null;
speedTest.map = null;
speedTest.markerClusterer = null;
speedTest.markers = [];
speedTest.infoWindow = null;

speedTest.init = function() {
  var latlng = new google.maps.LatLng(47.5444906, -122.0396651);
  var options = {
    'zoom': 10,
    'center': latlng,
    'mapTypeId': google.maps.MapTypeId.ROADMAP
  };
  
  speedTest.map = new google.maps.Map($('map'), options);
  speedTest.pics = data.photos;
  
  var useGmm = document.getElementById('usegmm');
  google.maps.event.addDomListener(useGmm, 'click', speedTest.change);
  
  var numMarkers = document.getElementById('nummarkers');
  google.maps.event.addDomListener(numMarkers, 'change', speedTest.change);
	
  speedTest.infoWindow = new google.maps.InfoWindow();

  speedTest.showMarkers();
};


speedTest.showMarkers = function() {
  speedTest.markers = [];

  var type = 1;
  if ($('usegmm').checked) {
    type = 0;
  }

  if (speedTest.markerClusterer) {
    speedTest.markerClusterer.clearMarkers();
  }

  var panel = $('markerlist');
  panel.innerHTML = '';
  var numMarkers = $('nummarkers').value;

  for (var i = 0; i < numMarkers; i++) {
    var titleText = speedTest.pics[i].photo_title;
	if (titleText === '') {
      titleText = 'No title';
    }

    var item = document.createElement('DIV');
    var title = document.createElement('A');
    title.href = '#';
    title.className = 'title';
    title.innerHTML = titleText;

    item.appendChild(title);
    panel.appendChild(item);

//alert(speedTest.pics[i].image_icon);

    var latLng = new google.maps.LatLng(speedTest.pics[i].latitude,
        speedTest.pics[i].longitude);
	
	var imageUrl = speedTest.pics[i].image_icon;
    	
	var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(24, 32));

    var marker = new google.maps.Marker({
      position: latLng,
	  icon: markerImage
	});

    var fn = speedTest.markerClickFunction(speedTest.pics[i], latLng);
    google.maps.event.addListener(marker, 'click', fn);
    google.maps.event.addDomListener(title, 'click', fn);
    speedTest.markers.push(marker);
  }

  window.setTimeout(speedTest.time, 0);
};

speedTest.markerClickFunction = function(pic, latlng) {
  return function(e) {
    e.cancelBubble = true;
    e.returnValue = false;
    if (e.stopPropagation) {
      e.stopPropagation();
      e.preventDefault();
    }
    var title = pic.photo_title;
    var address = pic.address_content;
    var fileurl = pic.photo_file_url;

    var infoHtml = '<div class="info"><p>' + address + '</p></div>';

    speedTest.infoWindow.setContent(infoHtml);
    speedTest.infoWindow.setPosition(latlng);
	speedTest.infoWindow.open(speedTest.map);
	
	
	
	jQuery('.gm-style div:first-child div:nth-child(3) div:nth-child(4) > div > div div:nth-child(3)').hide();
	//jQuery('.gm-style div:first-child div:nth-child(3) div:nth-child(4) > div > div:nth-child(1)').css('top','-110px');
	// Too remove artrow from label
	/*jQuery(".gm-style > div div").each(function(index, element) {
        jQuery(this).removeAttr('class');
		jQuery(this).addClass('element_'+index);
		if(index == 117 || index == 127 || index == 129){ jQuery(this).hide();}
		if(index == 126){
			jQuery(this).css('top','-7px');
		}
		if(index == 125){
			var top = parseInt(jQuery(this).css('top')) - 25;
			jQuery(this).css('top',parseInt(top)+'px');
		}
    });*/
	
  };
};

speedTest.clear = function() {
  $('timetaken').innerHTML = 'cleaning...';
  for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
    marker.setMap(null);
  }
};

speedTest.change = function() {
  speedTest.clear();
  speedTest.showMarkers();
};

speedTest.time = function() {
  $('timetaken').innerHTML = 'timing...';
  var start = new Date();
  if ($('usegmm').checked) {
    speedTest.markerClusterer = new MarkerClusterer(speedTest.map, speedTest.markers);
  } else {
    for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
      marker.setMap(speedTest.map);
    }
  }

  var end = new Date();
  $('timetaken').innerHTML = end - start;
};
