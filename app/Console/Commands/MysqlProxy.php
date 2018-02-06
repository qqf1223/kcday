<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Workerman\Connection\AsyncTcpConnection;
use Workerman\Worker;

class MysqlProxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workerman:mysqlproxy {action} {--daemonize}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'workerman mysqlproxy';

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
        if(!in_array($action, ['start', 'stop'])){
            $this->error('Error Argument');exit;
        }
        $argv[0] = 'workerman:wsserver';
        $argv[1] = $action;
        $argv[2] = $this->option('daemonize') ? '-d' : '';


        //
        $REAL_MYSQL_ADDRESS = 'tcp://127.0.0.1:3306';

        $proxy = new Worker('tcp://0.0.0.0:4406');

        $proxy->onConnect = function($connection) use ($REAL_MYSQL_ADDRESS){
            //异步建立一个到Mysql服务器的连接
            $connection_to_mysql = new AsyncTcpConnection($REAL_MYSQL_ADDRESS);
            //msyql连接发来数据时,转发给对应的客户端连接
            $connection_to_mysql->onMessage = function ($connection_to_mysql, $buffer) use ($connection) {
                echo "connection_to_mysql->onMessage \n";
                $connection->send($buffer);
            };

            //msyql关闭时,关闭对应的代理到客户端的连接
            $connection_to_mysql->onClose = function ($connection_to_mysql) use ($connection)
            {
                echo "connection->close(1);\n";
                $connection->close();
            };
            //
            $connection_to_mysql->onError = function ($connection_to_mysql) use ($connection)
            {
                echo "connection->close(2); \n ";
                $connection->close();
            };

            //执行异步连接
            $connection_to_mysql->connect();

            //客户端发来数据时,转发给对应的数据库连接
            $connection->onMessage = function($connection, $buffer) use ($connection_to_mysql)
            {
                echo "connection_to_mysql->send \n";
                $connection_to_mysql->send($buffer);
            };

            //客户端断开连接时,断开对应的Mysql连接
            $connection->onClose = function($connection) use ($connection_to_mysql)
            {
                echo "connection_to_mysql->close\n";
                $connection_to_mysql->close();
            };
        };
        Worker::runAll();
    }
}
