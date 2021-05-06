<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static find(int $id)
 */
class Reader extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
}
