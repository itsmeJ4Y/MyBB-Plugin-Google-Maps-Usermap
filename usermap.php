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

//Define MyBB and includes
define("IN_MYBB", 1);

$templatelist = "usermap,usermap_form,usermap_pin,usermap_pinimgs,";
$templatelist .= "usermap_pinimgs_bit,usermap_pinimgs_java,";
$templatelist .= "usermap_pinimgs_java_bit,usermap_pinimgs_swapimg,";
$templatelist .= "usermap_pins,usermap_pins_bit,";
$templatelist .= "usermap_places_bit,usermap_places_java,";
$templatelist .= "usermap_places_java_bit, error_inline,";
$templatelist .= "usermap_pins_bit_user, usermap_search_user_form, usermap_pins_bit_user";

require_once "./global.php";

//Plugin
$plugins->run_hooks("username_start");

//Navigation
add_breadcrumb($lang->usermap, "usermap.php");

//Control permission
if($mybb->usergroup['canviewusermap'] != "1")
{
	error_no_permission();
}

if($mybb->settings['bblanguage'] == "deutsch_du" || $mybb->settings['bblanguage'] == "deutsch_sie")
{
  $language = "de";
}
else
{
  $language = "us";
}

if($mybb->settings['usermap_add_places_icon'] == 1)
{
  $iBase = "'https://maps.google.com/mapfiles/kml/shapes/'";
  $pinImage = "'info-i_maps.png'";
}
else
{
  $iBase = "'images/pinimgs/'";
  $pinImage = "'".htmlspecialchars_uni($mybb->settings['usermap_add_places_icon_own'])."'";
}

if($mybb->settings['usermap_count_pins'] == 1 && $mybb->user['uid'] != 0){
	$query = $db->simple_select("users", "uid", "usermap_lat!='0' AND usermap_lon!='0'");
	$count = $db->num_rows($query);
	$count_pins = "<tr><td>{$lang->number_of_pins}{$count}</td></tr>";
}

if($mybb->settings['usermap_add_places_yesno'] == 1)
{
  if(($mybb->settings['usermap_add_places'] != "" && $mybb->settings['usermap_add_places_guests'] == 1) || ($mybb->settings['usermap_add_places'] != "" && $mybb->settings['usermap_add_places_guests'] == 0 && $mybb->user['uid'] != 0))
  {
    //Thank you waldo for assisting on this code snippet
    $my_add_places = '';
    $my_add_places = '"'.$mybb->settings['usermap_add_places'].'"';
    $my_add_places = str_replace(array("\r","\n","\t"), "", $my_add_places);
    $my_add_places = '['.$my_add_places.']';
    $my_add_places = str_replace(array('][','"[',']"','\['), array('],[','[',']','['), $my_add_places);
    $my_add_places = str_replace(array('\]', '\"]'), ']', $my_add_places);
  }
  else
  {
    $my_add_places = "[]";
  }
}
else
{
  $my_add_places = "[]";
}

