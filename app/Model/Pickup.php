<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Pickup extends Model
{
    protected $table = 'fs_pickup';

    protected $primaryKey = 'p_id';

    public  $timestamps = false;

}