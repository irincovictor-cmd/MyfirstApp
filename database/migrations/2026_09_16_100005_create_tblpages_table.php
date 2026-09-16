<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Blood Donation System — tblpages
     * FK admin_id → tbladmin (1:M)
     */
    public function up(): void
    {
        Schema::create('tblpages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')
                ->constrained('tbladmin')
                ->onDelete('cascade');
            $table->string('page_title');
            $table->string('page_slug')->unique();
            $table->longText('page_content')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblpages');
    }
};
