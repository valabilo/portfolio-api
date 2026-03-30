<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('skill_suites', function (Blueprint $table) {
            $table->id();
            $table->string('suite_key',  30);
            $table->string('label',     150);
            $table->string('count_text', 80)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('skill_suites'); }
};
