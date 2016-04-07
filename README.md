#SugarCRM REST v10 SDK#

##Overview##
The code allows for an Object Oriented method of accessing and manipulating the SugarCRM REST v10 API.

##Usage##
###Composer###
<pre>composer require michaelj2324/sugarcrm-restv10-sdk</pre>

###Code###
<pre>
  $instance = 'localhost/sugarcrm/';
  $authOptions = array(
            'username' => 'user',
            'password' => 'pass'
  );
  $id = '1234a';
  $SugarAPI = new \SugarAPI\SDK\SugarAPI($instance,$authOptions);
  $SugarAPI->login();
  $record = $SugarAPI->getRecord('Accounts',$id)->execute()->getResponse()->getBody();
  echo $record->id;
</pre>
See examples directory for a few examples of manipulating data via the API.

##Current API Methods##
- \<module\> - POST
 - Create Module Records
- \<module\>/filter - POST
 - List Module Records, and Filter Records using the Filter API
- \<module\>/:record - GET
 - Get Module Record
- \<module\>/:record - PUT
 - Update Module Record
- oauth2/token - POST
 - Login, and Refresh Token
