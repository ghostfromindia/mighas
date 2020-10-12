<?php

namespace App;

use App\Models\WishList;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use App\Notifications\PasswordReset; 

class User extends Authenticatable implements BannableContract
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use Bannable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'email', 'password', 'country_code', 'phone_number', 'state_id', 'country_id', 'pin_code', 'address', 'banned_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute() {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
    public function roles()
    {
        return $this->belongsToMany('App\Models\Roles', 'role_users', 'user_id', 'role_id')->withTimestamps();
    }

    public function user_roles()
    {
        return $this->hasMany('App\Models\RoleUsers', 'user_id');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\States', 'state_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Countries', 'country_id');
    }

    public function phone_code()
    {
        return $this->belongsTo('App\Models\Countries', 'country_code', 'phonecode');
    }

    public function identities() {
       return $this->hasMany('App\SocialIdentity');
    }




    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }
}
