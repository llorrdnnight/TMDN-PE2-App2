<?php
$GLOBALS['claims'] = $claims;
$opts = array(
    'http'=>array(
      'method'=>"GET",
      'header'=>"Accept-language: en\r\n" .
                "Cookie: access_token=".$_COOKIE['access_token']."\r\n"
    )
);

$context = stream_context_create($opts);

$response = file_get_contents('http://localhost/common/php/employee.php', false, $context);
$GLOBALS['employee'] = json_decode($response);


function getEmployeeFirstName(){
    return $GLOBALS['employee']->employeeFirstName;

}

function getLoggedInEmployee(){
    return $GLOBALS['employee'];
}

function getLevel(){
$groupsStr = $GLOBALS['claims']['groups'][0];
$startCN = strpos($groupsStr, 'CN=') + 3;
$endCN = strpos($groupsStr, ',');
return substr($groupsStr, $startCN, $endCN-$startCN);
}

function isHR(){
    $level = getLevel();
    if($level == "HR"){
        return true;
    }
    else{
        return false;
    }
}

function isManagement(){
    $level = getLevel();
    if($level == "Supervisors"){
        return true;
    }
    else{
        return false;
    }
}

function isLoggedIn(){
    return isset($claims);
}

?>