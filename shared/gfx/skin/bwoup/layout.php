<?

function skin_AlternateTreeView($url_link,$text,$selected,$arbo,$entrylink,$do_rollover,$icon){
	global $addrlink;

	$level = sizeof( explode("/",$addrlink));
	$arbo_tree = explode("/",$arbo);

	$onclick = 'onClick="self.location=\''.$url_link.'\';"';

	$end_tree = "";
//	echo "Called skin_AlternateTreeView arbo: $arbo text: arbo0: ".$arbo_tree[0]." text: $text entrylink: $entrylink<br>\n"; 
	switch($arbo_tree[0]){
	default:
	case "none":
		$icone_tree = "";
		if($selected == 1){
			$class = "box_wnb_tv_leaf_select";
		}else{
			$class = "box_wnb_tv_leaf";
		}
		$mouseover_class = "box_wnb_tv_leaf-hover";
		$text = "&nbsp;$text";
		break;
	case "tree":
		$icone_tree = '<a href="'.$url_link.'"><img src="gfx/skin/bwoup/gfx/treeview/box_wnb_tv_leaf_tree-branch.gif" /></a>';
		if($selected == 1){
			$class = "box_wnb_tv_leaf_leaf_select";
		}else{
			$class = "box_wnb_tv_leaf_leaf";
		}
		$mouseover_class = "box_wnb_tv_leaf_leaf-hover";
		$text = "&nbsp;&nbsp;$text";
		break;
	case "endtree":
		$icone_tree = '<a href="'.$url_link.'"><img src="gfx/skin/bwoup/gfx/treeview/box_wnb_tv_leaf_tree-finalbranch.gif" /></a>';
		if($selected == 1){
			$class = "box_wnb_tv_leaf_leaf_select";
		}else{
			$class = "box_wnb_tv_leaf_leaf";
		}
		$end_tree = '<tr><td class="box_wnb_tv_leaf_openbottom" colspan="2"></td></tr>';
		$mouseover_class = "box_wnb_tv_leaf_leaf-hover";
		$text = "&nbsp;&nbsp;$text";
		break;
	case "plus":
		$icone_tree = '<a href="'.$url_link.'"><img src="gfx/skin/bwoup/gfx/treeview/box_wnb_tv_tree_plus.gif" /></a>';
		$class = "box_wnb_tv_leaf";
		$mouseover_class = "box_wnb_tv_leaf-hover";
		$text = "&nbsp;$text";
		break;
	case "minus":
		$icone_tree = '<a href="'.$url_link.'"><img src="gfx/skin/bwoup/gfx/treeview/box_wnb_tv_tree_minus.gif" /></a>';
		if($selected == 1){
			if($level > 1){
				$class = "box_wnb_tv_leaf_open";
			}else{
				$class = "box_wnb_tv_leaf_select";
			}
		}else{
			$class = "box_wnb_tv_open";
		}
		$mouseover_class = "box_wnb_tv_leaf-hover";
		$text = "&nbsp;$text";
		break;
	}
	
	$mouseover_stuff= "onMouseOver=\"this.className='$mouseover_class';\" onMouseOut=\"this.className='$class';\"";
	$onclick = " onClick=\"document.location='$url_link'\" ";

//	echo "Icone tree: $icone_tree<br>\n";
	$out = "
<tr>
	<td class=\"box_wnb_tv_tree\" $onclick style=\"this.style.cursor='pointer';\">".$icone_tree."</td>
	<td class=\"$class\" $mouseover_stuff $onclick style=\"this.style.cursor='pointer';\"><a href=\"".$url_link."\"><img src=\"gfx/skin/bwoup/gfx/treeview/$icon\" width=\"16\" height\"16\" border=\"0\">".$text."</a></td>
</tr>$end_tree";
	return $out;
}

function skin_AliternateTreeViewContainer($tree_view){
	return '<div class="box_wnb_tv_container">
<table class="box_wnb_tv" border="0" cellpadding="0" cellspacing="0">'.$tree_view.'</table>';
}

