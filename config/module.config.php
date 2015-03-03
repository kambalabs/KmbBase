<?php
return [
    'router' => [
        'routes' => [
            'index' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/',
                ],
            ],
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'DateTimeFactory' => 'KmbBase\DateTimeFactory',
        ],
        'abstract_factories' => [
            'KmbBase\Factory\NavigationAbstractFactory',
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controller_plugins' => [
        'invokables' => [
            'globalMessenger' => 'KmbBase\Controller\Plugin\GlobalMessenger',
        ],
        'factories' => [
            'translate' => 'KmbBase\Controller\Plugin\TranslateFactory',
        ],
    ],
    'navigation' => [
        'navbar' => [],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'environmentSelect' => 'KmbBase\View\Helper\EnvironmentSelect',
            'markdownToHtml'    => 'KmbBase\View\Helper\MarkdownToHtml',
            'printBoolean'      => 'KmbBase\View\Helper\PrintBoolean',
            'truncate'          => 'KmbBase\View\Helper\Truncate',
        ],
        'factories' => [
            'globalMessenger'   => 'KmbBase\View\Helper\GlobalMessengerFactory',
            'widget'            => 'KmbBase\View\Helper\WidgetFactory',
        ],
    ],
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format'      => '<ul class="flash" style="display: none"><li%s>',
            'message_close_string'     => '</li></ul>',
            'message_separator_string' => '</li><li%s>'
        ],
    ],
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
];
