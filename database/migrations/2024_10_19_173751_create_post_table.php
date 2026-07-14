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
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Program_id'); // It is recommended to use unsignedBigInteger for foreign keys
            $table->integer('subProgram');
            $table->string('name');
            $table->string('slug')->unique();
            $table->mediumText('description');
            $table->string('postType')->default('note');
            $table->string('yt_iframe')->nullable();
            $table->string('meta_title');
            $table->mediumText('meta_description')->nullable();
            $table->mediumText('meta_keyword')->nullable();
            $table->tinyInteger('hideStatus')->default('0');
            $table->boolean('is_deleted')->default('0');

            // Defining created_by as a foreign key that references users.id
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
