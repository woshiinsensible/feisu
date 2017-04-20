<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class ProUser extends Model
{
    protected $table = 'fs_pro_users';

    protected $primaryKey = 'pro_id';

    public  $timestamps = false;

}