<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Modules\Controller\Module' => 'Modules\Controller\ModulesController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'modules' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/modules[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Modules\Controller\Modules',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'modules' => __DIR__ . '/../view',
        ),
    ),
);