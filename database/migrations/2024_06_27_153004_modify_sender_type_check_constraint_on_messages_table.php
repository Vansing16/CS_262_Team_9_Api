<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifySenderTypeCheckConstraintOnMessagesTable extends Migration
{
    public function up()
    {
        // Drop the existing check constraint if it exists
        DB::statement("ALTER TABLE messages DROP CONSTRAINT IF EXISTS messages_sender_type_check");

        // Add the new check constraint to allow 'customer' and 'technician'
        DB::statement("ALTER TABLE messages ADD CONSTRAINT messages_sender_type_check CHECK (sender_type IN ('customer', 'technician'))");
    }

    public function down()
    {
        // Drop the new check constraint
        DB::statement("ALTER TABLE messages DROP CONSTRAINT messages_sender_type_check");

        // Re-add the original check constraint (assuming it only allowed 'customer')
        DB::statement("ALTER TABLE messages ADD CONSTRAINT messages_sender_type_check CHECK (sender_type IN ('customer'))");
    }
}
