<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_revisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talk_proposal_id');
            $table->text('changed_fields');
            $table->timestamp('timestamp');
            $table->unsignedBigInteger('changed_by');
            $table->timestamps();
        
            $table->foreign('talk_proposal_id')->references('id')->on('talk_proposals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_revisions');
    }
}
