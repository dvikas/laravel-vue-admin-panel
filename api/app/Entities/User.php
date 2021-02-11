<?php

namespace App\Entities;

use App\Notifications\MyResetPassword;
use App\SocialAccount;
use App\Support\HasRolesUuid;
use App\Support\UuidScopeTrait;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User.
 */
class User extends Authenticatable
{
//    use Notifiable, UuidScopeTrait, HasApiTokens, HasRoles, SoftDeletes, HasRolesUuid {
//        HasRolesUuid::getStoredRole insteadof HasRoles;
//    }
    use Notifiable, UuidScopeTrait, HasApiTokens, HasRoles, HasRolesUuid {
        HasRolesUuid::getStoredRole insteadof HasRoles;
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'uuid',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected static function boot() {
        parent::boot();

        static::deleting(function($obj) {
            foreach($obj->parentTasks as $parentTask) {
                foreach($parentTask->tasks as $tasks) {
                    $tasks->draftProjectTasks()->delete();
                }
                $parentTask->tasks()->delete();
                $parentTask->draftProjectMilestones()->delete();
            }
            $obj->draftTasks()->delete();
            $obj->parentTasks()->delete();
        });
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {
        if (array_key_exists('password', $attributes)) {
            $attributes['password'] = bcrypt($attributes['password']);
        }

        $model = static::query()->create($attributes);

        return $model;
    }

    public function getRole()
    {
        return $this->belongsTo(Role::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class, 'user_id', 'id' );
    }
    public function customers()
    {
        return $this->hasMany(Customer::class, 'user_id', 'id' );
    }

    public function draftTasks()
    {
        return $this->hasMany(DraftTask::class, 'user_id', 'id' );
    }
    public function parentTasks()
    {
        return $this->hasMany(ParentTask::class, 'user_id', 'id' );
    }
}
