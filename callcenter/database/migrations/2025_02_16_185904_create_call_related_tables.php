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
        Schema::create('index', function (Blueprint $table) {
            $table->id();
            $table->string('caller_number');
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['queued', 'in-progress', 'completed', 'missed'])->default('queued');
            $table->enum('call_type', ['incoming', 'outgoing'])->default('incoming');
            $table->string('recording_url')->nullable();
            $table->text('notes')->nullable();
            $table->integer('duration')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('priority')->default('normal');
            $table->string('category')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Call Notes Table
        Schema::create('call_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('call_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        // Call Recordings Table
        Schema::create('call_recordings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('call_id')->constrained()->onDelete('cascade');
            $table->string('url');
            $table->integer('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_recordings');
        Schema::dropIfExists('call_notes');
        Schema::dropIfExists('index');
    }
};
