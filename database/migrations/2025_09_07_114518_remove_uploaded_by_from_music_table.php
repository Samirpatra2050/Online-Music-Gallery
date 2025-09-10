<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('music', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn('uploaded_by');
        });
    }

    public function down()
    {
        Schema::table('music', function (Blueprint $table) {
            $table->foreignId('uploaded_by')->constrained('users');
        });
    }
};
