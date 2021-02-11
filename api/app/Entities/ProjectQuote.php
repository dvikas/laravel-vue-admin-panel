<?php

namespace App\Entities;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;

class ProjectQuote extends Model
{
    use UuidScopeTrait;
    protected $guarded = ['id'];
}
