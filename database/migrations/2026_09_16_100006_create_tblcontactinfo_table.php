<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Blood Donation System — tblcontactinfo
     * FK blooddonor_id → tblblooddonors (nullable)
     * FK requirer_id → tblrequirer (nullable)
     * ERD shows 1:1 style links (one contact info row per donor/requirer as used).
     */
    public function up(): void
    {
        Schema::create('tblcontactinfo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blooddonor_id')
                ->nullable()
                ->constrained('tblblooddonors')
                ->nullOnDelete();
            $table->foreignId('requirer_id')
                ->nullable()
                ->constrained('tblrequirer')
                ->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_person')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblcontactinfo');
    }
};
