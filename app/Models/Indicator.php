<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Indicator extends Model
{
    //
    protected function progress(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->target > 0
                ? min(100, round(($this->current_value / $this->target) * 100))
                : 0
        );
    }

    public static function generateCode()
	{
		$lastProject = self::latest('id')->first();
		$nextNumber = $lastProject ? $lastProject->id + 1 : 1;

		return 'IND-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
	}

	public function organization()
	{

		return $this->belongsTo(\App\Models\Organization::class);

	}


	public function project()
	{

		return $this->belongsTo(\App\Models\Project::class);

	}


	public function user()
	{

		return $this->belongsTo(\App\Models\User::class);

	}

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }

	protected $fillable = ['name', 'code', 'description', 'result_level', 'data_type', 'unit', 'baseline', 'target', 'current_value', 'frequency', 'status', 'organization_id', 'project_id', 'user_id'];

	public function indicatorvalues()
	{
		
		return $this->hasMany(\App\Models\IndicatorValue::class);
	
	}

}
