<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\KcModel;
use App\Models\RoleModel;

class AdminUsersModel extends Authenticatable
{
    use KcModel;

    //use Notifiable;
    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false;

    /**
     * 用户组,一个用户可以属于多个用户组
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class,'admin_role_user','user_id','role_id');
    }

    /**
     * 授权角色
     * @param array $role_ids
     */
    public function authorizeRoles(array $role_ids)
    {
        //清空角色
        $this->roles()->detach();

        if(!empty($role_ids)){
            $this->roles()->sync($role_ids);
        }
    }
}
