<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserModel;

class UserDetailModel extends Model
{
    use HasFactory;

    protected $table = 'user_detail';

    protected $fillable = [
        'nama_lengkap',
        'gender',
        'tgl_lahir',
        'alamat',
        'lokasi',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}


