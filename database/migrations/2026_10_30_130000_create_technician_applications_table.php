<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technician_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone', 20);
            $table->string('email');
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->text('address');
            $table->string('profile_photo')->nullable();
            $table->string('aadhar_number', 20)->nullable();
            $table->string('aadhar_document')->nullable();
            $table->string('pan_number', 20)->nullable();
            $table->string('pan_document')->nullable();
            $table->string('work_experience')->nullable();
            $table->json('work_categories')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technician_applications');
    }
};
