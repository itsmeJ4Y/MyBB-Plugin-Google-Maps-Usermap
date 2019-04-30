<?php
/***************************************************************************
 *
 *   Usermap-system for MyBB
 *   Copyright: © 2008-2013 Online - Urbanus / Website: http://www.Online-Urbanus.be
 *
 *   Copyright: © 2016 Jockl
 *   http://forum.mybboard.de/user-2693.html
 *
 *   Copyright: © 2019 itsmeJAY
 *   https://www.mybb.de/forum/user-10220.html
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
 /**
  * changelog 1.4.3
  * ACP settings translated and changed for using language files
  * 
  * changelog 1.4.2
  * changed mysql structure due to strict-mode issues
  * see https://www.mybb.de/erweiterungen/18x/plugins-neueseiten/usermap2/
 */

if(!defined("IN_MYBB"))
{
	die("This file cannot be accessed directly.");
}

$plugins->add_hook("global_start", "usermap_global");
$plugins->add_hook("member_profile_start", "usermap_member_profile");
$plugins->add_hook("postbit", "usermap_postbit");
$plugins->add_hook("fetch_wol_activity_end", "usermap_online_activity");
$plugins->add_hook("build_friendly_wol_location_end", "usermap_online_location");
$plugins->add_hook("admin_config_menu", "usermap_admin_config_menu");
$plugins->add_hook("admin_config_action_handler", "usermap_admin_config_action_handler");
$plugins->add_hook("admin_config_settings_change","usermap_settings_change");
$plugins->add_hook("admin_settings_print_peekers","usermap_settings_footer");
$plugins->add_hook("admin_config_permissions", "usermap_admin_config_permissions");
$plugins->add_hook("admin_user_groups_edit", "usermap_admin_user_groups_edit");
$plugins->add_hook("admin_user_groups_edit_commit", "usermap_admin_user_groups_edit_commit");
$plugins->add_hook("admin_tools_adminlog_start", "usermap_tools_adminlog");
$plugins->add_hook("admin_formcontainer_output_row", "usermap_delpin_users");
$plugins->add_hook("admin_user_users_edit_commit", "usermap_delpin_commit");
$plugins->add_hook("admin_config_plugins_begin", "usermap_tools_adminlog");

function usermap_info()
{
    global $lang, $db;
    
    $lang->load("config_usermap");
    
	return array(
		"name"			=> "Usermap",
		"description"	=> $lang->usermap_plugin_desc,
		"website"		=> $lang->usermap_plugin_link,
		"author"		=> "Paretje",
		"authorsite"	=> "http://www.Online-Urbanus.be",
		"version"		=> "1.5.0",
		"guid"			=> "",
		"compatibility" => "18*"
	);
}

