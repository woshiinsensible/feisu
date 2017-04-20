<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    protected $table = 'fs_users';

    protected $primaryKey = 'user_id';

    public  $timestamps = false;

}