function skin_displayAdminList($dsc){
	global $adm_login;
	global $adm_pass;
	global $rub;

	$out = '<br><br><div class=\"box_wnb_nb_content\"><ul class="box_wnb_nb_items">';

	
	$nbr = sizeof($dsc["admins"]);
	for($i=0;$i<$nbr;$i++){
//		echo "<pre>"; print_r($dsc["admins"][$i]); echo "</pre>";
		if($dsc["admins"][$i]["adm_login"] == $adm_login){
			$out .= "<li onclick=\"document.location='?adm_login=$adm_login&adm_pass=$adm_pass&rub=$rub'\"><div class=\"box_wnb_nb_item_select\"><a href=\"?adm_login=$adm_login&adm_pass=$adm_pass&rub=$rub\" class=\"box_wnb_nb_item_link\">".$dsc["admins"][$i]["text"]."</a></div></li>";
		}else{
			$out .= "<li onclick=\"document.location='?adm_login=".$dsc["admins"][$i]["adm_login"]."&adm_pass=".$dsc["admins"][$i]["adm_pass"]."&rub=$rub'\"><div class=\"box_wnb_nb_item\" onMouseOver=\"this.className='box_wnb_nb_item-hover';\" onMouseOut=\"this.className='box_wnb_nb_item';\"><a href=\"?adm_login=".$dsc["admins"][$i]["adm_login"]."&adm_pass=".$dsc["admins"][$i]["adm_pass"]."&rub=$rub\" class=\"box_wnb_nb_item_link\">".$dsc["admins"][$i]["text"]."</a></div></li>";
		}
	}
	$out .= "</ul></div>";
	return $out;
}

function skin_ClientPage (){
	global $lang;
	global $txt_select_lang_title;
	global $adm_pass;
	global $adm_login;
	global $txt_error;
	global $txt_fetching_admin;
	global $txt_client_panel_title;
	global $txt_login_title;
	global $conf_skin;

	global $page_metacontent;
	global $meta;
	global $confirm_javascript;
	global $java_script;
	global $skinCssString;
	global $console;

	////////////////////////////////////
	// Create the top banner and menu //
	////////////////////////////////////
	$anotherTopBanner = anotherTopBanner("DTC");
	//$anotherMenu = makeHoriMenu($txt_top_menu_entrys[$lang],2);

	$anotherLanguageSelection = anotherLanguageSelection();
	$lang_sel = skin($conf_skin,$anotherLanguageSelection,$txt_select_lang_title[$lang]);

	if($adm_login != "" && isset($adm_login) && $adm_pass != "" && isset($adm_pass)){
		// Fetch all the user informations, Print a nice error message if failure.
		$admin = fetchAdmin($adm_login,$adm_pass);
		if(($error = $admin["err"]) != 0){
			$mesg = $admin["mesg"];
			$login_txt = $txt_error[$lang]." $error ".$txt_fetching_admin[$lang]."<font color=\"red\">$mesg</font><br>";
			$login_txt .= login_form();
			$login_skined = skin($conf_skin,$login_txt,$txt_client_panel_title[$lang]." ".$txt_login_title[$lang]);
			$mypage = layout_login_and_languages($login_skined,$lang_sel);
		}else{
			// Draw the html forms
			$HTML_admin_edit_data = '<div class="box_wnb_content_container">'.drawAdminTools($admin).'</div>';
			$mypage = $HTML_admin_edit_data;
		}
	}else{
		$login_txt = login_form();
                $mypage = skin($conf_skin,$login_txt,$txt_client_panel_title[$lang]." ".$txt_login_title[$lang]);
        }
        // Output the result !
//        if(!isset($anotherHilight)) $anotherHilight = "";

//        echo anotherPage("Client:","",$anotherHilight,makePreloads(),$anotherTopBanner,"",$mypage,anotherFooter(""));
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>
<title>DTC: Admin: ".$_SERVER['SERVER_NAME']."</title>
$page_metacontent
$meta
</head>
<body id=\"page\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">

".makePreloads()."
$confirm_javascript
$java_script
<link rel=\"stylesheet\" href=\"gfx/skin/bwoup/skin.css\" type=\"text/css\">
$skinCssString

".anotherTopBanner("DTC","yes")."<div id=\"usernavbarreplacement\"></div>
<div id=\"content\"><div class=\"box_wnb_content_container\">".$mypage."</div></div>
<div id=\"footer\">".anotherFooter("Footer content<br><br>")."</div>
</html>";
}


