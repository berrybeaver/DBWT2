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
        Schema::create('ab_users', function (Blueprint $table) {
            $table->BigIncrements('id')->primary();
            $table->string('ab_name', 80)->nullable(false)->unique();
            $table->string('ab_password', 200)->nullable(false);
            $table->string('ab_mail', 200)->nullable(false)->unique();
        });
        Schema::create('ab_article', function (Blueprint $table) {
            $table->BigInteger('id')->unsigned()->primary();
            $table->string('ab_name', 80)->nullable(false);
            $table->integer('ab_price')->nullable(false);
            $table->string('ab_description', 1000)->nullable(false);
            $table->BigInteger('ab_creator_id')->unsigned()->nullable(false);
            $table->foreign('ab_creator_id')->references('id')->on('ab_users');
            $table->timestamp('ab_createdate')->nullable(false);
        });
        Schema::create('ab_articlecategory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ab_name', 100)->unique()->nullable(false);
            $table->string('ab_description', 1000)->nullable();
            $table->unsignedBigInteger('ab_parent')->nullable();
            $table->foreign('ab_parent')->references('id')
                ->on('ab_articlecategory')->onDelete('cascade');
        });
        Schema::create('ab_article_has_articlecategory', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('ab_articlecategory_id')->nullable(false);
            $table->unsignedBigInteger('ab_article_id')->nullable(false);
            $table->unique(['ab_articlecategory_id', 'ab_article_id']);
            $table->foreign('ab_articlecategory_id')->references('id')->on('ab_articlecategory');
            $table->foreign('ab_article_id')->references('id')->on('ab_article');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_article_has_articlecategory');
        Schema::dropIfExists('ab_articlecategory');
        Schema::dropIfExists('ab_article');
        Schema::dropIfExists('ab_users');
    }
};
