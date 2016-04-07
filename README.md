#SugarCRM REST v10 SDK#

##Overview##
The code allows for an Object Oriented method of accessing and manipulating the SugarCRM REST v10 API.

##Usage##
###Composer###
-- Packagist coming soon --

###Code###
<pre>
  $instance = 'localhost/sugarcrm/';
  $authOptions = array(
            'username' => 'user',
            'password' => 'pass'
  );
  $SugarAPI = new \SugarAPI\SDK\SugarAPI($instance,$authOptions);
  $SugarAPI->login();
  $record = $SugarAPI->filterRecords('Accounts')->execute()->getResponse()->getBody();
  echo $record->id;
</pre>
See examples directory for a few examples of manipulating data via the API.

##Current API Methods##
- \<module\> - POST
 - Create Module Records
- \<module\>/filter - GET
 - List Module Records
- \<module\>/:record - GET
 - Get Module Record
- oauth2/token - POST
 - Login, and Refresh Token
