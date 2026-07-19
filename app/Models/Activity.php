<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
	//

	public function project()
	{

		return $this->belongsTo(\App\Models\Project::class);
	}



	public function organization()
	{

		return $this->belongsTo(\App\Models\Organization::class);
	}


	public function parent()
	{

		return $this->belongsTo(\App\Models\Activity::class, 'parent_activity_id');
	}


	public function children()
	{

		return $this->hasMany(\App\Models\Activity::class, 'parent_activity_id');
	}


	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function assignee()
	{
		return $this->belongsTo(\App\Models\User::class, 'assigned_to');
	}

	public function creator()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}

    public function indicators(): BelongsToMany
    {
        return $this->belongsToMany(Indicator::class);
    }

	protected $fillable = ['name', 'description', 'budget', 'start_date', 'end_date', 'status', 'completion_rate', 'project_id', 'organization_id', 'parent_activity_id', 'user_id', 'assigned_to'];
}
