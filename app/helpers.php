<?php

use \Auth as Auth;
use \Route as Route;

use App\Acl;

if (!function_exists('getCurrentUser')) {
    function getCurrentUser()
    {
        return Auth::user();
    }
}

if (!function_exists('formatHandleErrorMessage')) {
    function formatHandleErrorMessage ($notifyMessage, $e = false)
    {
        $fullMessage = $notifyMessage;
        $enableShowDebugMes = config('constants.backend_enable_show_debug_message');
        if (!empty($e) && is_object($e) && method_exists($e, "getMessage") && $enableShowDebugMes) {
            $fullMessage .= ". Debug: " . $e->getMessage();
        }

        return $fullMessage;
    }
}

if (!class_exists('AclAdapter')) {
    class AclAdapter
    {
        private static $_instance = null;

        private $_controller = null;

        private $_action = null;

        private $_objectRequested = null;

        private $_controllersActionsNeedCheckObjectRequest = array(
            'UsersController' => array(
                'object' => 'user',
                'actions' => array(
                    'edit',
                    'update',
                    'destroy'
                )
            ),
            'ContactsController' => array(
                'object' => 'contact',
                'actions' => array(
                    'edit',
                    'update',
                    'destroy'
                )
            ),
            'GroupContactsController' => array(
                'object' => 'groupContact',
                'actions' => array(
                    'edit',
                    'update',
                    'destroy'
                )
            )
        );

        /**
         * Constructor
         */
        private function __construct()
        {

        }

        /**
         * Get Controller Name
         */
        public function getRequestedController()
        {
            return $this->_controller;
        }

        /**
         * Get Action Name
         */
        public function getRequestedAction()
        {
            return $this->_action;
        }

        /**
         * Get Object Requested
         */
        public function getRequestedObject()
        {
            return $this->_objectRequested;
        }

        /**
         * Authorize user by controller and action
         */
        public function authorizeUser($controller, $action, $user = false)
        {
            if (empty($user)) {
                $user = getCurrentUser();
            }

            if (empty($controller) || empty($action) || empty($user)) {
                return false;
            }

            if (!empty($user->checkIsSuperAdmin())) {
                return true;
            } elseif ($controller == "AclController") {
                return false;
            }

            $permission = Acl::where(array(
                'controller' => $controller,
                'action' => $action
            ))->first();
            if (empty($permission) || empty($permission->permission)) {
                return false;
            }
            $permission = $permission->permission;

            return $user->checkHasPermission($permission->name);
        }

        /**
         * Restrict user
         */
        public function restrictUser($return = false)
        {
            $check = $this->authorizeUser($this->_controller, $this->_action);
            if ($return) {
                return $check;
            }

            if ($check && !empty($this->_objectRequested)) {
                $user = getCurrentUser();

                switch ($this->_controller) {
                    case "UsersController":
                        $listUsersManage = $user->getListManageUsers();
                        $listUsersManage = $listUsersManage['list']->get()->toArray();
                        $listUsersManage = array_map(function ($item) {
                            return $item['id'];
                        }, $listUsersManage);
                        $check = in_array($this->_objectRequested->id, $listUsersManage);
                        break;
                    case "ContactsController":
                        $contactRequested = $this->_objectRequested->id;
                        $listContactsManage = $user->whereHas('contacts', function($q) use($contactRequested) {
                            $q->where('id', $contactRequested);
                        })->get();
                        $check = $listContactsManage->isNotEmpty();
                        break;
                    case "GroupContactsController":
                        $groupContactRequested = $this->_objectRequested->id;
                        $listGroupContactsManage = $user->whereHas('group_contacts', function($q) use($groupContactRequested) {
                            $q->where('id', $groupContactRequested);
                        })->get();
                        $check = $listGroupContactsManage->isNotEmpty();
                        break;
                }
            }

            if (!$check) {
                abort('401');
            }
        }

        /**
         * Check querying controller and action
         *
         * @param string $controller
         * @param string $action
         *
         * @return boolean
         */
        public function checkQueryingControllerAction($controller, $action)
        {
            $controller = trim($controller);
            $action = trim($action);

            if (empty($controller) || empty($action)) {
                return false;
            }

            return $this->_controller == $controller && $this->_action == $action;
        }

        /**
         * Parse requested controller and action
         */
        private function _parseRequestedControllerAndAction()
        {
            $this->_resetData();

            $currentAction = Route::currentRouteAction();
            if (empty($currentAction)) {
                return;
            }
            list($controller, $action) = explode('@', $currentAction);

            $controller = preg_replace('/.*\\\/', '', $controller);

            $this->_controller = $controller;
            $this->_action = $action;

            if (!empty($this->_controllersActionsNeedCheckObjectRequest[$this->_controller])) {
                $data = $this->_controllersActionsNeedCheckObjectRequest[$this->_controller];
                if (in_array($this->_action, $data['actions'])) {
                    $objectName = $data['object'];
                    $this->_objectRequested = request()->route($objectName);
                }
            }
        }

        private function _resetData()
        {
            $this->_controller = $this->_action = $this->_objectRequested = null;
        }

        /**
         * Get instance
         *
         * @return: object
         */
        public static function getInstance()
        {
            if (self::$_instance == null) {
                self::$_instance = new AclAdapter();
            }

            self::$_instance->_parseRequestedControllerAndAction();

            return self::$_instance;
        }
    }
}

if (!function_exists('debugVar')) {
    function debugVar($var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
}