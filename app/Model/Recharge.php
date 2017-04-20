<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Recharge extends Model
{
    protected $table = 'fs_recharge';

    protected $primaryKey = 'rec_id';

    public  $timestamps = false;

}