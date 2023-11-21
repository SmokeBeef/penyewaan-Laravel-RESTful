<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyewaan extends Model
{
    use HasFactory;
    protected $table = "penyewaans";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, "pelanggan_id", "id");
    }
    public function penyewaan_detail(): HasMany
    {
        return $this->hasMany(Penyewaan_detail::class, "penyewaan_id", "id");
    }
}
