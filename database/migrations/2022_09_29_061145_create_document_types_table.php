<?php

use App\Models\DocumentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('definition');
            $table->timestamps();
        });

        DocumentType::create(['definition' => 'Drivers License']);
        DocumentType::create(['definition' => 'SS Card']);
        DocumentType::create(['definition' => 'Nursing License']);
        DocumentType::create(['definition' => 'Shot Record']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_types');
    }
};
