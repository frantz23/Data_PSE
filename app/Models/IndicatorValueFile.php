<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorValueFile extends Model
{
    //

	public function user()
	{

		return $this->belongsTo(\App\Models\User::class,'user_id');

	}


	public function indicatorvalue()
	{

		return $this->belongsTo(\App\Models\IndicatorValue::class,'indicator_value_id');

	}


	protected $fillable = ['file_name', 'file_path', 'mime_type', 'file_size', 'user_id', 'indicator_value_id'];
}
