<?php
return [
    'controller_plugin_config' => [
        'widget' => [
            'fake' => [
                'actions' => [
                    'FakeWidgetAction',
                ],
            ],
        ],
    ],
    'view_helper_config' => [
        'widget' => [
            'fake' => [
                'partials' => [
                    'fake.phtml',
                ],
            ],
        ],
    ],
];
