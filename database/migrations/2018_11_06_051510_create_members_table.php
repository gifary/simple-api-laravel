<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->unsignedInteger('package_id');
            $table->string('full_name',255);
            $table->string('phone_number',16)->nullable();
            $table->mediumText('address')->nullable();
            $table->integer('age')->nullable();
            $table->string('identify_number')->nullable();
            $table->boolean('is_member_another_vcd_rental')->default(false);
            $table->enum('info_vcd_rental',['Friend','Newspaper','Broadside']);
            $table->boolean('is_active')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
