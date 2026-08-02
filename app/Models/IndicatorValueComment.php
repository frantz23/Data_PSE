<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorValueComment extends Model
{
    //
    // ⚠️ Indiquer le nom exact de la table générée par Espero-Soft
    protected $table = 'indicatorvaluecomments';

    public function indicatorvalue()
    {

        return $this->belongsTo(\App\Models\IndicatorValue::class,'indicator_value_id');
    }


    public function user()
    {

        return $this->belongsTo(\App\Models\User::class,'user_id');
    }


    public function parent()
    {

        return $this->belongsTo(\App\Models\IndicatorValueComment::class,'indicator_value_comment_id');
    }


    public function replies()
    {

        return $this->hasMany(\App\Models\IndicatorValueComment::class,'indicator_value_comment_id');
    }


    protected $fillable = ['indicator_value_id', 'user_id', 'content', 'indicator_value_comment_id'];
}
