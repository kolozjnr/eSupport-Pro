<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Contracts\LaratrustUser;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements LaratrustUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'username',
        'email',
        'user_type',
        'password',
        'display_picture',
        'last_seen_at',
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
            'last_seen_at' => 'datetime',
        ];
    }

    
    public function customer() {
        return $this->hasOne(Customer::class);
    }
    public function support()
    {
        return $this->hasOne(Support::class);
    }
    public function qualityControl()
    {
        return $this->hasOne(QualityControl::class);
    }

    public function bussinesManager()
    {
        return $this->hasOne(BusinessManager::class);
    }

    public function bussinessSupervisor()
    {
        return $this->hasOne(BusinessSupervisor::class);
    }
    public function businessDeveloper()
    {
        return $this->hasOne(BusinessDeveloper::class);
    }

    public function customerManager()
    {
        return $this->hasOne(CustomerManager::class);
    }
    public function supervisor()
    {
        return $this->hasOne(Supervisor::class);
    }
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function review()
    {
        return $this->hasMany(Rating::class);
    }

    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }

    public function administrator()
    {
        return $this->hasOne(Admin::class);
    }

    public function conversations()
{
    return $this->belongsToMany(Conversation::class, 'conversation_participants')
                ->withPivot('joined_at', 'left_at', 'last_read_at')
                ->withTimestamps();
}

public function messages()
{
    return $this->hasMany(Message::class);
}

public function isOnline()
{
    // You can implement your online status logic here
    // For example, check if user was active in last 5 minutes
    return $this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(5));
}
 
    

    

    public function getCustomerId()
    {
        if ($this->customer) {
            return $this->customer->id;
        }
        
        return null;
    }

    public function getSupportId()
    {
        if ($this->support) {
            return $this->support->id;
        }
        
        return null;
    }

    public function getBusinessDeveloperId()
    {
        if ($this->businessDeveloper) {
            return $this->businessDeveloper->id;
        }
        
        return null;
    }
}
