<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     * 是command的名字
     *
     * @var string
     */
    protected $signature = 'testconsole';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //这里是command要处理的业务。根据我们的需求，打印当前时间日期的业务代码需要写到这个位置
        Log::info('每分钟输出一次当前的日期时间到日志当中'.date('Y-m-d H:i:s'));
    }
}
