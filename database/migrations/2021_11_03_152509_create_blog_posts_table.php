<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->bigIncrements('id');


            $table->bigInteger('category_id');
            $table->bigInteger('user_id')->unsigned()->nullable();


            $table->string('slug')->unique();
            $table->string('title');


            $table->text('excerpt')->nullable();


            $table->text('content_raw');
            $table->text('content_html');


            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();


            $table->timestamps();
            $table->softDeletes();


            $table->index('is_published');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}
