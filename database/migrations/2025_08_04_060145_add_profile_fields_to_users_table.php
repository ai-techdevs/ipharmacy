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
            //$table->string('first_name')->after('name')->nullable();
            $table->string('last_name')->after('name')->nullable();
            $table->string('mobile')->after('email')->nullable();
            $table->string('age_group')->after('mobile')->nullable();
            $table->enum('gender', ['male', 'female', 'others'])->after('age_group')->nullable();
            $table->text('address1')->after('gender')->nullable();
            $table->text('address2')->after('address1')->nullable();
            $table->string('city')->after('address2')->nullable();
            $table->string('state')->after('city')->nullable();
            $table->string('zip')->after('state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn([
                // 'first_name',
                'last_name',
                'mobile',
                'age_group',
                'gender',
                'address1',
                'address2',
                'city',
                'state',
                'zip',
            ]);
        });
    }
};