function skin_DTCConfigMenu ($dsc){
	if(!isset($_REQUEST["sousrub"])){
		$sousrub = "general";
        }else{
          $sousrub = $_REQUEST["sousrub"];
        }

		
		
        $out = '<ul class="box_wnb_nb_items">';

        $keys = array_keys($dsc);
        $nbr_entry = sizeof($dsc);
        for($i=0;$i<$nbr_entry;$i++){
        	if($keys[$i] == $sousrub){
			$out .= '<li><div class="box_wnb_nb_item_select"><a href="?rub=config&sousrub='.$keys[$i].'"><img src="gfx/skin/bwoup/gfx/config-icon/'.$dsc[ $keys[$i] ]["icon"].'" align="top"> '.$dsc[ $keys[$i] ]["text"].'</a></div></li>';
		}else{
			$out .= '<li><div class="box_wnb_nb_item" onMouseOver="this.className=\'box_wnb_nb_item-hover\';" onMouseOut="this.className=\'box_wnb_nb_item\';"><a href="?rub=config&sousrub='.$keys[$i].'"><img src="gfx/skin/bwoup/gfx/config-icon/'.$dsc[ $keys[$i] ]["icon"].'" align="top"> '.$dsc[ $keys[$i] ]["text"].'</a></div></li>';
		}
        }
        $out .= "</ul>";
        return $out;
}

function skin_LayoutClientPage ($menu_content,$main_content,$main_content_title){
	global $conf_skin;
	global $txt_left_menu_title;
	global $lang;

	if($main_content == ""){
		$main_content = "&nbsp;";
		$main_content_title = "&nbsp;";
	}

	return '
  <table class="box_wnb_content_clientimport_box_wnb" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="box_wnb_nb" valign="top">
	<div class="box_wnb_nb_title"><div class="box_wnb_nb_title_left"><div class="box_wnb_nb_title_right"><div class="box_wnb_nb_title_mid">'.$txt_left_menu_title[$lang].'</div></div></div></div>
	<div class="box_wnb_tv_container">
	'.$menu_content.'
	</div>
      </td>
      <td class="box_wnb_content" valign="top">
	<div class="box_wnb_content_container">
	  <h2>'.$main_content_title.'</h2>
	  '.$main_content.'
	</div>
      </td>
    </tr>
    <tr>
      <td class="box_wnb_nb_bottom"></td>
      <td class="box_wnb_content_bottom"></td>
    </tr>
  </table>
';
	return "
<table width=\"100%\" height=\"100%\">
<tr><td valign=\"top\" width=\"220\" height=\"1\">
        <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td>$domain_list</td></tr><tr><td>&nbsp</td></tr></table>
</td><td height=\"100%\">&nbsp;
</td><td align=\"left\" valign=\"top\" height=\"100%\">
        $main
</td></tr>
</table>
";
}

