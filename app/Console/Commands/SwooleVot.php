<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kcloze\Bot\Console;

class SwooleVot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:vot';

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
        //
        $path = __DIR__ . '/tmp/';
        $config = [
            'path'     => $path,
            /*
             * swoole 配置项
             */
            'swoole'  => [
                //默认允许几个机器人登录
                'workNum'=> 1,
            ],
            /*
             * 下载配置项
             */
            'download' => [
                'image'         => true,
                'voice'         => true,
                'video'         => true,
                'emoticon'      => true,
                'file'          => true,
                'emoticon_path' => $path . 'emoticons', // 表情库路径（PS：表情库为过滤后不重复的表情文件夹）
            ],
            /*
             * 输出配置项
             */
            'console' => [
                'output'  => true, // 是否输出
                'message' => true, // 是否输出接收消息 （若上面为 false 此处无效）
            ],
            /*
             * 日志配置项
             */
            'log'      => [
                'level'         => 'debug',
                'permission'    => 0777,
                'system'        => $path . 'log', // 系统报错日志
                'message'       => $path . 'log', // 消息日志
            ],
            /*
             * 缓存配置项
             */
            'cache' => [
                'default' => 'file', // 缓存设置 （支持 redis 或 file）
                'stores'  => [
                    'file' => [
                        'driver' => 'file',
                        'path'   => $path . 'cache',
                    ],
                    'redis' => [
                        'driver'     => 'redis',
                        'connection' => 'default',
                    ],
                ],
            ],
            /*
             * 拓展配置
             * ==============================
             * 如果加载拓展则必须加载此配置项
             */
            'extension' => [
                // 管理员配置（必选），优先加载 remark_name
                'admin' => [
                    'remark'   => '',
                    'nickname' => '',
                ],
            ],
            'params'=> [
                'tulingApi'=> 'http://www.tuling123.com/openapi/api',
                'tulingKey'=> '',
            ],

        ];
        $console = new Kcloze\Bot\Console($config);
        $console->run();
    }
}
