<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('geo_data', function (Blueprint $table) {
        $table->id();
        $table->foreignId('province_id')->constrained('provinces')->cascadeOnDelete();
        $table->foreignId('regency_id')->constrained('regencies')->cascadeOnDelete();

        $table->string('capital');
        $table->year('year');
        $table->unsignedBigInteger('population');
        $table->decimal('area', 10, 2);
        $table->decimal('density', 10, 2)->storedAs('population / area');
        $table->unsignedBigInteger('male_population');
        $table->unsignedBigInteger('female_population');
        $table->unsignedBigInteger('student');
        $table->decimal('student_distribution', 10, 2)->storedAs('student / area');
        $table->decimal('tpt', 10, 2)->nullable();

        $table->timestamps();
    });

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geo_data');
    }
};
