[![Stories in Ready](https://badge.waffle.io/MichaelJ2324/sugarcrm-restv10-sdk.png?label=ready&title=Ready)](https://waffle.io/MichaelJ2324/sugarcrm-restv10-sdk)
#SugarCRM REST v10 SDK#

##Overview##
A simple and intuitive Library for accessing a Sugar 7's REST v10 API. Allows for Object Oriented design around accessing data from a SugarCRM system, so you can easily get your integration project underway.

##Usage##
###Composer###
You can easily add the Library to a project, by adding the Package to your composer.json file.
<pre>
    "require": {
        "michaelj2324/sugarcrm-restv10-sdk": '>=0.5'
    },
</pre>
Otherwise you can pull down the package using
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
- \<module\>/:record/favorite - PUT
 - Favorite a Module Record
- oauth2/token - POST
 - Login, and Refresh Token
