<?php

namespace App;

use App\Models\PermissionModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\KcModel;

class AdminRoleModel extends Model
{
    use KcModel;

    protected $table = 'admin_roles';

    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, );
    }
}
