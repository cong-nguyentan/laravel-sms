<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Auth;

use App\Acl;
use App\GroupContact;

class ViewGlobalVarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view) {
            $view->with('currentUser', Auth::user());
            $view->with('aclObj', \AclAdapter::getInstance());
            $view->with('backendSuperAdminMenu', array(
                0 => array(
                    'name' => __('acl.manage_page_title'),
                    'controller' => 'AclController',
                    'action' => 'index',
                    'childs' => array(
                        0 => array(
                            'name' => __('acl.add_page_title'),
                            'controller' => 'AclController',
                            'action' => 'create'
                        ),
                        1 => array(
                            'name' => __('acl.design_menu_page_title'),
                            'controller' => 'AclController',
                            'action' => 'designMenu'
                        )
                    )
                ),
                1 => array(
                    'name' => __('permission.manage_page_title'),
                    'controller' => 'PermissionsController',
                    'action' => 'index',
                    'childs' => array(
                        0 => array(
                            'name' => __('permission.add_page_title'),
                            'controller' => 'PermissionsController',
                            'action' => 'create'
                        ),
                        1 => array(
                            'name' => __('permission.design_group_page_title'),
                            'controller' => 'PermissionsController',
                            'action' => 'designGroup'
                        )
                    )
                ),
                2 => array(
                    'name' => __('role.manage_page_title'),
                    'controller' => 'RolesController',
                    'action' => 'index',
                    'childs' => array(
                        0 => array(
                            'name' => __('role.add_page_title'),
                            'controller' => 'RolesController',
                            'action' => 'create'
                        )
                    )
                )
            ));
            $aclModel = new Acl();
            $view->with('backendUserMenu', $aclModel->getDesignedMenu(true));

            $userLogged = getCurrentUser();
            if (!empty($userLogged)) {
                switch ($view->getName()) {
                    case "users.index":
                    case "users.create":
                    case "users.edit":
                        $roles = $userLogged->getListManageRoles();
                        $listFilterRoles = array(
                            '' => __('user.select_role_filter')
                        );
                        foreach ($roles as $role) {
                            $listFilterRoles[$role->id] = $role->name;
                        }

                        $view->with('listFilterRoles', $listFilterRoles);
                        $view->with('manageRoles', $roles);
                        break;
                    case "contacts.index":
                    case "contacts.create":
                    case "contacts.edit":
                        if ($userLogged->checkIsSuperAdmin()) {
                            $groupContacts = GroupContact::with(array('creator'))->orderby('name')->get();
                            $listFilterGroupContacts = array(
                                '' => __('contact.select_group_contact_filter')
                            );
                            foreach ($groupContacts as $groupContact) {
                                $listFilterGroupContacts[$groupContact->id] = $groupContact->name . "-=-" . $groupContact->creator->email;
                            }
                        } else {
                            $groupContacts = $userLogged->group_contacts()->orderby('name')->get();
                            $listFilterGroupContacts = array(
                                '' => __('contact.select_group_contact_filter')
                            );
                            foreach ($groupContacts as $groupContact) {
                                $listFilterGroupContacts[$groupContact->id] = $groupContact->name;
                            }
                        }

                        $view->with('listFilterGroupContacts', $listFilterGroupContacts);
                        $view->with('manageGroupContacts', $groupContacts);
                        break;
                    default:
                }
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
