<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Recode extends Model
{
    protected $table = 'recode';

    protected $primaryKey = 'r_id';

    public  $timestamps = false;

}