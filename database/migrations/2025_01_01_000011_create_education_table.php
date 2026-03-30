<?php
// portfolio-api/database/migrations/2025_01_01_000011_create_education_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('type',        20)->default('degree'); // degree | certification | training
            $table->string('title',      200);   // "BS Computer Engineering"
            $table->string('institution',200);   // "ICCT Colleges Inc."
            $table->string('year',        20)->nullable(); // "2013" or "2022–2023"
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('education'); }
};
