/***************************************************************************
 *
 *   Usermap-system for MyBB
 *   Copyright: © 2008-2013 Online - Urbanus / Website: http://www.Online-Urbanus.be
 *
 *   Copyright: © 2016 Jockl
 *   http://forum.mybboard.de/user-2693.html
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is based on the GPLed mod called "skunkmap" version 1.1,
 *   made by King Butter - NCAAbbs SkunkWorks Team
 *   <http://www.ncaabbs.com>, which was released on the MyBB Mods site on
 *   22nd May 2007 <http://mods.mybboard.net/view/skunkmap>.
 *
 *   So, this way, I wish to credit the original developer for their
 *   indirect contribution to this work.
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 ***************************************************************************/
 
function initialize(lat, lon, zoom, myaddplaces, iBase, pImg)
{
	map = new google.maps.Map(document.getElementById("map"), {
		center: new google.maps.LatLng(lat, lon),
		zoom: zoom,
		mapTypeId: 'roadmap'
	});

  var infowindow = new google.maps.InfoWindow();
  var iconBase = iBase;  
  var pinImg = pImg;           
  var locations = myaddplaces;
  var marker, i;

  for (i = 0; i < locations.length; i++){  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        animation: google.maps.Animation.DROP,
        icon: iconBase + pinImg,
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
  }
                              
	setPins(map);
  google.maps.event.addDomListener(window, 'load', initialize);
}