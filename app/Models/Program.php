<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
	//
	public static function generateCode()
	{
		$lastProgram = self::latest('id')->first();
		$nextNumber = $lastProgram ? $lastProgram->id + 1 : 1;

		return 'PRG-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
	}

	public function organization()
	{

		return $this->belongsTo(\App\Models\Organization::class);
	}


	protected $fillable = ['name', 'code', 'description', 'budget', 'donor', 'currency', 'funding_partner', 'start_date', 'end_date', 'status', 'organization_id', 'user_id'];

	public function user()
	{

		return $this->belongsTo(\App\Models\User::class);
	}

	public function projects()
	{
		
		return $this->hasMany(\App\Models\Project::class);
	
	}

}
