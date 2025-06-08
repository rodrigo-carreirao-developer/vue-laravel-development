<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeSearch(Builder $query, $search)
    {
        if (!$search) {
            return $query;
        }
        $likeStatement = $this->retrieveLikeStatement();
        return $query->where(function ($q) use ($search, $likeStatement) {
            $q->where('name', $likeStatement, "%{$search}%")
              ->orWhere('email', $likeStatement, "%{$search}%")
              ;
        });
    }
    public function scopeCreatedAt(Builder $query, $value)
    {
        if (!$value) {
            return $query;
        }
        return $query->whereDate('created_at',  $value)
              ;
    }
    public function scopeName(Builder $query, $value)
    {
        if (!$value) {
            return $query;
        }
        $likeStatement = $this->retrieveLikeStatement();

        return $query->where('name', $likeStatement, "%{$value}%")
              ;
    }
     public function scopeEmail(Builder $query, $value)
    {
        if (!$value) {
            return $query;
        }
        $likeStatement = $this->retrieveLikeStatement();

        return $query->where('email', $likeStatement, "%{$value}%")
              ;
    }
}
