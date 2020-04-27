<?php


namespace App\Common\Controllers;

use App\Utils\Sidebar\Item\Anchor;
use App\Utils\Sidebar\Menu;
use Dengarin\Main\Models\User;
use Phalcon\Acl\Adapter\Memory;

/**
 * Class AppController
 *
 * @property Memory $acl
 */
class BaseModuleController extends AppController
{
    public function initialize()
    {
        $sidebar = new Menu();
        $sidebar->addItem(new Anchor('Dashboard', $this->url->get('/'), 'si si-cup'))

            ->addHeading('Collaboration', 'Co')
            ->addItem(new Anchor('Sounds', $this->url->get('/sound'), 'si si-volume-2'))
            ->addItem(new Anchor('Jadwal', $this->url->get('/calendar'), 'si si-calendar'))
            ->addItem(new Anchor('Invitation', $this->url->get('/sound'), 'si si-envelope-letter'))

            ->addHeading('Challenge', 'Ch')
            ->addItem(new Anchor('Kompetisi', $this->url->get('/competition'), 'si si-trophy'));

        $this->setSideBar($sidebar);
    }

    public function onConstruct(){
        $role = User::ROLE_ADMIN;
        $controllerName = $this->router->getNamespaceName() . "\\" . $this->router->getControllerName() . 'Controller';
        $actionName = $this->router->getActionName();
        if (!$this->acl->isAllowed($role, strtolower($controllerName), strtolower($actionName)))
            $this->redirectPermissionDenied();
    }

    public function redirectNotFound(){
        $this->dispatcher->forward(
            [
                'namespace' => 'App\Common\Controllers',
                'controller' => 'error',
                'action' => 'notFound',
            ]
        );
    }

    public function redirectPermissionDenied(){
        $this->dispatcher->forward(
            [
                'namespace' => 'App\Common\Controllers',
                'controller' => 'error',
                'action' => 'permissionDenied',
            ]
        );
    }

    /**
     * @param Menu|null $sidebar
     */
    public function setSideBar($sidebar)
    {
        $this->view->sidebar = $sidebar;
    }
}