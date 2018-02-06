<?php

if(!function_exists('isMobile')){
    function isMobile($mobile){
        $mobile_rule = '/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/';
        if(preg_match($mobile_rule, $mobile)){
            return true;
        }
        return false;
    }
}

if(!function_exists('isEmail')){
    function isEmail($email = '')
    {
        if(!empty($email)){
            $email_rule = '/^([a-zA-z0-9_-])+@([a-zA-Z_-])+(\.[a-zA-Z0-9_-])+/';
            if(preg_match($email_rule, $email)){
                return true;
            }
        }
        return false;
    }
}

if(!function_exists('adminAuth')){
    function adminAuth($rule)
    {
        $admin = auth('admin')->user();
        if(empty($admin)) return false;
        //超级管理员
        if($admin->id === 1) return true;
        return \Illuminate\Support\Facades\Gate::forUser($admin)->check($rule);
    }
}


if(!function_exists('getParentData')){
    function getParentData(&$data, $field = 'pid', $value)
    {//dd($data, $value);
        $return_data = [];
        if(!empty($data)){
            foreach($data as $key => $val){
                if($key == $value){
                    $return_data[] = $val;
                    unset($data[$key]);
                    $tmp = getParentData($data, $field, $val[$field]);
                    $return_data = array_merge($return_data, $tmp);
                }
            }
        }
        //dd($return_data);
        return $return_data;
    }
}

if(!function_exists('getSubTreeData')){
    function getSubTreeData(&$data, $field = 'pid', $value, $sub_field = 'data')
    {
        $list = searchParentSubData($data, $field, $value);
        foreach($list as $k => $item){
            $list[$k][$sub_field] = getSubTreeData($data, $field, $item['id']);
        }
        return $list;
    }
}

if(!function_exists('searchParentSubData')){
    function searchParentSubData(&$data, $field, $value)
    {
        $sub_data = [];
        if(empty($data)) return $sub_data;

        foreach($data as $k => $v){
            if($v[$field] == $value){
                $sub_data[] = $v;
                unset($data[$k]);
            }
        }
        return $sub_data;
    }
}

if(!function_exists('createBreadCrumb')){
    function createBreadCrumb($data){
        if(!empty($data)){
            foreach($data as $k => $v){
                echo '<a href="';
                if(count($data) != $k+1){
                    echo $v['url'];
                }else{
                    echo 'javascript:;';
                }
                echo '"><i class="fa '.$v['icon'].'"></i> '.$v['name'].' </a>';
                if(count($data) != $k+1){
                    echo '>>';
                }
            }
        }
    }
}

/**
 * 获取树形结构数据
 */
if(!function_exists('getTreeData')){
    function getTreeData(&$data = [], $field, $parent_field, $depth_field, $value = 0, $depth = 0){
        if($value != 0){
            ++$depth;
        }

        $sub_list = searchParentSubData($data, $parent_field, $value);
        if(empty($sub_list)){
            return $data;
        }

        //遍历子集
        foreach($sub_list as $k => $item){
            $item['depth'] = $depth;
            if($depth > 0){
                $name = str_repeat('&nbsp;', 8*$depth) . '|---' . $item[$depth_field];
            }else{
                $name = $item[$depth_field];
            }
            $item['_' . $depth_field] = $name;
            $data[] = $item;
            getTreeData($data, $field, $parent_field, $depth_field, $item[$field], $depth);
        }

        return $data;
    }
}

/**
 * 检测目录
 * @param $dir_name 文件夹名称
 */
if(!function_exists('checkDir')){
    function checkDir($dir_name){
        if(!empty($dir_name) && $dir_name != '.'){
            $dir_arr = array();
            $dir_arr = explode('/',$dir_name);
            //遍历
            $tmp_dir = '';
            foreach($dir_arr as $k => $v){
                $tmp_dir .= $v.'/';

                //判断文件夹是否存在
                if(!file_exists($tmp_dir)){
                    @mkdir($tmp_dir); //创建文件夹
                }
            }
        }
    }
}

/**
 * 移动文件
 * @param $file 原文件
 * @param $path 新目录
 * @return bool
 */
if(!function_exists('moveFile')){
    function moveFile($file, $path)
    {
        if(!empty($file) && !empty($path)){
            //验证文件是否存在
            if(\Illuminate\Support\Facades\File::exists($file)){
                $path = rtrim($path, PATHINFO_BASENAME);
                //检测文件夹是否存在
                checkDir($path);
                $file_name = pathinfo($file, PATHINFO_BASENAME);
                $bool = \Illuminate\Support\Facades\File::move($file, $path.DIRECTORY_SEPARATOR.$file_name);
                return $bool ? $path.DIRECTORY_SEPARATOR.$file_name : $bool;
            }
        }
        return false;
    }
}

/**
 * 删除文件
 * @param $file 文件
 * @return bool
 */
if(!function_exists('removeFile')){
    function removeFile($file)
    {
        if(!empty($file)) {
            //验证文件是否存在
            if (\Illuminate\Support\Facades\File::exists($file)) {
                return \Illuminate\Support\Facades\File::delete($file);
            }
        }
        return false;
    }
}