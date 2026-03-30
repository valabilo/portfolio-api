<?php
// portfolio-api/database/migrations/2025_01_01_000012_create_awards_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('title',  250);           // "Top 1 · KodeGo Best Capstone Award"
            $table->string('issuer', 150)->nullable();
            $table->string('year',    20)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('awards'); }
};
