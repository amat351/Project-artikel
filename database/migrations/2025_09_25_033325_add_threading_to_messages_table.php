<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('messages')->onDelete('cascade');  // Link ke pesan asli
            $table->enum('sender_type', ['user', 'admin'])->default('user');  // Bedakan pengirim
            $table->foreignId('sender_id')->nullable()->constrained('users')->onDelete('set null');  // ID user/admin
            $table->boolean('is_read')->default(false);  // Mark as read (optional untuk notif)
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['sender_id']);
            $table->dropColumn(['parent_id', 'sender_type', 'sender_id', 'is_read']);
        });
    }
};