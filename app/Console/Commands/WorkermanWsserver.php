<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Workerman\Worker;

class WorkermanWsserver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workerman:wsserver1 {action} {--daemonize}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'workerman wsserver';

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
        global $argv;
        $action = $this->argument('action');
        if(!in_array($action, ['start', 'stop', 'status'])){
            $this->error('Error Argument');exit;
        }
        $argv[0] = 'workerman:wsserver';
        $argv[1] = $action;
        $argv[2] = $this->option('daemonize') ? '-d' : '';

        $this->wsserver = new Worker("websocket://0.0.0.0:2346");
        $this->wsserver->name = 'wsserver';

        //启动两个进程对外提供服务
        $this->wsserver->count = 2;

        //服务端启动
        $this->wsserver->onWorkerStart = function($worker)
        {
            echo "Worker starting …… {$this->wsserver->id} \t {$this->wsserver->name} \n";
        };

        //客户端连接成功
        $this->wsserver->onConnect = function($connection)
        {
            echo "new connection from ip :" . $connection->getRemoteIp() . "\n";
        };

        //停止服务
        $this->wsserver->onWorkerStop = function($worker)
        {
            echo "Worker stopping …… \n";
        };

        //当有客户端发来消息时执行的回调函数
        $this->wsserver->onMessage = function($connection, $data)
        {
            var_dump($data);
            $connection->send($connection->id . "\t" . $data);
        };
        //运行所有的worker,执行后将永久阻塞
        Worker::runAll();
    }
}
