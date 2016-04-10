<?php

$entryPoints = array(
    //GET API EntryPoints
    'ping' => 'GET\\Ping',
    'getRecord' => 'GET\\ModuleRecord',
    'getAttachment' => 'GET\\RecordFileField',
    'filterRecords' => 'POST\\FilterRecords',

    //POST API EntryPoints
    'accessToken' => 'POST\\Oauth2Token',
    'refreshToken' => 'POST\\RefreshToken',
    'createRecord' => 'POST\\CreateRecord',
    'attachFile' => 'POST\\RecordFileField',
    //TODO: 'relateRecords' => 'POST\\RelateRecords',

    //PUT API EntryPoints
    'updateRecord' => 'PUT\\UpdateRecord',
    'favorite' => 'PUT\\FavoriteRecord',

    //DELETE API EntryPoints
    'deleteRecord' => 'DELETE\\DeleteRecord'
);