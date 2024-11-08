<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalkProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talk_proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('speaker_id');
            $table->string('title');
            $table->text('description');
            $table->string('file_path')->nullable();
            $table->timestamps();
        
            $table->foreign('speaker_id')->references('id')->on('speakers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talk_proposals');
    }
}
