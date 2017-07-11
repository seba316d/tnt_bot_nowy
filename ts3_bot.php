<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-02-20
 * Time: 17:13
 */
/*
require_once ('C:\Users\s.manczak\Desktop\dodaj\libraries\TeamSpeak3\TeamSpeak3.php');
$localIP = getHostByName(getHostName());
echo '<pre>';
print_r($localIP);
echo '</pre>';

$filter['connection_client_ip'] = $localIP;





// load framework files
// connect to local server, authenticate and spawn an object for the virtual server on port 9987
$ts3_VirtualServer = TeamSpeak3::factory("serverquery://serveradmin:wNMRvyio@127.0.0.1:10011/?server_port=9987");
// query clientlist from virtual server
$arr_ClientList = $ts3_VirtualServer->clientList();
// client ip
foreach($arr_ClientList as $cld){
    echo '<pre>';
    print_r($cld["connection_client_ip"]);
    echo
        ' 
										<form action="" method="POST" class="form-inline">
											<div class="form-group">
												<input type="hidden" class="form-control" name="uid" id="uid" value="'.$cld['client_unique_identifier'].'">
												<input type="hidden" class="form-control" name="nick" id="nick" value="'.$cld['client_nickname'].'">
												<input type="hidden" class="form-control" name="clid" id="clid" value="'.$cld['clid'].'">
											</div>
											<button type="submit" class="btn btn-success">'.$cld['client_nickname'].'</button>
										</form> 
									';
    echo '</pre>';

}

echo $ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html("images/viewericons/", "images/countryflags/", "data:image"));

*/

require_once ("include/ts3admin.class.php");





