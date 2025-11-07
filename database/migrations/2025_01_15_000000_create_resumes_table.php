<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('title');
            $table->string('location');
            $table->text('about');
            $table->string('contact_number');
            $table->string('contact_email');
            $table->json('tech_stack')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('projects')->nullable();
            $table->string('github_url')->nullable();
            $table->string('resume_pdf_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};

