<?php
return [
    'navigation' => [
        'default' => [
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'useRouteMatch' => true,
                'tabindex' => 20,
            ],
            [
                'label' => 'Servers',
                'route' => 'servers',
                'useRouteMatch' => true,
                'tabindex' => 40,
            ],
            [
                'label' => 'Puppet',
                'route' => 'puppet',
                'tabindex' => 60,
                'pages' => [
                    [
                        'label' => 'Day reports',
                        'route' => 'puppet',
                        'controller' => 'reports',
                        'action' => 'index',
                        'useRouteMatch' => true,
                        'tabindex' => 61,
                    ],
                    [
                        'label' => 'Environments',
                        'route' => 'puppet',
                        'controller' => 'environments',
                        'action' => 'index',
                        'useRouteMatch' => true,
                        'roles' => 'admin',
                        'tabindex' => 61,
                    ],
                    [
                        'label' => 'Modules',
                        'route' => 'puppet',
                        'controller' => 'modules',
                        'action' => 'index',
                        'useRouteMatch' => true,
                        'tabindex' => 62,
                    ],
                    [
                        'label' => 'Groups',
                        'route' => 'puppet',
                        'controller' => 'groups',
                        'action' => 'index',
                        'useRouteMatch' => true,
                        'tabindex' => 63,
                    ],
                    [
                        'label' => 'Changes',
                        'route' => 'puppet',
                        'controller' => 'revisions',
                        'action' => 'index',
                        'useRouteMatch' => true,
                        'tabindex' => 64,
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'DateTimeFactory' => 'KmbBase\DateTimeFactory',
        ],
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
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
