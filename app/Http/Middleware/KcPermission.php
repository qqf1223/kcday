<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\PermissionModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Cache;
use Illuminate\Support\Facades\View;


class KcPermission
{
    public function handle($request, Closure $next)
    {
        //获取授权菜单
        $data = $this->authPermissionMenu();

        $shareData = [];
        $shareData['authMenus'] = $data['menu_list'];
        $shareData['openMenus'] = $data['open_menu'];
        $shareData['breadcrumbs'] = $data['breadcrumbs'];

        View::share($shareData);
        return $next($request);
    }

    /**
     * 获取所有权限节点
     * @return mixed
     */
    public function authPermissionMenu()
    {
        $data = [];

        $currentRoute = Route::currentRouteName();

        $permission = $this->getPermissions();

        //菜单
        $menu_list = [];
        //重组数据
        $perms = [];
        $now_perms = [];
        foreach($permission as $k => $v){
            if($v['rule'] == $currentRoute){
                $now_perms = $v; //当前权限
            }else{
                $perms[$v['id']] = $v;
            }
            if($v['is_menu'] && adminAuth($v['rule'])){
                $menu_list[] = $v;
            }
        }
        //dd($currentRoute, $permission,$now_perms);
        //面包屑
        $breadcrumbs = [];
        $breadcrumbs_ids = [];
        if(!empty($now_perms)){
            $breadcrumbs = getParentData($perms, 'pid', $now_perms['id']);
            array_unshift($breadcrumbs, $now_perms);
            usort($breadcrumbs, function($a, $b){
                if($a['pid'] == $b['pid']){
                    return 0;
                }
                return $a['pid'] < $b['pid'] ? -1 : 1;
            });
            $breadcrumbs_ids = array_column($breadcrumbs, 'id');
        }
        //转换菜单结构
        $menu_list = getSubTreeData($menu_list, 'pid', 0);
        $data['menu_list'] = $menu_list;
        $data['open_menu'] = array_unique($breadcrumbs_ids);
        $data['breadcrumbs'] = $breadcrumbs;

        return $data;
    }

    /**
     * 获取授权菜单
     */
    public function getPermissions()
    {
        return Cache::store('file')->rememberForever('admin_permission', function(){
            $fields = ['id', 'name', 'rule', 'pid', 'icon', 'is_menu'];
            $permissions = PermissionModel::select($fields)->where('status', 0)->orderBy('sort', 'ASC')->get();
            $permissionsNum = count($permissions);
            $permissions = $permissionsNum ? $permissions->toArray() : [];
            //存在权限
            if($permissionsNum){
                foreach($permissions as $k => $v){
                    try{
                        $url = URL::route($v['rule'], null);
                    }catch(\Exception $e){
                        $url = '/';
                    }
                    $permissions[$k]['url'] = $url;
                }
            }
            return $permissions;
        });
    }
}