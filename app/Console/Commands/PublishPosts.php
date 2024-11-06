<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class PublishPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To publish all unpublished posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Post::where("published",false)->update(['published'=>true]);
        $this->info("{$count} Posts published");
    }
}
