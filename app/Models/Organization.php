<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	//

	protected $fillable = ['name', 'slug', 'description', 'email', 'phone', 'website', 'country', 'city', 'address', 'logo', 'primary_color', 'status'];


	public function users()
	{
		return $this->hasMany(\App\Models\User::class);
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

}
