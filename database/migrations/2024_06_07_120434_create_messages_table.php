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
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // bigint primary key
            $table->bigInteger('ticket_id'); // bigint
            $table->bigInteger('customer_id'); // bigint
            $table->bigInteger('technician_id'); // bigint
            $table->string('sender_type', 255); // character varying (255)
            $table->text('message')->nullable(); // text
            $table->string('image', 255)->nullable(); // character varying (255), nullable
            $table->timestamps(); // created_at and updated_at, timestamp without time zone
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
