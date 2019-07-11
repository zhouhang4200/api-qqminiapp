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
    protected $signature = 'delete:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除2天前过期视频';

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
            $date = Carbon::now()->subDays(2)->toDateString();

            Video::where('date', '<', $date)->delete();
        } catch (\Exception $e) {
            myLog('delete_video_error', ['data' => $e->getLine().'行：'.$e->getMessage()]);
        }
    }
}
