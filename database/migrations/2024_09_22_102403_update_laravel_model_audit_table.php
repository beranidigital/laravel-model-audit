<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('audit_trails', function (Blueprint $table) {
            $table->string('auditable_id')->nullable()->change();
            $table->string('author_id')->nullable()->change();
        });
    }

    public function down()
    {
    }
};
