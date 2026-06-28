<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // For MySQL
        DB::statement("ALTER TABLE enquiries MODIFY COLUMN status ENUM('new', 'contacted', 'interested', 'converted', 'closed') DEFAULT 'new'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE enquiries MODIFY COLUMN status ENUM('new', 'contacted', 'interested', 'converted') DEFAULT 'new'");
    }
};