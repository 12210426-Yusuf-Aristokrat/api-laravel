<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('level',['warga','petugas','admin'])->default('warga');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    // Set session options for remember_token in User model

    // Pastikan Anda telah mengganti nama model "User" jika nama model pengguna Anda berbeda

    // Cek apakah kolom "remember_token" ada di tabel pengguna


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

if(Schema::hasColumn('users', 'remember_token')) {
    // Ambil semua pengguna dari tabel
    $users = DB::table('users')->get();

    foreach ($users as $user) {
        // Set session token untuk setiap pengguna
        DB::table('users')->where('id', $user->id)->update(['remember_token' => User::generateToken()]);
    }
}
