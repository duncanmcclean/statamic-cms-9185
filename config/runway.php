<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | Configure the resources (models) you'd like to be available in Runway.
    |
    */

    'resources' => [
        \App\Models\Post::class => [
            'name' => 'Posts',

            'blueprint' => [
                'tabs' => [
                    'main' => ['fields' => [
                        ['handle' => 'title', 'field' => ['type' => 'text', 'validate' => 'required']],
                    ]],
                    'sidebar' => ['fields' => [
                        ['handle' => 'slug', 'field' => ['type' => 'slug', 'validate' => 'required', 'from' => 'title']],
                    ]],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Disable Migrations?
    |--------------------------------------------------------------------------
    |
    | Should Runway's migrations be disabled?
    | (eg. not automatically run when you next vendor:publish)
    |
    */

    'disable_migrations' => false,

];