switch($mybb->input['action'])
{
	default:
		/***********************************
		 *   Defaults
		 ***********************************/
		$defaults = $cache->read("usermap");

		/***********************************
		 *   Places
		 ***********************************/
		//Selected
		$selected_place[$defaults['place']] = " selected=\"selected\"";

		//Loading
		$query2 = $db->query("SELECT * FROM ".TABLE_PREFIX."usermap_places ORDER BY displayorder ASC");
		while($places = $db->fetch_array($query2))
		{
			if($places['pid'] == $defaults['place'])
			{
				$default_place = array(
					"lat"		=> $places['lat'],
					"lon"		=> $places['lon'],
					"zoom"		=> $places['zoom']
				);
			}

			eval("\$usermap_places_bit .= \"".$templates->get("usermap_places_bit")."\";");
			eval("\$usermap_places_java_bit .= \"".$templates->get("usermap_places_java_bit")."\";");
		}

		//Java
		eval("\$usermap_places_java = \"".$templates->get("usermap_places_java")."\";");

		/***********************************
		 *   Pinimages
		 ***********************************/
		$pinimgs = $cache->read("usermap_pinimgs");

		//Default pin
		$file = explode(".", $pinimgs[$defaults['pinimg']]['file']);
		$default_pinimg = $pinimgs[$defaults['pinimg']];
		$default_pinimg['pin'] = $file[0];

		//Selected
		$selected_pinimg[$default_pinimg['file']] = " selected=\"selected\"";

		foreach($pinimgs as $pid => $pinimg)
		{
			$file = explode(".", $pinimg['file']);

			eval("\$usermap_pinimgs_bit .= \"".$templates->get("usermap_pinimgs_bit")."\";");
			eval("\$usermap_pinimgs_java_bit .= \"".$templates->get("usermap_pinimgs_java_bit")."\";");
		}

		//Java
		eval("\$usermap_pinimgs_swapimg = \"".$templates->get("usermap_pinimgs_swapimg")."\";");
		eval("\$usermap_pinimgs_java = \"".$templates->get("usermap_pinimgs_java")."\";");

		/***********************************
		 *   Load locations of users, the pins
		 ***********************************/
		$count = 0;

		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE usermap_lat!='0' AND usermap_lon!='0'");
		while($users = $db->fetch_array($query))
		{
			//Pinimg
			if(empty($users['usermap_pinimg']))
			{
				$users['usermap_pinimg'] = $default_pinimg['file'];
			}

			$file = explode(".", $users['usermap_pinimg']);
			$users['usermap_pinimg'] = $file[0];

			//Username
			$username = build_profile_link(format_name($users['username'], $users['usergroup'], $users['displaygroup']), $users['uid']);

      if($mybb->settings['usermap_elevation'] == 1)
      {
        get_elevation($users);
      }
 
			//Avatar
			if(!empty($users['avatar']))
			{
				$avatar = "<br /><img src=\"".$users['avatar']."\" alt=\"\" />";
			}
			else
			{
				$avatar = "";
			}

			//Plugin
			$plugins->run_hooks("username_default_while");

			eval("\$usermap_pins_bit_user = \"".$templates->get("usermap_pins_bit_user", 1, 0)."\";");
			$usermap_pins_bit_user = str_replace("\"", "'", $usermap_pins_bit_user);
			$usermap_pins_bit_user = str_replace("\n", "", $usermap_pins_bit_user);

			if(!is_array($userpins[$users['usermap_lat'].", ".$users['usermap_lon']]))
			{
				$userpins[$users['usermap_lat'].", ".$users['usermap_lon']]['pinimg'] = $users['usermap_pinimg'];
				$userpins[$users['usermap_lat'].", ".$users['usermap_lon']]['window'] = $usermap_pins_bit_user;
			}
			else
			{
				$userpins[$users['usermap_lat'].", ".$users['usermap_lon']]['pinimg'] = $default_pinimg['pin'];
				$userpins[$users['usermap_lat'].", ".$users['usermap_lon']]['window'] .= "<br /><br />".$usermap_pins_bit_user;
			}
		}

		if(is_array($userpins))
		{
			foreach($userpins as $coordinates => $userpin)
			{
				$count++;
				eval("\$usermap_pins_bit .= \"".$templates->get("usermap_pins_bit")."\";");
			}
		}

		eval("\$usermap_pins = \"".$templates->get("usermap_pins")."\";");


		//Form if logged in
		if($mybb->user['uid'] != 0 && $mybb->usergroup['canaddusermappin'] == 1)
		{
			eval("\$usermap_form = \"".$templates->get("usermap_form")."\";");
      eval("\$search_user_form = \"".$templates->get("usermap_search_user_form")."\";");
		}

		eval("\$usermap = \"".$templates->get("usermap")."\";");
		output_page($usermap);
	break;

	case 'lookup':
		require_once MYBB_ROOT."inc/class_xml.php";

		//Guests
		if($mybb->user['uid'] == 0 || $mybb->usergroup['canaddusermappin'] == 0)
		{
			error_no_permission();
		}

		if(!isset($mybb->input['adress']) || !isset($mybb->input['pinimg']))
		{
			error($lang->noinput, $lang->error);
		}
		else
		{
			//Load the xml-file of Google for the given place
			$lookup_file = file_get_contents("https://maps.googleapis.com/maps/api/geocode/xml?key=".$mybb->settings['usermap_apikeytwo']."&address=".urlencode($mybb->input['adress']).""); 

			//Parse the xml-file
			$parser = new XMLParser($lookup_file);
			$lookup = $parser->get_tree();

			// TODO: https://developers.google.com/maps/documentation/geocoding/?hl=nl#StatusCodes
			// So, some other errors might be usefull
			if($lookup['GeocodeResponse']['status']['value'] != "OK")
			{
				error($lang->coordinatesnotfound, $lang->error);
			}
			else
			{
				//Load response
				if(!isset($lookup['GeocodeResponse']['result']['geometry']['location']))
				{
					$response = $lookup['GeocodeResponse']['result'][0]['geometry']['location'];
				}
				else
				{
					$response = $lookup['GeocodeResponse']['result']['geometry']['location'];
				}

				redirect("usermap.php?action=pin&amp;lat=".$response['lat']['value']."&amp;lon=".$response['lng']['value']."&amp;pinimg=".$mybb->input['pinimg']."&amp;adress=".$mybb->input['adress'], $lang->coordinatesfound);
			}
		}
	break;
  
	case 'pin':
		//Guests
		if($mybb->user['uid'] == 0 || $mybb->usergroup['canaddusermappin'] == 0)
		{
			error_no_permission();
		}

		if(!floatval($mybb->input['lat']) || !floatval($mybb->input['lon']) || !isset($mybb->input['pinimg']) || !isset($mybb->input['adress']))
		{
			error($lang->noinput, $lang->error);
		}
		else
		{
			/***********************************
			 *   Defaults
			 ***********************************/
			$defaults = $cache->read("usermap");

			/***********************************
			 *   Pinimages
			 ***********************************/
			$pinimgs = $cache->read("usermap_pinimgs");

			//Default pin
			$default_pinimg = $pinimgs[$defaults['pinimg']];

			//Selected
			$selected_pinimg[$mybb->input['pinimg']] = " selected=\"selected\"";

			foreach($pinimgs as $pid => $pinimg)
			{
				$file = explode(".", $pinimg['file']);

				eval("\$usermap_pinimgs_bit .= \"".$templates->get("usermap_pinimgs_bit")."\";");
				eval("\$usermap_pinimgs_java_bit .= \"".$templates->get("usermap_pinimgs_java_bit")."\";");
			}

			//Java
			eval("\$usermap_pinimgs_swapimg = \"".$templates->get("usermap_pinimgs_swapimg")."\";");
			eval("\$usermap_pinimgs_java = \"".$templates->get("usermap_pinimgs_java")."\";");

			/***********************************
			 *   Pin
			 ***********************************/
			//Pinimg
			$file = explode(".", $mybb->input['pinimg']);
			$userpin['pinimg'] = $file[0];

			//Username
			$username = build_profile_link(format_name($mybb->user['username'], $mybb->user['usergroup'], $mybb->user['displaygroup']), $mybb->user['uid']);

			//Avatar
			if(!empty($mybb->user['avatar']))
			{
				$avatar = "<br /><img src=\"".$mybb->user['avatar']."\" alt=\"\" />";
			}

			//Vars
			$users['usermap_lat'] = floatval($mybb->input['lat']);
			$users['usermap_lon'] = floatval($mybb->input['lon']);
			$coordinates = $users['usermap_lat'].", ".$users['usermap_lon'];

			//Templates
			eval("\$userpin['window'] = \"".$templates->get("usermap_pins_bit_user", 1, 0)."\";");
			$userpin['window'] = str_replace("\"", "'", $userpin['window']);
			$userpin['window'] = str_replace("\n", "", $userpin['window']);
			eval("\$usermap_pins_bit .= \"".$templates->get("usermap_pins_bit")."\";");
			eval("\$usermap_pins = \"".$templates->get("usermap_pins")."\";");

			eval("\$usermap = \"".$templates->get("usermap_pin")."\";");
			output_page($usermap);
		}
	break;
  
	case 'do_pin':
		//Guests
		if($mybb->user['uid'] == 0 || $mybb->usergroup['canaddusermappin'] == 0)
		{
			error_no_permission();
		}

		if(!floatval($mybb->input['lat']) || !floatval($mybb->input['lon']) || !isset($mybb->input['pinimg']) || !isset($mybb->input['adress']))
		{
			error($lang->noinput, $lang->error);
		}
		else
		{
		//Google-Request bzgl. Elevation und in Datenbank schreiben
		$lookup_file = file_get_contents("https://maps.googleapis.com/maps/api/elevation/json?locations=".$mybb->input['lat'].",".$mybb->input['lon']."&key=".$mybb->settings['usermap_apikeythree']."");
		$lookup_file = json_decode($lookup_file, true);

		$user_elevation = $lookup_file['results'][0]['elevation'];

			$pin = array(
				'usermap_lat'		=> floatval($mybb->input['lat']),
				'usermap_lon'		=> floatval($mybb->input['lon']),
				'usermap_elevation'	=> floatval($user_elevation),
				'usermap_pinimg'	=> addslashes($mybb->input['pinimg']),
				'usermap_adress'	=> addslashes($mybb->input['adress'])
			);

			$plugins->run_hooks("usermap_do_pin");

			$db->update_query("users", $pin, "uid='".$mybb->user['uid']."'");

			redirect("usermap.php", $lang->pinsaved);
		}
	break;
  
  case 'delete':

		if($mybb->user['uid'] == 0 || $mybb->usergroup['canaddusermappin'] == 0)
		{
			error_no_permission();
		}

			$pin = array(
				'usermap_lat'		=> 0,
				'usermap_lon'		=> 0,
				'usermap_elevation'	=> 0,
				'usermap_pinimg'	=> '',
				'usermap_adress'	=> ''
			);

		$db->update_query("users", $pin, "uid='".$mybb->user['uid']."'");
     
    redirect("usermap.php", $lang->pin_deleted);
      
  case 'search':

  /***********************************
   *	    Defaults
   ************************************/
	$defaults = $cache->read("usermap");

	/***********************************
	 *   Places
	 ***********************************/
	//Selected
	$selected_place[$defaults['place']] = " selected=\"selected\"";

	//Loading
	$username = $db->escape_string(my_strtolower($mybb->get_input('username')));
	$check_input = $db->simple_select("users","uid", "username = '".$username."'");
	$check_input = $db->fetch_array($check_input);
	if(!$check_input['uid'] || $check_input['uid'] == 0){
        error($lang->error_no_user);
		exit();
	}

	$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE username = '".$username."' AND usermap_lat!='0' AND usermap_lon!='0'");
	$users = $db->fetch_array($query);

	$query2 = $db->query("SELECT * FROM ".TABLE_PREFIX."usermap_places ORDER BY displayorder ASC");

	while($places = $db->fetch_array($query2))
	{
		if($places['pid'] == $defaults['place'])
		{
			$default_place = array(
				"lat"		=> $users['usermap_lat'],
				"lon"		=> $users['usermap_lon'],
				"zoom"		=> "12"
			);
		}

		eval("\$usermap_places_bit .= \"".$templates->get("usermap_places_bit")."\";");
		eval("\$usermap_places_java_bit .= \"".$templates->get("usermap_places_java_bit")."\";");
	}

	//Java
	eval("\$usermap_places_java = \"".$templates->get("usermap_places_java")."\";");

	/***********************************
	 *   Pinimages
	 ***********************************/
	$pinimgs = $cache->read("usermap_pinimgs");

	//Default pin
	$file = explode(".", $pinimgs[$defaults['pinimg']]['file']);
	$default_pinimg = $pinimgs[$defaults['pinimg']];
	$default_pinimg['pin'] = $file[0];

	//Selected
	$selected_pinimg[$default_pinimg['file']] = " selected=\"selected\"";

	foreach($pinimgs as $pid => $pinimg)
	{
		$file = explode(".", $pinimg['file']);

		eval("\$usermap_pinimgs_bit .= \"".$templates->get("usermap_pinimgs_bit")."\";");
		eval("\$usermap_pinimgs_java_bit .= \"".$templates->get("usermap_pinimgs_java_bit")."\";");
	}

	//Java
	eval("\$usermap_pinimgs_swapimg = \"".$templates->get("usermap_pinimgs_swapimg")."\";");
	eval("\$usermap_pinimgs_java = \"".$templates->get("usermap_pinimgs_java")."\";");

   	if($users['usermap_lat'] != "" && $users['usermap_lon'] != "")
	  {
		//Pinimg
  		if(empty($users['usermap_pinimg']))
  		{
  			$users['usermap_pinimg'] = $default_pinimg['file'];
  		}

  		$file = explode(".", $users['usermap_pinimg']);
  		$users['usermap_pinimg'] = $file[0];

  		//Username
  		$username = build_profile_link(format_name($users['username'], $users['usergroup'], $users['displaygroup']), $users['uid']);

      if($mybb->settings['usermap_elevation'] == 1)
      {
        get_elevation($users);
      }
      
  		//Avatar
  		if(!empty($users['avatar']))
  		{
  			$avatar = "<br /><img src=\"".$users['avatar']."\" alt=\"\" />";
  		}
  		else
  		{
  			$avatar = "";
  		}

  		//Plugin
  		$plugins->run_hooks("username_default_while");

  		eval("\$usermap_pins_bit_user = \"".$templates->get("usermap_pins_bit_user", 1, 0)."\";");
  		$usermap_pins_bit_user = str_replace("\"", "'", $usermap_pins_bit_user);
  		$usermap_pins_bit_user = str_replace("\n", "", $usermap_pins_bit_user);

  		if(!is_array($userpins[$users['usermap_lat'].", ".$users['usermap_lon']]))
  		{
  			$userpins[$users['usermap_lat'].", ".$users['usermap_lon']]['pinimg'] = $users['usermap_pinimg'];
  			$userpins[$users['usermap_lat'].", ".$users['usermap_lon']]['window'] = $usermap_pins_bit_user;
  		}
  		else
  		{
  			$userpins[$users['usermap_lat'].", ".$users['usermap_lon']]['pinimg'] = $default_pinimg['pin'];
  			$userpins[$users['usermap_lat'].", ".$users['usermap_lon']]['window'] .= "<br /><br />".$usermap_pins_bit_user;
  		}

    	if(is_array($userpins))
    	{
    		foreach($userpins as $coordinates => $userpin)
    		{
    			$count++;
    			eval("\$usermap_pins_bit .= \"".$templates->get("usermap_pins_bit")."\";");
    		}
    	}

		eval("\$usermap_pins = \"".$templates->get("usermap_pins")."\";");

  		//Form if logged in
  		if($mybb->user['uid'] != 0 && $mybb->usergroup['canaddusermappin'] == 1)
  		{
  			eval("\$usermap_form = \"".$templates->get("usermap_form")."\";");
            eval("\$search_user_form = \"".$templates->get("usermap_search_user_form")."\";");
  		}

	  		eval("\$usermap = \"".$templates->get("usermap")."\";");
	  		output_page($usermap);
	    }
	    else
	    {
          error($lang->error_user_no_pin);
	    }
  break;
}

  
/*********************
 * Höhenwerte ermitteln ohne ständige Anfrage an Google
 **/
function get_elevation($users)
{
  global $mybb, $lang, $elevation, $users;
  
  require_once "./global.php";
  
  if($mybb->settings['usermap_elevation_unit'] == 0)
  {
    $unit = " m";
    $factor = 1;
  }
  else
  {
    $unit = " ft.";
    $factor = "3";
  }
	
  // wenn Datenbank-Feld leer...
  if($users['usermap_elevation'] == '0' || empty($users['usermap_elevation']))
	{
		$elevation = "<br />".$lang->elevation."n/a";
	}
	else
	{
		// wenn Datenbankfeld gefuellt ...
		if($users['usermap_elevation'] > 0 && !empty($users['usermap_elevation']))
		{
			$elevation = "<br /> ".$lang->elevation."~".round($users['usermap_elevation']) * $factor.$unit;
		}
  }
  return $elevation;
}
?>