function usermap_install()
{
	global $cache, $db, $lang;
    
    //$lang->load("config_usermap");

	//Insert Usermap tables and set DEFAULT value
	$db->write_query("CREATE TABLE `".TABLE_PREFIX."usermap_places` (
	`pid` INT(5) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(120) NOT NULL DEFAULT '',
	`lat` FLOAT NOT NULL DEFAULT '0.00',
	`lon` FLOAT NOT NULL DEFAULT '0.00',
	`zoom` INT(2) NOT NULL,
	`displayorder` INT(5) NOT NULL,
	PRIMARY KEY (`pid`)
	) ENGINE=MyISAM".$db->build_create_table_collation().";");
	
	//Insert
	$place1 = array(
		"name"		=> "World",
		"lat"		=> "31.353637",
		"lon"		=> "-1.054687",
		"zoom"		=> "2",
		"displayorder"	=> "1"
	);
	$place2 = array(
		"name"		=> "Europe",
		"lat"		=> "49.439557",
		"lon"		=> "11.513672",
		"zoom"		=> "4",
		"displayorder"	=> "2"
	);
	$place3 = array(
		"name"		=> "USA",
		"lat"		=> "37.0625",
		"lon"		=> "-95.677068",
		"zoom"		=> "4",
		"displayorder"	=> "3"
	);
	
	$db->insert_query("usermap_places", $place1);
	$db->insert_query("usermap_places", $place2);
	$db->insert_query("usermap_places", $place3);
	
	//Insert datacache information
	//Pinimgs
	$pinimgs[] = array(
		"name"		=> "Default",
		"file"		=> "pin.png"
	);
	
	$cache->update("usermap_pinimgs", $pinimgs);
	
	//Default "settings"
	$defaults = array(
		"place"		=> "2",
		"pinimg"	=> "0"
	);
	
	$cache->update("usermap", $defaults);
    	
	//Settings
	$setting_group = array(
		"name"			=> "usermap",
		"title"			=> $db->escape_string($lang->setting_group_usermap),
		"description"	=> $db->escape_string($lang->setting_group_usermap_desc),
		"disporder"		=> "100",
		"isdefault"		=> "0"
	);
	$gid = $db->insert_query("settinggroups", $setting_group);
	
	$setting = array(
		"name"			=> "usermap_apikey",
		"title"			=> $db->escape_string($lang->setting_usermap_apikey),
		"description"	=> $db->escape_string($lang->setting_usermap_apikey_desc),
		"optionscode"	=> "text",
		"value"			=> "",
		"disporder"		=> "1",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
  
  	$setting = array(
		"name"			=> "usermap_apikeytwo",
		"title"			=> $db->escape_string($lang->setting_usermap_apikeytwo),
		"description"	=> $db->escape_string($lang->setting_usermap_apikeytwo_desc),
		"optionscode"	=> "text",
		"value"			=> "",
		"disporder"		=> "2",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
	
	$setting = array(
		"name"			=> "usermap_apikeythree",
		"title"			=> $db->escape_string($lang->setting_usermap_apikeythree),
		"description"	=> $db->escape_string($lang->setting_usermap_apikeythree_desc),
		"optionscode"	=> "text",
		"value"			=> "",
		"disporder"		=> "3",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
  
  
	$setting = array(
		"name"			=> "usermap_width",
		"title"			=> $db->escape_string($lang->setting_usermap_width),
		"description"	=> $db->escape_string($lang->setting_usermap_width_desc),
		"optionscode"	=> "text",
		"value"			=> "750",
		"disporder"		=> "4",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
  
	$setting = array(
		"name"			=> "usermap_height",
		"title"			=> $db->escape_string($lang->setting_usermap_height),
		"description"	=> $db->escape_string($lang->setting_usermap_height_desc),
		"optionscode"	=> "text",
		"value"			=> "450",
		"disporder"		=> "5",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
  
	$setting = array(
		"name"			=> "usermap_profile",
		"title"			=> $db->escape_string($lang->setting_usermap_profile),
		"description"	=> $db->escape_string($lang->setting_usermap_profile_desc),
		"optionscode"	=> "yesno",
		"value"			=> "0",
		"disporder"		=> "6",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
  
	$setting = array(
		"name"			=> "usermap_postbit",
		"title"			=> $db->escape_string($lang->setting_usermap_postbit),
		"description"	=> $db->escape_string($lang->setting_usermap_postbit_desc),
		"optionscode"	=> "yesno",
		"value"			=> "0",
		"disporder"		=> "7",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
  
	$setting = array(
		"name"			=> "usermap_count_pins",
		"title"			=> $db->escape_string($lang->setting_usermap_count_pins),
		"description"	=> $db->escape_string($lang->setting_usermap_count_pins_desc),
		"optionscode"	=> "yesno",
		"value"			=> "0",
		"disporder"		=> "8",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
  
	$setting = array(
		"name"			=> "usermap_elevation",
		"title"			=> $db->escape_string($lang->setting_usermap_elevation),
		"description"	=> $db->escape_string($lang->setting_usermap_elevation_desc),
		"optionscode"	=> "yesno",
		"value"			=> "0",
		"disporder"		=> "9",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
    
	$setting = array(
		"name"			=> "usermap_elevation_unit",
		"title"			=> $db->escape_string($lang->setting_usermap_elevation_unit),
		"description"	=> $db->escape_string($lang->setting_usermap_elevation_unit_desc),
		"optionscode"	=> "select\n0=Meter\n1=Feet",
		"value"			=> "0",
		"disporder"		=> "10",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);

	$setting = array(
		"name"			=> "usermap_add_places_yesno",
		"title"			=> $db->escape_string($lang->setting_usermap_add_places_yesno),
		"description"	=> $db->escape_string($lang->setting_usermap_add_places_yesno_desc),
		"optionscode"	=> "yesno",
		"value"			=> "0",
		"disporder"		=> "11",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
    
	$setting = array(                                                                                                    
		"name"			=> "usermap_add_places",
		"title"			=> $db->escape_string($lang->setting_usermap_add_places),
		"description"	=> $db->escape_string($lang->setting_usermap_add_places_desc),
		"optionscode"	=> "textarea",
		"value"			=> $db->escape_string("['Zugspitze',47.420957, 10.985354,1]\n['<p><strong>Frankfurt a. Main</strong><br />Römer</p>', 50.110557, 8.681608, 2]\n['<div style=\"margin-top:20px;\"><img src=\"https://www.mybb.de/files/images/banner.png\" title=\"\"/><br /><span style=\"font-size:1.5em;font-weight:bold;\">Heimat von MyBB.de</span></div>', 49.006145, 8.398254, 3]"),
		"disporder"		=> "12",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);

	$setting = array(
		"name"			=> "usermap_add_places_guests",
		"title"			=> $db->escape_string($lang->setting_usermap_add_places_guests),
		"description"	=> $db->escape_string($lang->setting_usermap_add_places_guests_desc),
		"optionscode"	=> "yesno",
		"value"			=> "0",
		"disporder"		=> "13",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);

	$setting = array(
		"name"			=> "usermap_add_places_icon",
		"title"			=> $db->escape_string($lang->setting_usermap_add_places_icon),
		"description"	=> $db->escape_string($lang->setting_usermap_add_places_icon_desc),
		"optionscode"	=> "yesno",
		"value"			=> "1",
		"disporder"		=> "14",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);

	$setting = array(
		"name"			=> "usermap_add_places_icon_own",
		"title"			=> $db->escape_string($lang->setting_usermap_add_places_icon_own),
		"description"	=> $db->escape_string($lang->setting_usermap_add_places_icon_own_desc),
		"optionscode"	=> "text",
		"value"			=> "pin.png",
		"disporder"		=> "15",
		"gid"			=> intval($gid)
	);
  $db->insert_query("settings", $setting);
      	
	rebuild_settings();
	
	//Mybb-tables
	$db->write_query("ALTER TABLE `".TABLE_PREFIX."usergroups` ADD `canviewusermap` INT(1) NOT NULL DEFAULT '1',
	ADD `canaddusermappin` INT(1) NOT NULL DEFAULT '1';");
	
	$db->write_query("ALTER TABLE `".TABLE_PREFIX."users` ADD `usermap_lat` FLOAT NOT NULL DEFAULT '0.00',
	ADD `usermap_lon` FLOAT NOT NULL DEFAULT '0.00',
	ADD `usermap_elevation` FLOAT NOT NULL DEFAULT '0.00',
	ADD `usermap_pinimg` VARCHAR(255) NOT NULL DEFAULT '',
	ADD `usermap_adress` VARCHAR(255) NOT NULL DEFAULT '';");
	
	$db->write_query("UPDATE ".TABLE_PREFIX."usergroups SET canviewusermap='0', canaddusermappin='0' WHERE gid='7'");
	
	//Update usergroupschache
	$cache->update_usergroups();
	
	//Update adminpermissions
	change_admin_permission("config", "usermap", 1);
	
	//Templates
	$templates['usermap'] = "<html>
<head>
<title>{\$mybb->settings['bbname']} - {\$lang->usermap}</title>
{\$headerinclude}
<script type=\"text/javascript\" src=\"https://maps.googleapis.com/maps/api/js?key={\$mybb->settings['usermap_apikey']}&amp;language={\$language}\"></script>
<script type=\"text/javascript\">
<!--
var map = true;
var zoom = {\$default_place['zoom']};
var lat = {\$default_place['lat']};
var lon = {\$default_place['lon']};
var myaddplaces = {\$my_add_places};
var iBase = {\$iBase};
var pImg = {\$pinImage};
// -->
</script>
<script type=\"text/javascript\" src=\"{\$mybb->asset_url}/jscripts/usermap.js\"></script>
{\$usermap_pinimgs_swapimg}
{\$usermap_pinimgs_java}
{\$usermap_pins}
{\$usermap_places_java}
</head>
<body onload=\"initialize(lat,lon,zoom,myaddplaces,iBase,pImg)\">
{\$header}
<table border=\"0\" cellspacing=\"{\$theme['borderwidth']}\" cellpadding=\"{\$theme['tablespace']}\" class=\"tborder\">
<tr>
<td colspan=\"2\" class=\"thead\"><strong>{\$lang->usermap}</strong></td>
</tr>
{\$usermap_form}
<tr>
<td class=\"trow2\">
<strong>{\$lang->place}</strong>
</td>
<td class=\"trow2\">
<select name=\"place\" id=\"place\" onchange=\"moveMap(this.value)\">
{\$usermap_places_bit}
</select>
</td>
</tr>
{\$search_user_form}
<tr>
<td colspan=\"2\" class=\"trow1\">
<center><div id=\"map\" style=\"width: {\$mybb->settings['usermap_width']}px; height: {\$mybb->settings['usermap_height']}px\"></div></center>
</td>
</tr>
{\$count_pins}
</table>
{\$footer}
<link rel=\"stylesheet\" href=\"{\$mybb->asset_url}/jscripts/select2/select2.css\" />
<script type=\"text/javascript\" src=\"{\$mybb->asset_url}/jscripts/select2/select2.min.js\"></script>
<script type=\"text/javascript\">
<!--
if(use_xmlhttprequest == \"1\")
{
	MyBB.select2();
	$(\"#username\").select2({
		placeholder: \"{\$lang->search_user}\",
		minimumInputLength: 3,
		maximumSelectionSize: 3,
		multiple: false,
		ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			url: \"xmlhttp.php?action=get_users\",
			dataType: 'json',
			data: function (term, page) {
				return {
					query: term, // search term
				};
			},
			results: function (data, page) { // parse the results into the format expected by Select2.
				// since we are using custom formatting functions we do not need to alter remote JSON data
				return {results: data};
			}
		},
		initSelection: function(element, callback) {
			var value = $(element).val();
			if (value !== \"\") {
				callback({
					id: value,
					text: value
				});
			}
		},
       // Allow the user entered text to be selected as well
       createSearchChoice:function(term, data) {
			if ( $(data).filter( function() {
				return this.text.localeCompare(term)===0;
			}).length===0) {
				return {id:term, text:term};
			}
		},
	});
}
// -->
</script>
</body>
</html>";

	$templates['usermap_form'] = "<form method=\"post\" action=\"usermap.php\">
<input type=\"hidden\" name=\"action\" value=\"lookup\" />
<tr>
<td class=\"trow1\" width=\"40%\">
<strong>{\$lang->yourpin}</strong>
</td>
<td class=\"trow1\">
<input type=\"text\" class=\"textbox\" size=\"40\" maxlength=\"255\" name=\"adress\" value=\"{\$mybb->user['usermap_adress']}\" />
</td>
</tr>
<tr>
<td class=\"trow2\" width=\"40%\">
<strong>{\$lang->yourpinimg}</strong>
</td>
<td class=\"trow2\">
<select name=\"pinimg\" onchange=\"swapIMG(this.value)\">
{\$usermap_pinimgs_bit}
</select>
<img name=\"pin_image\" src=\"images/pinimgs/{\$default_pinimg['file']}\" alt=\"\" />
</td>
</tr>
<tr>
<td colspan=\"2\" class=\"trow1\">
<center><input type=\"submit\" class=\"button\" name=\"submit\" value=\"{\$lang->lookup_usermap}\" /></center>
</td>
</tr>
</form>";

	$templates['usermap_pin'] = "<html>
<head>
<title>{\$mybb->settings['bbname']} - {\$lang->usermap}</title>
{\$headerinclude}
<script type=\"text/javascript\" src=\"https://maps.googleapis.com/maps/api/js?key={\$mybb->settings['usermap_apikey']}&amp;language={\$language}\"></script>
<script type=\"text/javascript\">
var map = true;
</script>
{\$usermap_pinimgs_swapimg}
{\$usermap_pinimgs_java}
{\$usermap_pins}
{\$usermap_places_java}
<script type=\"text/javascript\">
function initialize()
{
	map = new google.maps.Map(document.getElementById(\"map\"), {
		center: new google.maps.LatLng({\$coordinates}),
		zoom: 14,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	setPins(map);
}
google.maps.event.addDomListener(window, 'load', initialize);</script>
</head>
<body>
{\$header}
<table border=\"0\" cellspacing=\"{\$theme['borderwidth']}\" cellpadding=\"{\$theme['tablespace']}\" class=\"tborder\">
<tr>
<td colspan=\"2\" class=\"thead\"><strong>{\$lang->usermap}</strong></td>
</tr>
<form method=\"post\" action=\"usermap.php\">
<input type=\"hidden\" name=\"action\" value=\"lookup\" />
<tr>
<td class=\"trow1\" width=\"40%\">
<strong>{\$lang->yourpin}</strong>
</td>
<td class=\"trow1\">
<input type=\"text\" class=\"textbox\" size=\"40\" maxlength=\"255\" name=\"adress\" value=\"{\$mybb->input['adress']}\" />
</td>
</tr>
<tr>
<td class=\"trow2\" width=\"40%\">
<strong>{\$lang->yourpinimg}</strong>
</td>
<td class=\"trow2\">
<select name=\"pinimg\" onchange=\"swapIMG(this.value)\">
{\$usermap_pinimgs_bit}
</select>
<img name=\"pin_image\" src=\"images/pinimgs/{\$mybb->input['pinimg']}\">
</td>
</tr>
<tr>
<td colspan=\"2\" class=\"trow1\">
<center><input type=\"submit\" class=\"button\" name=\"submit\" value=\"{\$lang->lookup_usermap}\"></center>
</td>
</tr>
</form>
<tr>
<td colspan=\"2\" class=\"trow2\">
<form method=\"post\" action=\"usermap.php\">
<input type=\"hidden\" name=\"action\" value=\"do_pin\" />
<input type=\"hidden\" name=\"lat\" value=\"{\$users['usermap_lat']}\" />
<input type=\"hidden\" name=\"lon\" value=\"{\$users['usermap_lon']}\" />
<input type=\"hidden\" name=\"pinimg\" value=\"{\$mybb->input['pinimg']}\" />
<input type=\"hidden\" name=\"adress\" value=\"{\$mybb->input['adress']}\" />
<center><input type=\"submit\" class=\"button\" name=\"submit\" value=\"{\$lang->ok}\"></center>
</form>
</td>
</tr>
<tr>
<td colspan=\"2\" class=\"trow1\">
<center><div id=\"map\" style=\"width: {\$mybb->settings['usermap_width']}px; height: {\$mybb->settings['usermap_height']}px\"></div></center>
</td>
</tr>
</table>
{\$footer}
</body>
</html>";

	$templates['usermap_pinimgs_bit'] = "<option value=\"{\$pinimg['file']}\"{\$selected_pinimg[\$pinimg['file']]}>{\$pinimg['name']}</option>";
	
	$templates['usermap_pinimgs_java'] = "<script type=\"text/javascript\">
//var shadow = {
//	url: \"images/pinimgs/shadow.png\",
//	size: new google.maps.Size(22, 20),
//	anchor: new google.maps.Point(6, 20)
//}
{\$usermap_pinimgs_java_bit}
</script>";
	
	$templates['usermap_pinimgs_java_bit'] = "var icon{\$file[0]} = {
	url: \"images/pinimgs/{\$pinimg['file']}\",
	size: new google.maps.Size(12, 20),
	anchor: new google.maps.Point(6, 20),
};";
	
	$templates['usermap_pinimgs_swapimg'] = "<script type=\"text/javascript\">
function swapIMG(imgname)
{
	document.images['pin_image'].src = \"images/pinimgs/\"+imgname;
}
</script>";
	
	$templates['usermap_pins'] = "<script type=\"text/javascript\">
function setPins(map)
{
	{\$usermap_pins_bit}
}
</script>";

	$templates['usermap_pins_bit'] = "	var marker{\$count} = new google.maps.Marker({
		position: new google.maps.LatLng({\$coordinates}),
		icon: icon{\$userpin['pinimg']},
		//shadow: shadow
	});
	marker{\$count}.setMap(map);
	google.maps.event.addListener(marker{\$count}, \"click\", function()
	{
		new google.maps.InfoWindow({content: \"{\$userpin['window']}\"}).open(map, marker{\$count});
	});";
	
	$templates['usermap_pins_bit_user'] = "{\$username}{\$avatar}{\$elevation}";
	
	$templates['usermap_places_bit'] = "<option value=\"{\$places['pid']}\"{\$selected_place[\$places['pid']]}>{\$places['name']}</option>";
	
	$templates['usermap_places_java'] = "<script type=\"text/javascript\">
function moveMap(country)
{
	switch(country)
	{
		{\$usermap_places_java_bit}
	}
}
</script>";

	$templates['usermap_places_java_bit'] = "		case '{\$places['pid']}':
			map.setCenter(new google.maps.LatLng({\$places['lat']}, {\$places['lon']}));
			map.setZoom({\$places['zoom']});
		break;";

	$templates['usermap_search_user_form'] = "<tr colspan=\"2\" class=\"trow1\">
<td width=\"40%\">
<strong>{\$lang->search_user}</strong>
</td>
<td>
<form method=\"post\" action=\"usermap.php\">
<input type=\"hidden\" name=\"action\" value=\"search\" />
<input type=\"text\" class=\"textbox\" name=\"username\" id=\"username\" style=\"width: 40%; margin-top: -5px;\" value=\"{\$search_username}\" />
<input type=\"submit\" class=\"button\" name=\"submit\" value=\"{\$lang->search}\" />
</form>
</td>
</tr>
<tr colspan=\"2\" class=\"trow1\">
<td width=\"40%\">
<strong>{\$lang->delete_pin}</strong>
</td>
<td>
<form method=\"post\" action=\"usermap.php\">
<input type=\"hidden\" name=\"action\" value=\"delete\" />
<input type=\"submit\" class=\"button\" name=\"submit\" value=\"{\$lang->delete_it}\" />
</form>
</td>
</tr>";
	
	// Insert the new templates into the database.
	foreach($templates as $title => $template)
	{
		$template_insert = array(
			"title"		=> $db->escape_string($title),
			"template"	=> $db->escape_string($template),
			"sid"		=> -1,
			'version'	=> $db->escape_string($mybb->version_code),
			'dateline'	=> TIME_NOW
		);
		
		$db->insert_query("templates", $template_insert);
	}
}

function usermap_uninstall()
{
	global $db, $cache;
	
	//Delete Usermap tables
	$db->write_query("DROP TABLE `".TABLE_PREFIX."usermap_places`;");
	
	//Delete datacache
	$cache->update("usermap_pinimgs", false);
	$cache->update("usermap", false);
	
	//MyBB-tables
	$db->write_query("ALTER TABLE `".TABLE_PREFIX."usergroups` DROP `canviewusermap`,
	DROP `canaddusermappin`;");
	
	$db->write_query("ALTER TABLE `".TABLE_PREFIX."users` DROP `usermap_lat`,
	DROP `usermap_lon`,
	DROP `usermap_elevation`,
	DROP `usermap_pinimg`,
	DROP `usermap_adress`;");
	
	//Update usergroupschache
	$cache->update_usergroups();
	
	//Delete MyBB settings
	$query = $db->query("SELECT * FROM ".TABLE_PREFIX."settinggroups WHERE name='usermap'");
	$setting_group = $db->fetch_array($query);
	
	$db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE gid='".$setting_group['gid']."'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE gid='".$setting_group['gid']."'");
	
	rebuild_settings();
	
	//Delete templates
	$deletetemplates = array('usermap', 'usermap_form', 'usermap_pin', 'usermap_pinimgs', 'usermap_pinimgs_bit',
  'usermap_pinimgs_java', 'usermap_pinimgs_java_bit', 'usermap_pinimgs_swapimg', 'usermap_pins',
  'usermap_pins_bit', 'usermap_pins_bit_user', 'usermap_places_bit', 'usermap_places_java', 'usermap_places_java_bit',
  'usermap_search_user_form', 'usermap_add_places_yesno', 'usermap_add_places', 'usermap_add_places_guests',
  'usermap_add_places_icon', 'usermap_add_places_icon_own');
	
	foreach($deletetemplates as $title)
	{
		$db->delete_query("templates", "title='".$title."'");
	}
}

function usermap_activate()
{
	//Update MyBB templates
	require_once MYBB_ROOT."inc/adminfunctions_templates.php";

	find_replace_templatesets("footer", "#".preg_quote("{\$lang->bottomlinks_syndication}</a></li>")."#", "{\$lang->bottomlinks_syndication}</a></li><li><a href=\"{\$mybb->settings['bburl']}/usermap.php\">{\$lang->usermap}</a></li>");
  find_replace_templatesets("member_profile", "#".preg_quote("{\$membdayage}<br />")."#", "{\$membdayage}<br />{\$pin_available}");
  find_replace_templatesets("postbit", "#".preg_quote("{\$post['user_details']}")."#", "{\$post['user_details']}{\$post['pin_available']}");
  find_replace_templatesets("postbit_classic", "#".preg_quote("{\$post['user_details']}")."#", "{\$post['user_details']}{\$post['pin_available']}");
}

function usermap_deactivate()
{
	//Revert MyBB templates
	require_once MYBB_ROOT."inc/adminfunctions_templates.php";

	find_replace_templatesets("footer", "#".preg_quote("<li><a href=\"{\$mybb->settings['bburl']}/usermap.php\">{\$lang->usermap}</a></li>")."#", "", 0);
  find_replace_templatesets("member_profile", "#".preg_quote("{\$pin_available}")."#", ""); 
  find_replace_templatesets("postbit", "#".preg_quote("{\$post['pin_available']}")."#", "");
  find_replace_templatesets("postbit_classic", "#".preg_quote("{\$post['pin_available']}")."#", "");
}

function usermap_is_installed()
{
	global $db;
	
	if($db->table_exists("usermap_places"))
	{
		return true;
	}
	
	return false;
}

function usermap_global()
{
	global $lang;
	
	$lang->load("usermap");
}
  
function usermap_member_profile()
{
	global $db, $mybb, $lang, $pin_available;

    $lang->load("usermap");

	$bgcolor = alt_trow();

	$uid = $mybb->get_input('uid', MyBB::INPUT_INT);

	$query = $db->simple_select("users", "username, usermap_lat, usermap_lon, usermap_adress", "uid = ".$uid);
	$place = $db->fetch_array($query);

	$place_username = htmlspecialchars_uni(trim($place['username']));

	if($mybb->settings['usermap_profile'] == 1 && $place['usermap_lat'] != 0 && $place['usermap_lon'] != 0 && $mybb->user['uid'] != 0)
  {
		$pin_available = "<div>
	<strong>{$lang->pin_set}</strong>
	<a href=\"usermap.php?action=search&amp;username={$place_username}\" target=\"_blank\">{$lang->pin_set_yes}</a>
</div>";
	}
}


function usermap_postbit(&$post)
{
	global $db, $mybb, $lang, $templates;

  $uid = intval($post['uid']);

	$query = $db->simple_select("users", "username, usermap_lat, usermap_lon", "uid = ".$uid);
	$place = $db->fetch_array($query);

	$place_username = htmlspecialchars_uni(trim($place['username']));

	if($mybb->settings['usermap_postbit'] == 1 && $place['usermap_lat'] != 0 && $place['usermap_lon'] != 0 && $mybb->user['uid'] != 0)
  {
    $post['pin_available'] = "<br />{$lang->pin_set}<a href=\"usermap.php?action=search&amp;username={$place_username}\" target=\"_blank\">{$lang->pin_set_yes}</a>";
	}
}


function usermap_online_activity($user_activity)
{
	//Get the filename
	$split_loc = explode(".php", $user_activity['location']);
	$filename = my_substr($split_loc[0], -my_strpos(strrev($split_loc[0]), "/"));
	
	if($user_activity['activity'] == "unknown" && $filename == "usermap")
	{
		$user_activity['activity'] = "usermap";
		
		return $user_activity;
	}
}

function usermap_online_location($plugin_array)
{
	global $lang;
	
	if($plugin_array['user_activity']['activity'] == "usermap")
	{
		$plugin_array['location_name'] = $lang->viewing_usermap;
		
		return $plugin_array;
	}
}

function usermap_admin_config_menu($sub_menu)
{
	global $lang;
	
	//Load the language files
	$lang->load("config_usermap");
	
	//Add the menu item
	$sub_menu[] = array("id" => "usermap", "title" => $lang->usermap, "link" => "index.php?module=config/usermap");
	
	return $sub_menu;
}

function usermap_admin_config_action_handler($actions)
{
	$actions['usermap'] = array('active' => 'usermap', 'file' => 'usermap.php');
	
	return $actions;
}

function usermap_admin_config_permissions($admin_permissions)
{
	global $lang;
	
	//Load the language files
	$lang->load("config_usermap");
	
	//Add the permission item
	$admin_permissions['usermap'] = $lang->can_manage_usermap;
	
	return $admin_permissions;
}

function usermap_admin_user_groups_edit()
{
	global $plugins;
	
	$plugins->add_hook("admin_formcontainer_end", "usermap_admin_user_groups_edit_graph");
}

function usermap_admin_user_groups_edit_graph()
{
	global $form_container, $lang, $form, $mybb;

	//Check if it's the misc tab generating now
	if($form_container->_title == $lang->misc)
	{
		//Load the language files
		$lang->load("config_usermap");
		
		//Add the Usermap options
		$usermap_options = array(
			$form->generate_check_box("canviewusermap", 1, $lang->can_view_usermap, array("checked" => $mybb->input['canviewusermap'])),
			$form->generate_check_box("canaddusermappin", 1, $lang->can_add_usermap_pin, array("checked" => $mybb->input['canaddusermappin']))
		);
		$form_container->output_row($lang->usermap, "", "<div class=\"group_settings_bit\">".implode("</div><div class=\"group_settings_bit\">", $usermap_options)."</div>");
	}
}

function usermap_admin_user_groups_edit_commit()
{
	global $updated_group, $mybb;
	
	$updated_group['canviewusermap'] = $mybb->input['canviewusermap'];
	$updated_group['canaddusermappin'] = $mybb->input['canaddusermappin'];
}

function usermap_tools_adminlog()
{
	global $lang;
	
	$lang->load("config_usermap");
}

function usermap_settings_change()
{
	global $db, $mybb, $usermap_settings_peeker;

	$result = $db->simple_select("settinggroups","gid","name='usermap'",array("limit"=>1));
	$group = $db->fetch_array($result);
	$usermap_settings_peeker = ($mybb->input["gid"] == $group["gid"]) && ($mybb->request_method != "post");
}

function usermap_settings_footer()
{
	global $usermap_settings_peeker;

	if($usermap_settings_peeker)
	{
		echo '<script type="text/javascript">
			$(document).ready(function() {
				loaduseramp_Peekers();
			});
  		function loaduseramp_Peekers() {
  	      new Peeker($(".setting_usermap_elevation"), $("#row_setting_usermap_elevation_unit"), /1/, true);
          new Peeker($(".setting_usermap_add_places_yesno"), $("#row_setting_usermap_add_places"), /1/, true);
          new Peeker($(".setting_usermap_add_places_yesno"), $("#row_setting_usermap_add_places_guests"), /1/, true);
          new Peeker($(".setting_usermap_add_places_yesno"), $("#row_setting_usermap_add_places_icon"), /1/, true);
          new Peeker($(".setting_usermap_add_places_icon"), $("#row_setting_usermap_add_places_icon_own"), /0/, true);                    
  		}
		</script>';
	}
}

function usermap_delpin_users($above)
{
	global $db, $mybb, $lang, $form;

	$lang->load("usermap", true);
        
	$query = $db->simple_select("users","usermap_lat,usermap_lon,usermap_pinimg,usermap_adress","uid = ".intval($mybb->input['uid'])."");
	$result = $db->fetch_array($query);
  	
	if($above['title'] == $lang->other_options && $lang->other_options)
	{
    $above['content'] .="<tr><td><label>".$lang->users_pin_stat."</label><br />";
    $above['content'] .="<div class=\"form_row\"><div class=\"user_settings_bit\">".$form->generate_check_box('usermap_pin_check', 'enable', $lang->users_pin_del, array('checked' => 0))."";
    $above['content'] .="</td></tr>";
	}
	return $above;
}

function usermap_delpin_commit()
{
	global $db, $mybb;

  if($mybb->input['usermap_pin_check'] == 'enable')
  {  	
  	$pin = array(
  		'usermap_lat'		=> 0,
  		'usermap_lon'		=> 0,
  		'usermap_pinimg'	=> '',
  		'usermap_adress'	=> ''
  	);
  
  	$db->update_query("users", $pin, "uid='".$mybb->input['uid']."'");
  }
}
?>
