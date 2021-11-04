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
            $table->increment(column:'id');

            $table->integer(column:'category_id')->unsigned();
            $table->integer(column:'user_id')->unsigned();

            $table->string(column:'slug')->unique();
            $table->string(column:'title');

            $table->text(column:'excerpt')->nullable();

            $table->text(column:'content_raw');
            $table->text(column:'content_html');

            $table->boolean(column:'is_published')->default(value:false);
            $table->timestamp(column:'published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign(columns:'user_id')->references('id')->on('users');
            $table->foreign(columns:'category_id')->references('id')->on('blog_categories');
            $table->index(columns:'is_published');
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
