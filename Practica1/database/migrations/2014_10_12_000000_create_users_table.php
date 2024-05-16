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
            $table->string('lastname_p');
            $table->string('lastname_m');
            $table->integer('age');
            $table->date('birthdate');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            #$table->timestamp('email_verified_at')->nullable(); //por ver
            $table->string('password');
            $table->boolean('active')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
