<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Uuids;
    public $incrementing = false;

    protected $fillable = [
        'username', 'email', 'password', 'reflink', 'role', 'balance', 'enable_2fa', 'code', 'code_match', 'code_expires_at', 'zip', 'phone', 'country', 'address', 'gender', 'name', 'licence'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }
}
