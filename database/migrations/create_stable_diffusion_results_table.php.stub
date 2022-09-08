<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stable_diffusion_results', function (Blueprint $table) {
            $table->id();
            $table->string('replicate_id')->unique();
            $table->string('user_prompt');
            $table->string('full_prompt');
            $table->string('url');
            $table->string('status', 30)->index();
            $table->json('output')->nullable();
            $table->mediumText('error')->nullable();
            $table->float('predict_time')->nullable();
            $table->timestamps();
        });
    }
};
