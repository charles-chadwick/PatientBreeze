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
        Schema::create('discussions_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discussion_id');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->index(['discussion_id', 'user_id']);
            $table->dateTime('last_seen_at')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('deleted_at')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions_users');
    }
};
