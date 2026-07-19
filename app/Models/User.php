<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id'
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

    
    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }

	public function programs()
	{
		
		return $this->hasMany(\App\Models\Program::class);
	
	}


	public function projects()
	{
		
		return $this->hasMany(\App\Models\Project::class);
	
	}


	public function activities()
	{
		return $this->hasMany(\App\Models\Activity::class);
	}


	public function indicators()
	{
		
		return $this->hasMany(\App\Models\Indicator::class);
	
	}


	public function indicatorvalues()
	{
		
		return $this->hasMany(\App\Models\IndicatorValue::class);
	
	}


	public function indicatorvaluefiles()
	{
		
		return $this->hasMany(\App\Models\IndicatorValueFile::class);
	
	}

}
