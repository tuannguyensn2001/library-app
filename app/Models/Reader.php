<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static find(int $id)
 * @property mixed updated_by
 */
class Reader extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];


    public  function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%$value%");
    }

    public function books(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Book::class,'orders','reader_id','book_id')->withTimestamps()->withPivot('from','to','created_by','updated_by','quantity','is_done','done_at');
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }



}
