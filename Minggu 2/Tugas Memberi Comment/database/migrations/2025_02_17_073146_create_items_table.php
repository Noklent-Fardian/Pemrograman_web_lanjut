<?php
// Commitan setelah dipindahkan
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) { // membuat tables dengan nama items
            $table->id(); // membuat kolom id
            $table->string('name'); // membuat kolom name
            $table->text('description'); // membuat kolom description
            $table->timestamps(); // membuat kolom timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};