<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('los', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // varchar
            $table->timestamps();

            // Optional tapi bagus: cegah duplikat LOS yang sama
            $table->unique('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('los');
    }
};
