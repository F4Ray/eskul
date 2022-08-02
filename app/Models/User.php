<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\Guru;
use App\Models\Siswa;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'id_profile',
        'id_role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var array<string, string>
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_profile');
    }
    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    // public function guru()
    // {
    //     return $this->hasOne(Guru::class, 'id', 'id_profile');
    // }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_profile');
    }

    public function isAdmin()
    {
        if($this->id_role === 1)
        { 
            return true; 
        } 
        else 
        { 
            return false; 
        }
    }
    public function hasRole()
    {
        if($this->id_role === 1)
        { 
            return true; 
        } 
        else 
        { 
            return false; 
        }
    }
}