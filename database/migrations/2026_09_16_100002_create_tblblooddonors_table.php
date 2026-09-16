<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Blood Donation System — tblblooddonors
     * FK admin_id → tbladmin (1:M)
     */
    public function up(): void
    {
        Schema::create('tblblooddonors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')
                ->constrained('tbladmin')
                ->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('blood_type', 10);
            $table->date('birth_date')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('status', 50)->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblblooddonors');
    }
};
