<?php

class Golars_Autoloader implements Zend_Loader_Autoloader_Interface {

    public function autoload($class) {
        
        if ($this->loadFromSrc($class)) {
            return true;
        }

        $class = str_replace('\\', '_', $class);

        $classInfo = explode('_', $class);

        if (isset($classInfo[1]) && ($classInfo[1] == 'Init')) {
            $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . strtolower($classInfo[0]) . DIRECTORY_SEPARATOR . $classInfo[1] . '.php';
            if (!file_exists($path))
                return false;
            require_once($path);
            return true;
        }

        if ($classInfo[0] == 'Block') {
            $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . "blocks/{$classInfo[1]}.php";
            require_once($path);
            return true;
        }

        switch ($classInfo[1]) {
            case 'Model':
                $classPath = implode(DIRECTORY_SEPARATOR, array_slice($classInfo, 2));

                $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . strtolower($classInfo[0]) . "/models/{$classPath}.php";
                break;

            case 'Block':
                $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . strtolower($classInfo[0]) . "/blocks/{$classInfo[2]}.php";
                break;
            
            case 'Helper':
                $path =  APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR  . strtolower($classInfo[0]) . "/helpers/{$classInfo[2]}.php";
                break;
            
             case 'Plugin':
                $classPath = implode(DIRECTORY_SEPARATOR, array_slice($classInfo, 2));
                $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . strtolower($classInfo[0]) . "/plugins/{$classPath}.php";
                break;

            default:
                return false;
        }

        if (!file_exists($path)) {
            return false;
        }

        require_once($path);
    }

    /**
     * 
     * @param type $class
     * @return boolean
     */
    private function loadFromSrc($class) {
        $classInfo = explode('\\', $class);
        
        if (count($classInfo) < 2) {
            return false;
        }
        
        $module = strtolower($classInfo[0]);
        
        $classPath = implode(DIRECTORY_SEPARATOR, array_slice($classInfo, 1));
        
        $path = APPLICATION_PATH . "/module/$module/src/$classPath.php";
        
        if (!file_exists($path)) {
            return false;
        }
        
        require_once($path);
        
        return true;
    }
}