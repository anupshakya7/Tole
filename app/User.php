<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\LockableTrait;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $status
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
	use LockableTrait;
    use HasRoles;
	use LogsActivity;
	use Impersonate;

    protected $fillable = ['name', 'email','status', 'password', 'remember_token'];
    
	protected static $logAttributes = ['name', 'email','status','password'];
	
	protected static $logName = "user";
	
	protected static $logOnlyDirty = true; //logging only the attributes that has been changed
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
	public function getDescriptionForEvent(string $eventName): string
	{
		return "User have been {$eventName} by :causer.name";
	}
	
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'model_has_roles','model_id','role_id');
    }
    
    
    
}
