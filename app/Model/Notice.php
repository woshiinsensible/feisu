<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Notice extends Model
{
    protected $table = 'fs_notice';

    protected $primaryKey = 'no_id';

    public  $timestamps = false;

}