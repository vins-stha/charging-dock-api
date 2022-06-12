<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Station';
    protected $fillable=['name','address','latitude','longitude','parent_company_name', 'company_id'];

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
