<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorValue extends Model
{
    //

	public function indicator()
	{

		return $this->belongsTo(\App\Models\Indicator::class);

	}


	public function organization()
	{

		return $this->belongsTo(\App\Models\Organization::class);

	}


	public function user()
	{

		return $this->belongsTo(\App\Models\User::class);

	}


	protected $fillable = ['value_numeric', 'value_text', 'reporting_date', 'comment', 'indicator_id', 'organization_id', 'user_id'];

	public function indicatorvaluefiles()
	{

		return $this->hasMany(\App\Models\IndicatorValueFile::class);

	}

}
