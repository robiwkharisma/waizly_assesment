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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');

            $table->string('nik',12);
            $table->string('first_name',100);
            $table->string('middle_name',100)->nullable();
            $table->string('last_name',100)->nullable();
            $table->enum('gender',['L','P']);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->dropColumn('is_active');
            $table->dropColumn('gender');
            $table->dropColumn('last_name');
            $table->dropColumn('middle_name');
            $table->dropColumn('first_name');
            $table->dropColumn('nik');

            $table->string('name');
        });
    }
};
