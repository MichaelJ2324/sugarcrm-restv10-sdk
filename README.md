[![Stories in Ready](https://badge.waffle.io/MichaelJ2324/sugarcrm-restv10-sdk.png?label=ready&title=Ready)](https://waffle.io/MichaelJ2324/sugarcrm-restv10-sdk)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/MichaelJ2324/sugarcrm-restv10-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/MichaelJ2324/sugarcrm-restv10-sdk/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/MichaelJ2324/sugarcrm-restv10-sdk/badges/build.png?b=master)](https://scrutinizer-ci.com/g/MichaelJ2324/sugarcrm-restv10-sdk/build-status/master)
#SugarCRM REST v10 SDK#

##Overview##
A simple and intuitive Library for accessing a Sugar 7's REST v10 API. Allows for Object Oriented design around accessing data from a SugarCRM system, so you can easily get your integration project underway.

##Usage
###Composer
You can easily add the Library to a project, by adding the Package to your composer.json file.
<pre>
    "require": {
        "michaelj2324/sugarcrm-restv10-sdk": '>=0.5'
    },
</pre>
Otherwise you can pull down the package using
<pre>composer require michaelj2324/sugarcrm-restv10-sdk</pre>

###Code
Depending on your use, you can configure your Instance and Authentication credentials in the defaults.php file located in src/ directory.

Otherwise, you will need to pass in your Instance and Authentication Credentials like so:
<pre>
  $instance = 'localhost/sugarcrm/';
  $authOptions = array(
            'username' => 'user',
            'password' => 'pass'
  );
  $SugarAPI = new \SugarAPI\SDK\SugarAPI($instance,$authOptions);
  $SugarAPI->login();
</pre>
Once you have the Object setup, you can call various methods that related to the SugarCRM REST v10 API Endpoints.
See examples directory for a few examples of manipulating data with the SDK, otherwise some brief code snippets below showcase the current available methods for use.

##Current API Methods
###CRUD Methods
- Create Module Records
 - \<module\> - POST
 <pre>
    $SugarAPI = new \SugarAPI\SDK\SugarAPI();
    $SugarAPI->login();
    $SugarAPI->createRecord($module)->data($record)->execute();
 </pre>
- Read Module Records
 - \<module\>/:record - GET
 <pre>
    $SugarAPI = new \SugarAPI\SDK\SugarAPI();
    $SugarAPI->login();
    $SugarAPI->getRecord($module,$recordID)->execute();
 </pre>
 - \<module\>/filter - POST
  - List Module Records, and Filter Records using the Filter API
 <pre>
    $SugarAPI = new \SugarAPI\SDK\SugarAPI();
    $SugarAPI->login();
    $SugarAPI->filterRecords($module)->data($filterParams)->execute();
  </pre>
- Update Module Records
 - \<module\>/:record - PUT
 <pre>
    $SugarAPI = new \SugarAPI\SDK\SugarAPI();
    $SugarAPI->login();
    $SugarAPI->updateRecord($module,$recordID)->data($updatedData)->execute();
 </pre>
- Delete Module Records
 - \<module\>/:record - DELETE
 <pre>
    $SugarAPI = new \SugarAPI\SDK\SugarAPI();
    $SugarAPI->login();
    $SugarAPI->deleteRecord($module,$recordID)->execute();
 </pre>
 
###Authentication
- Login
 - oauth2/token - POST
  <pre>
    $SugarAPI = new \SugarAPI\SDK\SugarAPI();
    $SugarAPI->accessToken()->data($loginParams)->execute();
  </pre>
- Refresh Token
 - oauth2/token - POST
  <pre>
    $SugarAPI = new \SugarAPI\SDK\SugarAPI();
    $SugarAPI->refreshToken()->data($loginParams)->execute();
  </pre>

###File Manipulation
- Upload Files to records, such as Note Records
 - \<module\>/:record/file/:field - POST
 <pre>
     $SugarAPI = new \SugarAPI\SDK\SugarAPI();
     $SugarAPI->login();
     $SugarAPI->attachFile('Notes',$recordID,'filename')->data(array('filename' => '/path/to/file'))->execute();
 </pre>
- Get Files from records, such as Note Records
 - \<module\>/:record/file/:field - GET
 <pre>
    $SugarAPI = new \SugarAPI\SDK\SugarAPI();
    $SugarAPI->login();
    $SugarAPI->getAttachment('Notes',$recordID,'filename')->execute();
 </pre>
 
###Other Methods
- Favorite Records
 - \<module\>/:record/favorite - PUT
 <pre>
     $SugarAPI = new \SugarAPI\SDK\SugarAPI();
     $SugarAPI->login();
     $SugarAPI->favorite($module,$recordID)->execute();
 </pre>


