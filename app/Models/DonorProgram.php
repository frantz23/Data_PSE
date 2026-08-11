<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonorProgram extends Model
{
    //
    protected $table = 'donorprograms';

	public function donor()
	{

		return $this->belongsTo(\App\Models\Donor::class);

	}


	public function program()
	{

		return $this->belongsTo(\App\Models\Program::class);

	}


	protected $fillable = ['donor_id', 'program_id', 'amount_contributed'];
}
