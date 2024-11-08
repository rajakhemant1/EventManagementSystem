<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisionsTable extends Migration
{
    public function up()
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();
            $table->morphs('revisable'); // For polymorphic relations (e.g., Speaker or TalkProposal)
            $table->json('changes'); // Store changes in JSON format
            $table->unsignedBigInteger('user_id')->nullable(); // ID of the user who made the change
            $table->timestamp('created_at'); // Timestamp of the change
        });
    }

    public function down()
    {
        Schema::dropIfExists('revisions');
    }
}
