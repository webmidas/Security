<?php
/**
 * How to use cookies securely in PHP
 *  
 */
 
 
function SetSecureCookie($name, $value, $expire, $path, $domain, $secure, $httponly, $samesite="None")
{
    if (PHP_VERSION_ID < 70300) {
        setcookie($name, $value, $expire, "$path; samesite=$samesite", $domain, $secure, $httponly);
    }
    else {
        setcookie($name, $value, [
            'expires' => $expire,
            'path' => $path,
            'domain' => $domain,
            'samesite' => $samesite,
            'secure' => $secure,
            'httponly' => $httponly,
        ]);
    }
}


function EncodeCookie($data) {
    return str_replace(['+', '/'], ['-', '_'], base64_encode($data));
}

function DecodeCookie($data) {
    return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
}


//Example Implementation

$name="_host-2158"; //name of cookie
$value="user:1|grp:1";  //cookie data
//Its good practise to encode the cookie contents to make it more secure
$value= EncodeCookie($value);
$expire=time()+3600;  //time till the cookie will be valid
$expired=time()-3600;  //keep time to be in past if u want it to get destroyed
$path="/";  //path where cookie will be available, accessible and valid
$domain=""; //domain where the cookies will be available, valid and accesible. This works with path. Leave blank to make it hostonly cookie
$secure=true; //make it true to make this cookie accessible over https only
$httponly=true; //make it true to make the cookie accessible over http only.
$samesite="Strict"; // set this parameter as per need

SetSecureCookie($name, $value, $expire, $path, $domain, $secure, $httponly, $samesite);

//Destroy Cookie
SetSecureCookie($name, $value, $expired, $path, $domain, $secure, $httponly, $samesite);

//Access Cookies
print_r($_COOKIE);




