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
        Schema::create('posts', function (Blueprint $table) {
            // INSERT INTO blog_database.migrations (migration, batch) VALUES ('2023_12_27_130545_add_is_admin_to_users_table', 1);
            $table->id();
            $table->string('title', 100); // Limited to 100 characters
            $table->string('slug', 100); // Limited to 100 characters
            $table->text('excerpt')->nullable();
            $table->longText('content'); // For Markdown content
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('published_at')->nullable();
            $table->boolean('status')->default(0); // 0 for unpublished, 1 for published
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
