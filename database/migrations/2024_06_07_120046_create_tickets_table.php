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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // bigint primary key
            $table->string('subject', 255); // character varying (255)
            $table->bigInteger('customer_id'); // bigint
            $table->text('message'); // text
            $table->string('image', 255)->nullable(); // character varying (255), nullable
            $table->string('status', 255)->default('Pending'); // character varying (255), default value
            $table->bigInteger('technician_id')->nullable(); // bigint, nullable
            $table->timestamps(); // created_at and updated_at, timestamp without time zone
            $table->text('feedback_message')->nullable(); // text, nullable
            $table->bigInteger('feedback_rate')->nullable(); // bigint, nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
