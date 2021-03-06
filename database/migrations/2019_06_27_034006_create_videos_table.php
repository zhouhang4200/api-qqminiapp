<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->tinyInteger('status')->default(0)->comment('状态：0 不存在真实地址，1 已存在真实地址');
            $table->integer('category_id');
            $table->string('title')->comment('视频标题');
            $table->string('thumb')->comment('视频播放图片');
            $table->string('original_url', 500)->comment('视频链接地址');
            $table->string('url', 500)->comment('视频播放真实地址');
            $table->string('play_count')->comment('播放量');
            $table->string('play_time')->comment('播放时长');
            $table->tinyInteger('source_id')->default(0)->comment('来源');
            $table->string('source_name')->default('')->comment('来源名');
            $table->integer('sort')->default(999)->comment('随机排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
