<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use KcModel;

    //use Notifiable;
    protected $table = 'roles';

    //不更新created_at和updated_at
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, 'permission_role', 'role_id', 'permission_id');
    }


    public function authorizePermissions($perm_ids)
    {
        $this->permissions()->detach();
        if(!empty($perm_ids)){
            $this->permissions()->sync($perm_ids);
        }
    }

}
