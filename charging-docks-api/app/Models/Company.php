<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company';
    protected $fillable = ['name', 'parent_company_name','parent_company_id'];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
