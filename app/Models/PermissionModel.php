<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    use KcModel;

    //use Notifiable;
    protected $table = 'permission';

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

    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'permission_role', 'permission_id', 'role_id');
    }


}
