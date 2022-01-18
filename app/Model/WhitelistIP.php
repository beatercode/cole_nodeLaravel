<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WhitelistIP extends Model
{
    protected $table = 'whitelist_ip';

    protected $guarded = [];
}
