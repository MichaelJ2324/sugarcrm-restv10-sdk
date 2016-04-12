<?php

$entryPoints = array(
    //GET API EntryPoints
    'ping' => 'GET\\Ping',
    'getRecord' => 'GET\\ModuleRecord',
    'getAttachment' => 'GET\\RecordFileField',

    //POST API EntryPoints
    'oauth2Token' => 'POST\\Oauth2Token',
    'oauth2refresh' => 'POST\\RefreshToken',
    'createRecord' => 'POST\\CreateRecord',
    'filterRecords' => 'POST\\FilterRecords',
    'attachFile' => 'POST\\RecordFileField',
    'oauth2Logout' => 'POST\\OAuth2Logout',
    //TODO: 'relateRecords' => 'POST\\RelateRecords',

    //PUT API EntryPoints
    'updateRecord' => 'PUT\\UpdateRecord',
    'favorite' => 'PUT\\FavoriteRecord',

    //DELETE API EntryPoints
    'deleteRecord' => 'DELETE\\DeleteRecord',
    'unfavorite' => 'DELETE\\FavoriteRecord',
    'deleteFile' => 'DELETE\\RecordFileField'
);