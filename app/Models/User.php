<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\SanitizesInput;

class User extends Authenticatable implements MustVerifyEmail
{

    use SanitizesInput;
    use HasApiTokens, HasFactory, Notifiable;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'UserType',
        'SystemUser',
        'UserName',
        'Email',
        'PendingEmail',
        'Password',
        'AccountStatus',
        'AccountFirstLogin',
        'AccountSetupComplete',
        'ProfilePhotoPath',
        'HeaderPhotoPath',
        'ProfileData',
        'NeedsEmailPrompt',
        'UserCreatedDateTime',
        'UserActivatedDateTime'
    ];

    protected $hidden = [
        'Password',
        'RememberToken',
    ];

    protected $casts = [
        'AccountStatus' => 'integer',
        'ProfileData' => 'array',
        'UserType' => 'integer',
        'EmailVerifiedAt' => 'datetime',
        'UserCreatedDateTime' => 'datetime',
        'UserActivatedDateTime' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'ID'; // Your custom primary key
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->EmailVerifiedAt);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'EmailVerifiedAt' => now(),
        ])->save();
    }

    // public function getAuthIdentifierName()
    // {
    //     //return 'Email';         
    // }

    public function getEmailForVerification()
    {
        return $this->Email;
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getRememberTokenName()
    {
        return 'RememberToken';
    }

    public function getEmailForPasswordReset()
    {
        return $this->Email;
    }

    public function routeNotificationForMail()
    {
        return $this->Email;
    }

    // Since we are already handling sending reset links inside PasswordResetLinkController with
    // a custom URL, we dont need this at all
    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new CustomResetPassword($token));
    // }

    public function getProfilePhotoAttribute()
    {
        return $this->ProfilePhotoPath
            ? asset('storage/' . $this->ProfilePhotoPath)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->UserName) . '&color=7F9CF5&background=EBF4FF';
    }

    public function getHeaderPhotoAttribute()
    {
        return $this->HeaderPhotoPath
            ? asset('storage/' . $this->HeaderPhotoPath)
            : asset('images/default-header.jpg');
    }

    public function deviceHistories()
    {
        return $this->hasMany(SysDeviceDetailsHistory::class, 'UserID', 'ID');
    }

    public function sentEmails()
    {
        return $this->hasMany(SysSentAutoEmail::class, 'UserID', 'ID');
    }

    //renamed this was before attributes
    public function userAttributes()
    {
        return $this->hasOne(SysUserAttribute::class, 'UserID', 'ID');
    }

    public function type30()
    {
        return $this->hasOne(SysUserType30Attributes::class, 'UserID', 'ID');
    }
}
