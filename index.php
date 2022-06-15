<?php
// -------------- CHANGE VARIABLES TO SUIT YOUR ENVIRONMENT  --------------
//LDAP server address
$server = "ldap://localhost";
//domain user to connect to LDAP
$user = "user@ddnegative.com";
//user password
$psw = "PASSWORD";
//FQDN path where search will be performed. OU - organizational unit / DC - domain component
$dn = "CN=Users,DC=ddnegative,DC=com";
//Search query. CN - common name (CN=* will return all objects)
$search = "CN=*";
// ------------------------------------------------------------------------
echo "<h2>php LDAP query test</h2>";
echo 'Current PHP version: ' . phpversion();
// connecting to LDAP server
$ds = ldap_connect($server);
$r = ldap_bind($ds, $user, $psw);
// performing search
$sr = ldap_search($ds, $dn, $search);
$data = ldap_get_entries($ds, $sr);
echo "Found " . $data["count"] . " entries";

// echo '<pre>';
// print_r($data);
// echo '</pre>';

// echo "<br> END";

for ($i = 0; $i < $data["count"]; $i++) {
    echo "<h4><strong>Common Name: </strong>" . $data[$i]["cn"][0] . "</h4><br />";
    echo "<strong>Distinguished Name: </strong>" . $data[$i]["dn"] . "<br />";
    //checking if memberof exists 
    if (isset($data[$i]["memberof"][0]))
        echo "<strong> Groups: </strong>" . $data[$i]["memberof"][0] . "<br />";
    else
        echo "<strong>Not a member of any groups</strong><br />";
    //checking if description exists 
    if (isset($data[$i]["description"][0]))
        echo "<strong>Description: </strong>" . $data[$i]["description"][0] . "<br />";
    else
        echo "<strong>Description not set</strong><br />";
    //checking if email exists
    if (isset($data[$i]["mail"][0]))
        echo "<strong>Email: </strong>" . $data[$i]["mail"][0] . "<br /><hr />";
    else
        echo "<strong>Email not set</strong><br /><hr />";
}
// close connection
ldap_close($ds);
