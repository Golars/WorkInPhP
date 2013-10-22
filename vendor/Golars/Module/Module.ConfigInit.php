<?php

namespace Golars\Module;

/**
 * Golars lib
 *
 */
class ConfigInit{
    
/*
 * Init module namespace
 */    
private $_NameSpace = 'Application';

/*
 * Path to layout
 */
private $_layout = null;


/*
 *  Route of modules
 */
private $_route = null;

/*
 *  Defaults options
 * @ private $_defaults = array(
 *  'route' => '/',
 *  'controller' => 'Index', 
 *  'action' => 'index',
 * )
 */
private $_defaults = array();


public function __construct($Namespace = '', array $defaults = array(), array $route = array()) {
    
    if (isset($Namespace)) {
        $this->_NameSpace = $Namespace;
    }
    
    if (!empty($defaults)){
        $this->_checkArray($defaults, $this->_defaults);
    }
    
    if (!empty($route)){
        $this->_checkArray($route, $this->_route);
    }
}
/*
 * private _checkArray() function for check array
 * @ array $args input array
 * @ array $args input defaults array
 * 
 */
private function _checkArray( array $args = array(), array $argsDefaults = array()) {
    foreach ($args as $key => $value) {
        if(isset($key[$value])) {
            if(!is_array($key[$value])){
                $argsDefaults[$value] = $key[$value];
            } else {
                $this->_checkArray($key[$value],$argsDefaults[$value]);
            }
        }        
    }
}

private function _init(){
            return array(
            'router' => array(
                'routes' => array(
                    'home' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Index',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'admin' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/admin',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Admin',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    // The following is a route to simplify getting started creating
                    // new controllers and actions without needing to create a new
                    // module. Simply drop new controllers in, and you can access them
                    // using the path /application/:controller/:action
                    'application' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/application',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller'    => 'Index',
                                'action'        => 'index',
                            ),
                            'route'    => '/admin',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller'    => 'Admin',
                                'action'        => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/[:controller[/:action]]',
                                    'constraints' => array(
                                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ),
                                    'defaults' => array(
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'service_manager' => array(
                'abstract_factories' => array(
                    'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
                    'Zend\Log\LoggerAbstractServiceFactory',
                ),
                'aliases' => array(
                    'translator' => 'MvcTranslator',
                ),
            ),
            'translator' => array(
                'locale' => 'en_US',
                'translation_file_patterns' => array(
                    array(
                        'type'     => 'gettext',
                        'base_dir' => __DIR__ . '/../language',
                        'pattern'  => '%s.mo',
                    ),
                ),
            ),
            'controllers' => array(
                'invokables' => array(
                    'Application\Controller\Index' => 'Application\Controller\IndexController',
                    'Application\Controller\Admin' => 'Application\Controller\AdminController',
                ),
            ),
            'view_manager' => array(
                'display_not_found_reason' => true,
                'display_exceptions'       => true,
                'doctype'                  => 'HTML5',
                'not_found_template'       => 'error/404',
                'exception_template'       => 'error/index',
                'template_map' => array(
                    'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
                    'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
                    'error/404'               => __DIR__ . '/../view/error/404.phtml',
                    'error/index'             => __DIR__ . '/../view/error/index.phtml',
                ),
                'template_path_stack' => array(
                    __DIR__ . '/../view',
                ),
            ),
            // Placeholder for console routes
            'console' => array(
                'router' => array(
                    'routes' => array(
                    ),
                ),
            ),
        );
}
}