function skin_Navbar (){
	global $rub;
	global $txt_mainmenu_title_useradmin;
	global $txt_mainmenu_title_client_management;
	global $txt_mainmenu_title_bandwidth_monitor;
	global $txt_mainmenu_title_server_monitor;
	global $txt_mainmenu_title_renewals;
	global $txt_product_manager;
	global $txt_mainmenu_title_deamonfile_generation;
	global $txt_mainmenu_title_dtc_config;
	global $lang;

	$out = '<div id="navbar"><div id="navbar_left"></div><ul id="navbar_items">';

	if(!isset($rub) || $rub == "" || $rub == "user" || $rub == "domain_config" || $rub == "adminedit"){
		$out .= '<li><div class="navbar_item-select"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_user.gif" alt="'.$txt_mainmenu_title_useradmin[$lang].'"><br />'.$txt_mainmenu_title_useradmin[$lang].'</div></li>';
	}else{
		$out .= '<li><a href="?rub=user"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_user.gif" alt="'.$txt_mainmenu_title_useradmin[$lang].'"><br />'.$txt_mainmenu_title_useradmin[$lang].'</a></li>';
	}
	if(isset($rub) && $rub == "crm"){
		$out .= '<li><div class="navbar_item-select"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_customer.gif" alt="'.$txt_mainmenu_title_client_management[$lang].'"><br />'.$txt_mainmenu_title_client_management[$lang].'</div></li>';
	}else{
		$out .= '<li><a href="?rub=crm"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_customer.gif" alt="'.$txt_mainmenu_title_client_management[$lang].'"><br />'.$txt_mainmenu_title_client_management[$lang].'</a></li>';
	}
	if(isset($rub) && $rub == "monitor"){
		$out .= '<li><div class="navbar_item-select"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_bandwith.gif" alt="'.$txt_mainmenu_title_bandwidth_monitor[$lang].'"><br />'.$txt_mainmenu_title_bandwidth_monitor[$lang].'</div></li>';
	}else{
		$out .= '<li><a href="?rub=monitor"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_bandwith.gif" alt="'.$txt_mainmenu_title_bandwidth_monitor[$lang].'"><br />'.$txt_mainmenu_title_bandwidth_monitor[$lang].'</a></li>';
	}
	if(isset($rub) && $rub == "graph"){
		$out .= '<li><div class="navbar_item-select"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_server.gif" alt="'.$txt_mainmenu_title_server_monitor[$lang].'"><br />'.$txt_mainmenu_title_server_monitor[$lang].'</div></li>';
	}else{
		$out .= '<li><a href="?rub=graph"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_server.gif" alt="'.$txt_mainmenu_title_server_monitor[$lang].'"><br />'.$txt_mainmenu_title_server_monitor[$lang].'</a></li>';
	}
	if(isset($rub) && $rub == "renewal"){
		$out .= '<li><div class="navbar_item-select"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_renewal.gif" alt="'.$txt_mainmenu_title_renewals[$lang].'"><br />'.$txt_mainmenu_title_renewals[$lang].'</div></li>';
	}else{
		$out .= '<li><a href="?rub=renewal"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_renewal.gif" alt="'.$txt_mainmenu_title_renewals[$lang].'"><br />'.$txt_mainmenu_title_renewals[$lang].'</a></li>';
	}
	if(isset($rub) && $rub == "product"){
		$out .= '<li><div class="navbar_item-select"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_product.gif" alt="'.$txt_product_manager[$lang].'"><br />'.$txt_product_manager[$lang].'</div></li>';
	}else{
		$out .= '<li><a href="?rub=product"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_product.gif" alt="'.$txt_product_manager[$lang].'"><br />'.$txt_product_manager[$lang].'</a></li>';
	}
	if(isset($rub) && $rub == "generate"){
		$out .= '<li><div class="navbar_item-select"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_daemon.gif" alt="'.$txt_mainmenu_title_deamonfile_generation[$lang].'"><br />'.$txt_mainmenu_title_deamonfile_generation[$lang].'</div></li>';
	}else{
		$out .= '<li><a href="?rub=generate"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_daemon.gif" alt="'.$txt_mainmenu_title_deamonfile_generation[$lang].'"><br />'.$txt_mainmenu_title_deamonfile_generation[$lang].'</a></li>';
	}
	if(isset($rub) && $rub == "config"){
		$out .= '<li><div class="navbar_item-select"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_config.gif" alt="'.$txt_mainmenu_title_dtc_config[$lang].'"><br />'.$txt_mainmenu_title_dtc_config[$lang].'</div></li>';
	}else{
		$out .= '<li><a href="?rub=config"><img width="46" height="55" src="gfx/skin/bwoup/gfx/navbar/navbar_p_config.gif" alt="'.$txt_mainmenu_title_dtc_config[$lang].'"><br />'.$txt_mainmenu_title_dtc_config[$lang].'</a></li>';
	}

	$out .= '</ul><div id="navbar_right"></div></div>';
	return $out;
}

