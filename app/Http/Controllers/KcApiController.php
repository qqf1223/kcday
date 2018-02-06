<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AdminUserService;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\Libs\Tool;

class KcApiController extends Controller
{
    protected $_adminUserService;
    protected $_roleService;
    protected $_permissionService;

    public function __construct(AdminUserService $_adminUserService, PermissionService $_permissionService, RoleService $_roleService, Tool $tool)
    {
        $this->_adminUserService = $_adminUserService;
        $this->_permissionService = $_permissionService;
        $this->_roleService = $_roleService;

        $this->tool = $tool;
    }


    protected function _init(){}
}