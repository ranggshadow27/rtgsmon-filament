<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_monitor', function (Blueprint $table) {
            $table->id();
            $table->string('terminal_id')->unique();
            $table->string('sitecode');
            $table->enum('modem', ['Up', 'Down']);
            $table->enum('mikrotik', ['Up', 'Down']);
            $table->enum('ap1', ['Up', 'Down']);
            $table->enum('ap2', ['Up', 'Down']);
            $table->timestamp('modem_last_up')->nullable();
            $table->timestamp('mikrotik_last_up')->nullable();
            $table->timestamp('ap1_last_up')->nullable();
            $table->timestamp('ap2_last_up')->nullable();
            $table->enum('status', ['Normal', 'Major', 'Critical']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_monitor');
    }
};
