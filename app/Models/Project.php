<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
	public static function generateCode()
	{
		$lastProject = self::latest('id')->first();
		$nextNumber = $lastProject ? $lastProject->id + 1 : 1;

		return 'PRG-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
	}

	public function program()
	{
		
		return $this->belongsTo(\App\Models\Program::class);
	
	}


	public function organization()
	{
		
		return $this->belongsTo(\App\Models\Organization::class);
	
	}


	public function user()
	{
		
		return $this->belongsTo(\App\Models\User::class);
	
	}


	protected $fillable = ['name', 'code', 'description', 'budget', 'start_date', 'end_date', 'status', 'program_id', 'organization_id', 'user_id'];


	public function activities()
	{
		
		return $this->hasMany(\App\Models\Activity::class);
	
	}


	public function indicators()
	{
		
		return $this->hasMany(\App\Models\Indicator::class);
	
	}

}
