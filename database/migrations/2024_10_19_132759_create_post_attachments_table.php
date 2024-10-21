<?php

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
        Schema::create('post_attachments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade'); // Foreign key to posts
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users
            $table->string('file_path'); // To store the path of the uploaded file
            $table->string('file_name'); // Optional: original file name
            $table->string('file_type'); // To store the MIME type of the file (e.g., image/jpeg)
            $table->unsignedBigInteger('file_size'); // Optional: to store the file size in bytes
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_attachments');
    }
};