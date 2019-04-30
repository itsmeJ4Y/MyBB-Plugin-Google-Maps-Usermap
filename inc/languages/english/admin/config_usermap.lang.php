<?php
/***************************************************************************
 *
 *   Usermap-system for MyBB
 *   Copyright: © 2008-2013 Online - Urbanus / Website: http://www.Online-Urbanus.be
 *
 *   Copyright: © 2016 Jockl
 *   http://forum.mybboard.de/user-2693.html
 * 	 Copyright: © 2019 itsmeyJAY
 *   http://forum.mybb.de/user-10220.html 
 *
 *   Translated in german: 27/10/2009 by BeeJayZZR http://www.zzr-forum.de
 *   (translation modified according UTF8-without BOM by Jockl)
 *   Translation modified: 12.04.2019 von Gerti & Schnapsnase https://mybb.de
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is based on the GPLed mod called "skunkmap" version 1.1, made by King Butter - NCAAbbs SkunkWorks Team <http://www.ncaabbs.com>, which was released on the MyBB Mods site on 22nd May 2007 <http://mods.mybboard.net/view/skunkmap>.
 *
 *   So, I call my special thanks to the maker(s) of that program!
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

$l['usermap'] = "usermap";
$l['save'] = "Save";

$l['can_manage_usermap'] = "Can edit usermap";

$l['can_view_usermap'] = "Can usermap see?";
$l['can_add_usermap_pin'] = "Can create a PIN in usermap?";

$l['admin_log_config_usermap_add_place'] = "Created usermaps #{1} ({2})";
$l['admin_log_config_usermap_edit_place'] = "Changed user location/places #{1} ({2})";
$l['admin_log_config_usermap_delete_place'] = "Deleted user location/places #{1} ({2})";
$l['admin_log_config_usermap_order_places'] = "Sorted user locations/places";

$l['admin_log_config_usermap_add_pinimg'] = "Created PIN image #{1} ({2})";
$l['admin_log_config_usermap_edit_pinimg'] = "Changed PIN image #{1} ({2})";
$l['admin_log_config_usermap_delete_pinimg'] = "Deleted PIN image #{1} ({2})";

$l['nav_manage_places'] = "Edit usermap";
$l['nav_add_place'] = "Create usermap";
$l['nav_edit_place'] = "Change usermap";
$l['nav_manage_pinimgs'] = "Edit PIN images";
$l['nav_add_pinimg'] = "Create PIN image";
$l['nav_edit_pinimg'] = "Change PIN image";

$l['nav_manage_places_desc'] = "Here you can edit the location/places in your forum.";
$l['nav_add_place_desc'] = "Here you can create a usermap location/place.";
$l['nav_edit_place_desc'] = "Here you can change a user usermap location/place.";
$l['nav_manage_pinimgs_desc'] = "Here you can edit the usermap PIN images in your forum.";
$l['nav_add_pinimg_desc'] = "Here you can add a usermap PIN image.";
$l['nav_edit_pinimg_desc'] = "Here you can edit a usermap PIN image.";

$l['places'] = "Cards";
$l['order'] = "Sort";
$l['save_order'] = "Save sorting";
$l['no_places'] = "There are no cards";

$l['place_name'] = "Card name";
$l['place_lat'] = "Latitude";
$l['place_lon'] = "Longitude";
$l['place_zoom'] = "Zoom factor";
$l['place_displayorder'] = "Display sorting";
$l['place_default'] = "Standard usermap";

$l['error_missing_name'] = "No name specified for this location/place";
$l['error_missing_lat'] = "No latitude specified for this location/place";
$l['error_missing_lon'] = "No longitude specified for this location/place";
$l['error_missing_zoom'] = "No zoom factor specified for this location/place";
$l['error_missing_displayorder'] = "No display order specified for this location/place";
$l['error_missing_default'] = "No default value specified for this location/place";
$l['error_missing_order'] = "No order or sorting information specified";
$l['placedoesntexist'] = "The selected location/place does not exist";

$l['delete_place_confirmation'] = "Do you really want to delete the location/place?";

$l['added_place'] = "The location/place was successfully added.";
$l['edited_place'] = "The location/place was successfully edited.";
$l['deleted_place'] = "The location/place was successfully deleted.";
$l['ordered_places'] = "The display order of the locations/places was changed successfully.";

$l['pinimgs'] = "PIN pictures";
$l['no_pinimgs'] = "There are no PIN images.";

$l['pinimg_name'] = "Name PIN image";
$l['pinimg_file'] = "PIN image";
$l['pinimg_default'] = "Default PIN image";

$l['error_missing_pinimg_name'] = "No name specified for the PIN image";
$l['error_missing_pinimg_file'] = "No PIN image has been uploaded for use";
$l['error_missing_pinimg_default'] = "No PIN image was selected by default";
$l['not_writable'] = "The directory does not have write access chmod 777:<br />\n{1}";
$l['error_uploadfailed'] = "Error occurred while uploading the image";
$l['pinimgdoesntexist'] = "Selected PIN image not found";

$l['delete_pinimg_confirmation'] = "Do you really want to delete the PIN image?";

$l['added_pinimg'] = "The PIN image was successfully added.";
$l['edited_pinimg'] = "The PIN image was successfully edited";
$l['deleted_pinimg'] = "The PIN image was successfully deleted";

$l['usermap_plugin_desc'] = "Adds a Google usermap to your MyBB forum. Users can set a PIN for their residence here.<br /><i>Support <a href=\"https://www.mybb.de/forum/user-2693.html\" target=\"_blank\" rel=\"noopener\">Jockl</a> (up to V 1.4.4).<br />Support of <a href=\"//https://www.mybb.de/forum/user-10220.html\" target=\"_blank\" rel=\"noopener\">itsmeJAY</a> (V 1.4.5)</i>";
$l['usermap_plugin_link'] = "https://www.mybboard.de/erweiterungen/18x/plugins-neueseiten/usermap2/";

$l['setting_group_usermap'] = "Usermap Options";
$l['setting_group_usermap_desc'] = "Here you find the settings to configure the Usermap plugin. If you have questions about the API key you need, please use the links given in the ACP or ask in the MyBB forum \"https://mybb.de/forum/thread-30501.html\".";

$l['setting_usermap_apikey'] = "API key for \"Maps JavaScript\"";
$l['setting_usermap_apikey_desc'] = "Below enter the API key required for the usermaps Javascript <i>(interactive usermap display)</i> which you need to generate in a Google usermaps account.<br /><b>Important:</b> If you don't have one yet, you have to create a <a href=\"https://tinyurl.com/y48cdkow\" target=\"_blank\" rel=\"noopener\">account</a> at Google. The monthly <a href=\"https://tinyurl.com/y3p9zps5\" target=\"_blank\" rel=\"noopener\">exempt amount</a> <i>(as of: 04/2019)</i> is completely sufficient for a MyBB forum. See <a href=\"https://cloud.google.com/maps-platform/maps/?hl=en\" target=\"_blank\" rel=\"noopener\">here</a>.<br /><b>Hint:</b> In your Google Maps account, type <i>(under API Restriction)</i> the key(s) only the API Restrictions:<br />\"Maps JavaScript API\", \"Geocoding API\", \"Places API\", \"Maps Elevation API\" and \"Maps Embed API\" free. All information on obtaining a key, see <a href=\"https://cloud.google.com/maps-platform/maps/?hl=en\" target=\"_blank\" rel=\"noopener\">here</a> and <a href=\"https://agentur-blueline.de/blog/google-maps-api-key-anleitung\" target=\"_blank\" rel=\"noopener\">here</a>.";

$l['setting_usermap_apikeytwo'] = "API key for \"Geocoding\"";
$l['setting_usermap_apikeytwo_desc'] = "Below is the key for geocoding <i>(conversion of addresses to geographic coordinates or vice versa > required to set a marker or PIN in the usermap)</i> enter.<br /><b>Tip:</b> Sometimes it may be sufficient to enter the above key <i>(from usermaps JavaScript)</i>. If it doesn't work, you will need to generate a separate key in your GoogleMaps account";

$l['setting_usermap_apikeythree'] = "API key for \"Elevation\"";
$l['setting_usermap_apikeythree_desc'] = "Below <i>(if required)</i> enter the required API key for Elevation <i>(to retrieve the elevation data of defined locations)</i>. You must generate the key in your GoogleMaps account.<br /><b>Tip:</b> Sometimes it may be sufficient to enter the first key <i>(from usermaps JavaScript)</i>. If it doesn't work, you will need to generate a separate key in your GoogleMaps account.";

$l['setting_usermap_width'] = "Width of the usermap";
$l['setting_usermap_width_desc'] = "Adjust the width of the usermap. The unit is pixels";

$l['setting_usermap_height'] = "Height of the usermap";
$l['setting_usermap_height_desc'] = "Adjust the height of the usermap. The unit is pixels";

$l['setting_usermap_profile'] = "Show Usermap PIN in User Profile";
$l['setting_usermap_profile_desc'] = "Show a link to the Usermap PIN in the user profile of a user, if enabled. Not displayed to guests";

$l['setting_usermap_postbit'] = "Link to usermap pin in postbit";
$l['setting_usermap_postbit_desc'] = "Shows a link to the Usermap PIN in the postbit of a user, if enabled. Not displayed to guests";

$l['setting_usermap_count_pins'] = "Show how many users have set a PIN in the usermap";
$l['setting_usermap_count_pins_desc'] = "Displayed in the usermap if at least one user PIN exists. Not displayed to guests";

$l['setting_usermap_elevation'] = "Height of the user's residence";
$l['setting_usermap_elevation_desc'] = "Displayed below the avatar in the usermap if enabled. Not available for the so-called <i>additional places</i> (see below)";

$l['setting_usermap_elevation_unit'] = "Unit of altitude";
$l['setting_usermap_elevation_unit_desc'] = "choose between 'meter' and 'feet'";

$l['setting_usermap_add_places_yesno'] = "Would you like to add so-called \"additional places/places\" of special interest to the usermap?";
$l['setting_usermap_add_places_yesno_desc'] = "If desired, you can enter them in the following text field";

$l['setting_usermap_add_places'] = "Add additional places of special interest to your usermap";
$l['setting_usermap_add_places_desc'] = "Add the places/places as explained below and use a new line for each place (see examples in the text field).<br />
<br />
Please make sure to use only the following format: <strong>[name of location, latitude value, longitude value, z-index]</strong><br />
<ul><li><strong>Name of place:</strong> String. You can use HTML, CSS, URLs and img-tags (see examples below)</li>
<li><strong>Latitude-value:</strong> float number (as reported by Goolge usermaps)</li>
<li><strong>Longitude-value:</strong> float number (as reported by Goolge usermaps)</li>
<li><strong>z-index:</strong> Integer number (z-index is required if you have PINs that are very close together on the usermap). The z-index then indicates the depth order of the PINs.)</li>
<li>If you want to display the altitude of the location(s) / place, you have to find it yourself and add the value at <strong>name of the location/place</strong>.</li></ul>";
$l['setting_usermap_add_places_guests'] = "Show the so-called \"additional places/places\" also to the guests?";
$l['setting_usermap_add_places_guests_desc'] = "If not, guests can't see the additional places/places.";

$l['setting_usermap_add_places_icon'] = "Would you like to use the Google usermaps Info icon as PIN for the additional places?";
$l['setting_usermap_add_places_icon_desc'] = "If not, you can use your own PIN image for these places below";

$l['setting_usermap_add_places_icon_own'] = "Here you can enter the filename of your own PIN image for the additional places";
$l['setting_usermap_add_places_icon_own_desc'] = "Enter the name of the image in the following line. The PNG-File must be available in the directory: \"./images/pinimgs/\".";
?>