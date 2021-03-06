<?php

namespace App\Console\Commands;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteVideoOverDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qq:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除6小时前过期视频';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $time = Carbon::now()->subHours(5)->subMinutes(40)->toDateTimeString();

            Video::where('updated_at', '<', $time)->delete();
        } catch (\Exception $e) {
            myLog('delete_video_error', ['data' => $e->getLine().'行：'.$e->getMessage()]);
        }
    }
}
