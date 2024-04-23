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
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');   // 當使用者被刪除時，刪除該使用者的所有文章
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->string('excerpt')->nullable();
            $table->text('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedTinyInteger('priority')->nullable();
            $table->boolean('is_published');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
