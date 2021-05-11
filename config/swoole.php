<?php

use Swoole\Table;
use think\swoole\websocket\socketio\Handler;

return [
    'server'     => [
        // 默认配置为127.0.0.1 如果不需要用IP+端口访问得话可以不用改
        'host'      => env('SWOOLE_HOST', '0.0.0.0'), // 监听地址
        'port'      => env('SWOOLE_PORT', 9501), // 监听端口
        'mode'      => SWOOLE_PROCESS, // 运行模式 默认为SWOOLE_PROCESS
        'sock_type' => SWOOLE_SOCK_TCP, // sock type 默认为SWOOLE_SOCK_TCP
        'options'   => [
            // swoole进程得pid默认配置是在\runtime\swoole.pid
            'pid_file'              => runtime_path() . 'swoole.pid',
            // swoole运行得日志目录
            'log_file'              => runtime_path() . 'swoole.log',
            // 这个配置会影响swoole启动命令后是否进程守护,关闭命令行后还能继续运行
            'daemonize'             => false,//是否守护进程
            // Normally this value should be 1~4 times larger according to your cpu cores.
            'reactor_num'           => swoole_cpu_num(),
            'worker_num'            => swoole_cpu_num(),
            'task_worker_num'       => swoole_cpu_num(),
            'task_enable_coroutine' => true,
            'task_max_request'      => 2000,//设置 task 进程的最大任务数
            'enable_static_handler' => true,
            'document_root'         => root_path('public'),
            'package_max_length'    => 20 * 1024 * 1024,
            'buffer_output_size'    => 10 * 1024 * 1024,
            'socket_buffer_size'    => 128 * 1024 * 1024,
        ],
    ],
    //websocket配置区域
    'websocket'  => [
        //是否开启websocket
        'enable'        => false,
        //处理事件类名,这是是根据项目自行写得类,下面也会列出类中得方法和处理机制
        'handler'       => Handler::class,
        //解析类可直接使用TP6内置得类就可以了
        'ping_interval' => 25000,//ping频率
        'ping_timeout'  => 60000,//没有ping后退出毫秒数
        //下面是一些房间得配置这里会自动创建一个高性能内存数据库
        'room'          => [
            //房间类型 可切换为redis
            'type'  => 'table',
            'table' => [
                'room_rows'   => 4096,
                'room_size'   => 2048,
                'client_rows' => 8192,
                'client_size' => 2048,
            ],
            'redis' => [
                'host'          => '127.0.0.1',
                'port'          => 6379,
                'max_active'    => 3,
                'max_wait_time' => 5,
            ],
        ],
        //socket监听得事件也可以在这里配置,也可以在app\event.php内配置
        'listen'        => [],
        'subscribe'     => [],
    ],
    //远程过程调用，它是一种通过网络从远程计算机程序上请求服务，而不需要了解底层网络技术的思想
    //做微服务使用项目中没有使用就不过多说
    'rpc'        => [
        'server' => [
            'enable'   => false,
            'port'     => 9000,
            'services' => [
            ],
        ],
        'client' => [
        ],
    ],
    //热更新配置
    'hot_update' => [
        //是否开启热更新
        'enable'  => env('APP_DEBUG', false),
        //监听文件得类型 例如:*.html / *.js 都是可以得,但这个配置已经够用了不需要再调整
        'name'    => ['*.php'],
        //监听的目录 目前监听得目录有:app\ crmeb\ , root_path('crmeb')
        'include' => [app_path()],
        //排除的目录
        'exclude' => [],
    ],
    //连接池
    'pool'       => [
        //数据库连接池默认是开启的,在使用Db或者Model中不需要配置什么就自带连接池
        'db'    => [
            'enable'        => true,
            'max_active'    => 3,
            'max_wait_time' => 5,
        ],
        //缓存连接池 使用cache方式和之前一模一样没有任何的区别
        'cache' => [
            'enable'        => true,
            'max_active'    => 3,
            'max_wait_time' => 5,
        ],
        //自定义连接池
    ],
    'coroutine'  => [
        'enable' => true,
        'flags'  => SWOOLE_HOOK_ALL,
    ],
    //内存数据库 字段可自行创建 数据库会在swoole启动后自行创建
    'tables'     => [
        //高性能内存数据库
    ],
    //每个worker里需要预加载以共用的实例
    'concretes'  => [],
    //重置器
    'resetters'  => [],
    //每次请求前需要清空的实例
    'instances'  => [],
    //每次请求前需要重新执行的服务
    'services'   => [],
];