function skin_LayoutAdminPage (){
	global $rub;
	global $adm_login;
	global $adm_pass;
	global $conf_session_expir_minute;
	global $pro_mysql_config_table;
	global $conf_skin;

	global $lang;
	global $txt_virtual_admin_list;
	global $txt_root_adm_title;
	global $txt_dtc_configuration;
	global $top_commands;
	global $txt_generate_buttons_title;
	global $txt_iframe_ds;
	global $txt_product_manager;
	global $txt_customer_bw_consumption;
	global $txt_client_addr_title;
	global $txt_client_list_title;
	global $txt_client_admins_title;
	global $txt_client_commands_title;
	global $txt_user_administration;

	global $adm_random_pass;

	global $page_metacontent;
	global $meta;
	global $confirm_javascript;
	global $java_script;
	global $skinCssString;
	global $console;

	///////////////////////
	// Make All the page //
	///////////////////////
	switch($rub){
	case "crm": // CRM TOOL
		$rightFrameCells[] = skin($conf_skin,DTCRMeditClients(),$txt_client_addr_title[$lang]);
			if(isset($_REQUEST["id"]) && $_REQUEST["id"] != "" && $_REQUEST["id"] != 0){
			$rightFrameCells[] = skin($conf_skin,DTCRMclientAdmins(),$txt_client_admins_title[$lang]);
			$rightFrameCells[] = skin($conf_skin,DTCRMshowClientCommands($_REQUEST["id"]),$txt_client_commands_title[$lang]);
		}
		$rightFrame = makeVerticalFrame($rightFrameCells);
		$leftFrameCells[] = skin($conf_skin,DTCRMlistClients(),$txt_client_list_title[$lang]);
		$leftFrame = makeVerticalFrame($leftFrameCells);
		$zemain_content = anotherLeftFrame($leftFrame,$rightFrame);
		break;
	case "renewal":
		$out = drawRenewalTables();
		$zemain_content = skin($conf_skin,$out,"Customer Renewals");
		break;
	case "monitor": // Monitor button
		$out = drawAdminMonitor();
		$zemain_content = skin($conf_skin,$out,$txt_customer_bw_consumption[$lang]);
		break;
	case "graph":
		$zemain_content = skin($conf_skin,drawRrdtoolGraphs (),"Server statistic graphs");
		break;
	case "generate": // Gen Config Files
		$mainFrameCells[] = skin($conf_skin,$top_commands,$txt_generate_buttons_title[$lang]);
		$the_iframe = "<br><IFRAME src=\"deamons_state.php\" width=\"100%\" height=\"135\"></iframe>";
		$mainFrameCells[] = skin($conf_skin,$the_iframe,$txt_iframe_ds[$lang]); // fixed bug by seeb
		// The console
		$mainFrameCells[] = skinConsole();
		$zemain_content = makeVerticalFrame($mainFrameCells);
		break;
	case "config": // Global Config
		$zemain_content = '
<table class="box_wnb" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="box_wnb_nb" valign="top">
    	<div class="box_wnb_nb_title"><div class="box_wnb_nb_title_left"><div class="box_wnb_nb_title_right"><div class="box_wnb_nb_title_mid">'."Menu".'</div></div></div></div>
    	'.drawDTCConfigMenu().'
    </td>
    <td class="box_wnb_content" valign="top">
    	 <div class="box_wnb_content_container">
	  <h2>'.$txt_dtc_configuration[$lang].'</h2>
'.drawDTCConfigForm().'
	</div>
    </td>
  </tr>
  <tr>
    <td class="box_wnb_nb_bottom"></td>
    <td class="box_wnb_content_bottom" valign="top"></td>
  </tr>
</table>';
		break;
	case "product":
		$bla = productManager();
		$zemain_content = skin($conf_skin,$bla,$txt_product_manager[$lang]);
		break;
	case "user": // User Config
	case "domain_config":
	case "adminedit":
	default: // No rub selected

		$bwoup_user_edit = bwoupUserEditForms($adm_login,$adm_pass);

		if(isset($adm_random_pass)){
			$rand = $adm_random_pass;
		}else{
			$rand = getRandomValue();
			$expirationTIME = mktime() + (60 * $conf_session_expir_minute);
			$q = "UPDATE $pro_mysql_config_table SET root_admin_random_pass='$rand', pass_expire='$expirationTIME';";
			$r = mysql_query($q)or die("Cannot execute query \"$q\" !");
		}
		$skinedConsole = '<table cellpadding="0" cellspacing="0" class="console">
	  <tr><td class="console_title">Console output :</td>
	  </tr><tr>		<td class="console_output"><pre>'.$_SERVER['SERVER_NAME'].':&gt;_'.$console.'<br></pre></td></tr></table>';

	  $adm_list = adminList($rand).'
	  <div class="voider"></div>
	  <br /><br />
		<div class="voider"></div>';

		$zemain_content = '
<table class="box_wnb" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="box_wnb_nb" valign="top">
    	<div class="box_wnb_nb_title"><div class="box_wnb_nb_title_left"><div class="box_wnb_nb_title_right"><div class="box_wnb_nb_title_mid">'.$txt_virtual_admin_list[$lang].'</div></div></div></div>
    	'.$adm_list.'
    </td>
    <td class="box_wnb_content" valign="top">
      <div class="box_wnb_content_container">
      <h2>'.$txt_user_administration[$lang].'</h2>
      '.$bwoup_user_edit
      .$skinedConsole.'
      </div>
    </td>
  </tr>
  <tr>
    <td class="box_wnb_nb_bottom"></td>
    <td class="box_wnb_content_bottom" valign="top"></td>
  </tr>
</table>';
		break;
	}

	$dtc_main_menu = skin_Navbar();
	$anotherFooter = anotherFooter("Footer content<br><br>");

	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>
<title>DTC: Admin: ".$_SERVER['SERVER_NAME']."</title>
$page_metacontent
$meta
</head>
<body id=\"page\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">

".makePreloads()."
$confirm_javascript
$java_script
<link rel=\"stylesheet\" href=\"gfx/skin/bwoup/skin.css\" type=\"text/css\">
$skinCssString

".anotherTopBanner("DTC","yes").$dtc_main_menu."
<div id=\"content\">".$zemain_content."</div>
<div id=\"footer\">".anotherFooter("Footer content<br><br>")."</div>
</html>";

}

