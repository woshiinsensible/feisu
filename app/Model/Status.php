<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Status extends Model
{
    protected $table = 'fs_status';

    protected $primaryKey = 'g_id';

    public  $timestamps = false;

}