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


    protected $fillable = ['value_numeric', 'value_text', 'reporting_date', 'comment', 'indicator_id', 'organization_id', 'user_id', 'validated'];

    public function indicatorvaluefiles()
    {

        return $this->hasMany(\App\Models\IndicatorValueFile::class);
    }


	// public function indicatorvaluecomments()
	// {

	// 	return $this->hasMany(\App\Models\IndicatorValueComment::class);

	// }

    /**
     * Récupère uniquement les commentaires principaux (sans parent),
     * et charge directement leurs réponses pour optimiser les requêtes.
     */
    public function comments()
    {
        return $this->hasMany(IndicatorValueComment::class, 'indicator_value_id')
            ->whereNull('indicator_value_comment_id')
            ->with(['user', 'replies.user'])
            ->latest();
    }
}
