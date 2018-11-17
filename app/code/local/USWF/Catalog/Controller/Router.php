<?php

class USWF_Catalog_Controller_Router extends USWF_SeoSuite_Controller_Router
{
    public function match(Zend_Controller_Request_Http $request)
    {
        $data = $request->getParam('data', false);
        $url = isset($data['url']) ? $data['url'] : "";
        $url = Mage::getSingleton('core/url')->escape($url);

        if (Zend_Uri::check($url)) {
            $requestFilter = new Mage_Core_Controller_Request_Http($url);
            $requestFilter->setPathInfo()->setDispatched(false);

            Mage::app()->setRequest($requestFilter);
            parent::match($requestFilter);
            $this->_getRequestRewriteController()->rewrite();

            // dispatch action
            $request->setDispatched(true);
            $requestFilter->setDispatched(true);

            $controllerInstance = $this->getOriginController($request, $requestFilter);
            if ($controllerInstance) {
                $controllerInstance->dispatch($request->getActionName());
                return true;
            }
        }
        return false;
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param Zend_Controller_Request_Http $originRequest
     * @return boolean
     */
    public function getOriginController(Zend_Controller_Request_Http $request,
                                 Zend_Controller_Request_Http $originRequest)
    {
        //checking before even try to find out that current module
        //should use this router
        if (!$this->_beforeModuleMatch()) {
            return false;
        }

        $this->fetchDefault();

        $front = $this->getFront();
        $path = trim($request->getPathInfo(), '/');

        if ($path) {
            $p = explode('/', $path);
        } else {
            $p = explode('/', $this->_getDefaultPath());
        }

        // get module name
        if ($request->getModuleName()) {
            $module = $request->getModuleName();
        } else {
            if (!empty($p[0])) {
                $module = $p[0];
            } else {
                $module = $this->getFront()->getDefault('module');
                $request->setAlias(Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS, '');
            }
        }
        if (!$module) {
            if (Mage::app()->getStore()->isAdmin()) {
                $module = 'admin';
            } else {
                return false;
            }
        }

        /**
         * Searching router args by module name from route using it as key
         */
        $modules = $this->getModuleByFrontName($module);

        if ($modules === false) {
            return false;
        }

        // checks after we found out that this router should be used for current module
        if (!$this->_afterModuleMatch()) {
            return false;
        }

        /**
         * Going through modules to find appropriate controller
         */
        $found = false;
        foreach ($modules as $realModule) {
            $request->setRouteName($this->getRouteByFrontName($module));

            // get controller name
            if ($request->getControllerName()) {
                $controller = $request->getControllerName();
            } else {
                if (!empty($p[1])) {
                    $controller = $p[1];
                } else {
                    $controller = $front->getDefault('controller');
                    $request->setAlias(
                        Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                        ltrim($request->getOriginalPathInfo(), '/')
                    );
                }
            }

            // get action name
            if (empty($action)) {
                if ($request->getActionName()) {
                    $action = $request->getActionName();
                } else {
                    $action = !empty($p[2]) ? $p[2] : $front->getDefault('action');
                }
            }

            //checking if this place should be secure
            $this->_checkShouldBeSecure($request, '/' . $module . '/' . $controller . '/' . $action);

            $controllerClassName = $this->_validateControllerClassName($realModule, $controller);
            if (!$controllerClassName) {
                continue;
            }

            // instantiate controller class
            $controllerInstance = Mage::getControllerInstance($controllerClassName, $originRequest, Mage::app()->getResponse());

            if (!$this->_validateControllerInstance($controllerInstance)) {
                continue;
            }

            if (!$controllerInstance->hasAction($action)) {
                continue;
            }

            $found = true;
            break;
        }

        /**
         * if we did not found any suitable
         */
        if (!$found) {
            if ($this->_noRouteShouldBeApplied()) {
                $controller = 'index';
                $action = 'noroute';

                $controllerClassName = $this->_validateControllerClassName($realModule, $controller);
                if (!$controllerClassName) {
                    return false;
                }

                // instantiate controller class
                $controllerInstance = Mage::getControllerInstance($controllerClassName, $request,
                    Mage::app()->getResponse());

                if (!$controllerInstance->hasAction($action)) {
                    return false;
                }
            } else {
                return false;
            }
        }

        // set values only after all the checks are done
        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
        $request->setControllerModule($realModule);

        // set parameters from pathinfo
        for ($i = 3, $l = sizeof($p); $i < $l; $i += 2) {
            $request->setParam($p[$i], isset($p[$i + 1]) ? urldecode($p[$i + 1]) : '');
        }

        return $controllerInstance;
    }

    protected function _getRequestRewriteController()
    {
        $className = (string)Mage::getConfig()->getNode('global/request_rewrite/model');

        return Mage::getSingleton('core/factory')->getModel($className, array(
            'routers' => Mage::app()->getFrontController()->getRouters(),
        ));
    }
}