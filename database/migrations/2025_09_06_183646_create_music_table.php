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
    Schema::create('music', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('artist');
        $table->string('album')->nullable();
        $table->string('genre')->nullable();
        $table->integer('duration')->nullable(); // in seconds
        $table->string('file_path');
        $table->string('cover_image')->nullable();
        $table->text('description')->nullable();
        $table->date('release_date')->nullable();
        $table->boolean('is_featured')->default(false);
        $table->boolean('is_active')->default(true);
        $table->integer('play_count')->default(0);
        $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music');
    }
};
