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
        $table->string('province');
        $table->string('regency');
        $table->decimal('density', 10, 2);
        $table->decimal('area', 10, 2);
        $table->json('geojson_data');
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
