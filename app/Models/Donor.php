<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    //

    /**
     * Les utilisateurs associés à ce bailleur (Représentants / Focal points)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Les programmes financés par ce bailleur
     */
    public function programs()
    {
        return $this->hasMany(Program::class,'donor_id');
    }

    // Force Laravel à traiter 'isActive' comme un booléen (0 ou 1 pour MySQL)
    protected $casts = [
        'isActive' => 'boolean',
    ];

	protected $fillable = ['code', 'name', 'type', 'email', 'phone', 'website', 'address', 'logo', 'isActive'];

	public function donorprograms()
	{

		return $this->hasMany(\App\Models\DonorProgram::class);

	}

    /**
 * Les programmes co-financés par ce bailleur
 */
public function Dprograms()
{
    return $this->belongsToMany(Program::class, 'donorprograms')
                ->withPivot('amount_contributed') // Optionnel si vous avez ce champ dans la table pivot
                ->withTimestamps();
}

}
