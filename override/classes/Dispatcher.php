<?php

class Dispatcher extends DispatcherCore
{
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public $etsAwuDispatcher = null;
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    protected function __construct()
    {
        if(file_exists(_PS_MODULE_DIR_.'ets_awesomeurl/classes/EtsAwuDispatcher.php'))
        {
            require_once _PS_MODULE_DIR_.'ets_awesomeurl/classes/EtsAwuDispatcher.php';
        }
        if(class_exists('EtsAwuDispatcher'))
        {
            $this->etsAwuDispatcher = EtsAwuDispatcher::getDispatcher();
            if($this->enabledRemoveIdInUrl() && (int)Configuration::get('PS_REWRITING_SETTINGS'))
            {
                $this->default_routes = $this->etsAwuDispatcher->getDefaultRouteNoId();
            }
        }
        parent::__construct();
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function getController($id_shop = null)
    {
        parent::getController($id_shop);
        if($this->etsAwuDispatcher)
        {
            if($this->enabledRemoveIdInUrl())
            {
                $this->controller = $this->etsAwuDispatcher->getController($this, $this->controller,self::FC_MODULE);
            }
            $this->controller = $this->etsAwuDispatcher->getSitemapAndRssController($this, $this->controller, $this->request_uri, self::FC_MODULE);
            if(($this->controller == '404' || $this->controller == 'pagenotfound') && (int)Configuration::get('ETS_AWU_ENABLE_REDIRECT_NOTFOUND'))
            {
                if($this->enabledRemoveIdInUrl())
                {
                    $this->etsAwuDispatcher->redirectToOldUrl($this,true);
                }
                else{
                    $this->etsAwuDispatcher->redirectToOldUrl($this);
                }
            }
        }
        return $this->controller;
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function getControllerForRedirect($id_shop = null)
    {
        if($this->etsAwuDispatcher)
        {
            $this->controller = null;
            unset($_GET['controller']);
            $controller =  parent::getController($id_shop);
            $this->controller = $this->etsAwuDispatcher->getSitemapAndRssController($this, $controller, $this->request_uri, self::FC_MODULE);
        }
        return $this->controller;
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function getControllerChecking($id_shop= null)
    {
        $this->controller = null;
        unset($_GET['controller']);
        return $this->getController($id_shop);
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function getRoutes()
    {
        return $this->routes;
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public  function enabledRemoveIdInUrl()
    {
        return (int)Configuration::get('ETS_AWU_ENABLE_REMOVE_ID_IN_URL')
            && !defined('_PS_ADMIN_DIR_')
            && (int)Configuration::get('PS_REWRITING_SETTINGS');
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function setOldRoutes($id_shop = null)
    {
        $context = Context::getContext();
        if (isset($context->shop) && $id_shop === null) {
            $id_shop = (int) $context->shop->id;
        }
        $language_ids = Language::getIDs();
        if (isset($context->language) && !in_array($context->language->id, $language_ids)) {
            $language_ids[] = (int) $context->language->id;
        }
        foreach ($this->default_routes as $id => $route) {
            $route = $this->computeRoute(
                $route['rule'],
                $route['controller'],
                $route['keywords'],
                isset($route['params']) ? $route['params'] : array()
            );
            foreach ($language_ids as $id_lang) {
                $this->routes[$id_shop][$id_lang][$id] = $route;
            }
        }
        if ($this->use_routes) {
            $sql = 'SELECT m.page, ml.url_rewrite, ml.id_lang
					FROM `' . _DB_PREFIX_ . 'meta` m
					LEFT JOIN `' . _DB_PREFIX_ . 'meta_lang` ml ON (m.id_meta = ml.id_meta' . Shop::addSqlRestrictionOnLang('ml', (int) $id_shop) . ')
					ORDER BY LENGTH(ml.url_rewrite) DESC';
            if ($results = Db::getInstance()->executeS($sql)) {
                foreach ($results as $row) {
                    if ($row['url_rewrite']) {
                        $this->addRoute(
                            $row['page'],
                            $row['url_rewrite'],
                            $row['page'],
                            $row['id_lang'],
                            array(),
                            array(),
                            $id_shop
                        );
                    }
                }
            }
            if (!$this->empty_route) {
                $this->empty_route = array(
                    'routeID' => 'index',
                    'rule' => '',
                    'controller' => 'index',
                );
            }
        }
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function validateRoute($route_id, $rule, &$errors = array())
    {
        $ETS_AWU_ENABLE_REMOVE_ID_IN_URL = (int)Tools::getValue('ETS_AWU_ENABLE_REMOVE_ID_IN_URL');
        if($ETS_AWU_ENABLE_REMOVE_ID_IN_URL
            || ((int)Configuration::get('ETS_AWU_ENABLE_REMOVE_ID_IN_URL') && !(int)Configuration::get('PS_REWRITING_SETTINGS')))
        {
            $errors = array();
            if (!isset($this->default_routes[$route_id])) {
                return false;
            }
            foreach ($this->default_routes[$route_id]['keywords'] as $keyword => $data) {
                if (isset($data['param']) && ($route_id == 'module' || ($route_id != 'module' && $keyword == 'rewrite')) && !preg_match('#\{([^{}]*:)?' . $keyword . '(:[^{}]*)?\}#', $rule)) {
                    $errors[] = $keyword;
                }
            }
            return (count($errors)) ? false : true;
        }
        return parent::validateRoute($route_id, $rule, $errors);
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function getFontController()
    {
        return $this->front_controller;
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function setFrontController($controller)
    {
        $this->front_controller = $controller;
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function getUseDefaultController()
    {
        return $this->useDefaultController();
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function setDefaultRoutes($routes)
    {
        $this->default_routes = $routes;
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function publicLoadRoutes()
    {
        parent::loadRoutes();
    }
    
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    public function computeRoute($rule, $controller, array $keywords = [], array $params = [])
    {
        if(method_exists(get_parent_class($this), 'computeRoute')){
            return parent::computeRoute($rule, $controller, $keywords, $params);
        }
        $regexp = preg_quote($rule, '#');
        if ($keywords) {
            $transform_keywords = array();
            preg_match_all(
                '#\\\{(([^{}]*)\\\:)?(' .
                implode('|', array_keys($keywords)) . ')(\\\:([^{}]*))?\\\}#',
                $regexp,
                $m
            );
            for ($i = 0, $total = count($m[0]); $i < $total; ++$i) {
                $prepend = $m[2][$i];
                $keyword = $m[3][$i];
                $append = $m[5][$i];
                $transform_keywords[$keyword] = array(
                    'required' => isset($keywords[$keyword]['param']),
                    'prepend' => Tools::stripslashes($prepend),
                    'append' => Tools::stripslashes($append),
                );
                $prepend_regexp = $append_regexp = '';
                if ($prepend || $append) {
                    $prepend_regexp = '(' . $prepend;
                    $append_regexp = $append . ')?';
                }
                if (isset($keywords[$keyword]['param'])) {
                    $regexp = str_replace(
                        $m[0][$i],
                        $prepend_regexp .
                        '(?P<' . $keywords[$keyword]['param'] . '>' . $keywords[$keyword]['regexp'] . ')' .
                        $append_regexp,
                        $regexp
                    );
                } else {
                    $regexp = str_replace(
                        $m[0][$i],
                        $prepend_regexp .
                        '(' . $keywords[$keyword]['regexp'] . ')' .
                        $append_regexp,
                        $regexp
                    );
                }
            }
            $keywords = $transform_keywords;
        }
        $regexp = '#^/' . $regexp . '$#u';
        return array(
            'rule' => $rule,
            'regexp' => $regexp,
            'controller' => $controller,
            'keywords' => $keywords,
            'params' => $params,
        );
    }
    /*
    * module: ets_awesomeurl
    * date: 2023-01-21 19:29:14
    * version: 1.1.5
    */
    protected function setRequestUri()
    {
        parent::setRequestUri();
        if(!isset(${'_GET'}['isolang']) && (int)Configuration::get('ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL') && ($idLang = (int)Configuration::get('PS_LANG_DEFAULT'))){
            if($idLang && ($iso = Language::getIsoById($idLang))){
                $_GET['isolang'] = $iso;
            }
        }
    }
    /*
    * module: ybc_blog
    * date: 2023-01-21 19:29:14
    * version: 4.4.2
    */
    public function getController___ybc_blog($id_shop = null)
    {
        parent::getController($id_shop);
        $controller = $this->controller;
        if ($controller == '404' || $controller == 'pagenotfound' || $controller == 'sitemap') {
            if (Configuration::get('YBC_BLOG_ENABLE_SITEMAP') && preg_match("/modules\/ybc_blog\/sitemap(\/(\w+(\/(\w+)|))|)\.xml$/", $this->request_uri)) {
                $_GET['module'] = 'ybc_blog';
                $this->controller = 'sitemap';
                $_GET['fc'] = 'module';
                $this->front_controller = self::FC_MODULE;
            }
        }
        return $this->controller;
    }   
}