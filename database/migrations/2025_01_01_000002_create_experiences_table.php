<?php
// portfolio-api/database/migrations/2025_01_01_000002_create_experiences_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('issue_key',    20);
            $table->string('title',       300);
            $table->string('sub_location',300)->nullable();
            $table->string('status',       20);
            $table->string('type',         50);
            $table->string('date_range',  100);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('experiences'); }
};