function bwoupUserEditForms($adm_login,$adm_pass){
	global $txt_general_virtual_admin_edition;
	global $txt_domains_configuration_title;
	global $txt_add_user_title;

	global $txt_client_interface;
	global $txt_domain_config;
	global $txt_admin_editor;
	global $lang;
	// added by seeb
	global $txt_user_administration;
	global $txt_user_administration_domains_for;

	global $adm_random_pass;

	// end added
	global $conf_skin;
	global $lang;
	global $addrlink;
	global $rub;

	$ret["err"] = 0;
	$ret["mesg"] = "No error";

	if(isset($adm_login) && $adm_login != "" && isset($adm_pass) && $adm_pass != ""){
		// Fetch all the selected user informations, Print a nice error message if failure.
		$admin = fetchAdmin($adm_login,$adm_pass);
		if(isset($adm_random_pass)){
			$pass = $adm_random_pass;
		}else{
			$pass = $adm_pass;
		}
		if(($error = $admin["err"]) != 0){
			echo("Error fetching admin : $error");
			$ret["err"] = $admin["err"];
			$ret["mesg"] = $admin["mesg"];
			return $ret;
		}

		$out = '<ul class="box_wnb_content_nb">';
		if($rub != "user" && $rub != ""){
			$out .= "<li class=\"box_wnb_content_nb_item\"><a href=\"?adm_login=$adm_login&adm_pass=$pass&rub=user\"><img width=\"16\" height=\"16\" src=\"gfx/skin/bwoup/gfx/tabs/p_clientinterface.gif\"  align=\"absmiddle\" border=\"0\"> ".$txt_client_interface[$lang]."</a></li>";
		}else{
			$out .= "<li class=\"box_wnb_content_nb_item_select\"><a href=\"?adm_login=$adm_login&adm_pass=$pass&rub=user\"><img width=\"16\" height=\"16\" src=\"gfx/skin/bwoup/gfx/tabs/p_clientinterface.gif\" align=\"absmiddle\" border=\"0\"> ".$txt_client_interface[$lang]."</a></li>";
		}
		$out .= '<li class="box_wnb_content_nb_item_vsep"></li>';
		if($rub != "domain_config"){
			$out .= "<li class=\"box_wnb_content_nb_item\"><a href=\"?adm_login=$adm_login&adm_pass=$pass&rub=domain_config\"><img width=\"16\" height=\"16\" src=\"gfx/skin/bwoup/gfx/tabs/p_domainconfig.gif\" align=\"absmiddle\" border=\"0\">".$txt_domain_config[$lang]."</a></li>";
		}else{
			$out .= "<li class=\"box_wnb_content_nb_item_select\"><a href=\"?adm_login=$adm_login&adm_pass=$pass&rub=domain_config\"><img width=\"16\" height=\"16\" src=\"gfx/skin/bwoup/gfx/tabs/p_domainconfig.gif\" align=\"absmiddle\" border=\"0\">".$txt_domain_config[$lang]."</a></li>";
		}
		$out .= '<li class="box_wnb_content_nb_item_vsep"></li>';
		if($rub != "adminedit"){
			$out .= "<li class=\"box_wnb_content_nb_item\"><a href=\"?adm_login=$adm_login&adm_pass=$pass&rub=adminedit\"><img width=\"16\" height=\"16\" src=\"gfx/skin/bwoup/gfx/tabs/p_admineditor.gif\" align=\"absmiddle\" border=\"0\">".$txt_admin_editor[$lang]."</a></li>";
		}else{
			$out .= "<li class=\"box_wnb_content_nb_item_select\"><a href=\"?adm_login=$adm_login&adm_pass=$pass&rub=adminedit\"><img width=\"16\" height=\"16\" src=\"gfx/skin/bwoup/gfx/tabs/p_admineditor.gif\" align=\"absmiddle\" border=\"0\">".$txt_admin_editor[$lang]."</a></li>";
		}
		$out .= "</ul>";

		//fix up the $adm_login in case it changed because of session vars:
		//in case users play silly bugger with the "GET" variables
		$adm_login = $admin["info"]["adm_login"];

		// Draw the html forms
		if(isset($rub) && $rub == "adminedit"){
			$out .= drawEditAdmin($admin);
		}else if(isset($rub) && $rub == "domain_config"){
			$out .= drawDomainConfig($admin);
		}else{
			$out .= '<table class="box_wnb_content_clientimport"><tr><td>'.drawAdminTools($admin).'</td></tr></table>';
		}
		return $out;
	}else{
		// If no user is in edition, draw a tool for adding an admin
		return drawNewAdminForm();
	}
}

?>