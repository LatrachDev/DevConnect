<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Connection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'bio',
        'github_url',
        'linkedin_url',
        'website_url',
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class, 'sender_id');
    }

    public function receivedConnections()
    {
        return $this->hasMany(Connection::class, 'receiver_id');
    }

    public function sentConnections()
    {
        return $this->hasMany(Connection::class, 'sender_id');
    }

    public function getAllConnections()
    {
        return Connection::where('sender_id', $this->id)
            ->orWhere('receiver_id', $this->id)
            ->where('status', 'accepted');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array',
    ];

    public function getSkillsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function isConnectedWith(User $user)
    {
        return Connection::where(function($query) use ($user) {
                $query->where(function($q) use ($user) {
                    $q->where('sender_id', $this->id)
                      ->where('receiver_id', $user->id);
                })->orWhere(function($q) use ($user) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $this->id);
                });
            })
            ->where('status', 'accepted')
            ->exists();
    }

    public function hasPendingConnectionWith(User $user)
    {
        return Connection::where(function($query) use ($user) {
                $query->where(function($q) use ($user) {
                    $q->where('sender_id', $this->id)
                      ->where('receiver_id', $user->id);
                })->orWhere(function($q) use ($user) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $this->id);
                });
            })
            ->where('status', 'pending')
            ->exists();
    }

    public function getConnectionWith(User $user)
    {
        return Connection::where(function($query) use ($user) {
                $query->where(function($q) use ($user) {
                    $q->where('sender_id', $this->id)
                      ->where('receiver_id', $user->id);
                })->orWhere(function($q) use ($user) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $this->id);
                });
            })
            ->first();
    }
}
