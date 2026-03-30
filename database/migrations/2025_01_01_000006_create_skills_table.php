<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suite_id')->constrained('skill_suites')->cascadeOnDelete();
            $table->string('name', 120);
            $table->unsignedTinyInteger('percentage');
            $table->string('tag', 10)->default('pass');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('skills'); }
};
