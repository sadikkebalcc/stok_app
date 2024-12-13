<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\relations\BelongsTo;

class barangMasuk extends Model
{
    
    public function getStok(): Belongsto {
        return $this->belongsTo(stok::class, 'nama_barang_id', 'id');
    }
    public function getSuplier(): Belongsto {
        return $this->belongsTo(suplier::class, 'suplier_id', 'id');
    }
    public function getAdmin(): Belongsto {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
