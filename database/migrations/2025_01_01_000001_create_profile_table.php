<?php
// portfolio-api/database/migrations/2025_01_01_000001_create_profile_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('name',         120);
            $table->string('role',         120);
            $table->text('bio');
            $table->string('location',     120)->nullable();
            $table->string('email',        255);
            $table->string('phone',         30)->nullable();
            $table->string('linkedin_url', 500)->nullable();
            $table->string('github_url',   500)->nullable();
            $table->boolean('available')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('profile'); }
};
