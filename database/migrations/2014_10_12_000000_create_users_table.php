<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('role')->default('user');
            $table->string('profile_image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Inserting a default admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com', // Replace with your desired email
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('12345678'), // Hash the password for security
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('role')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::dropIfExists('users');
    // }

    //     public function up()
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         $table->string('role')->nullable();
    //     });
    // }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
