<?php
declare(strict_types=1);

namespace app\application\worker;

use GatewayWorker\Lib\Gateway;
use think\Request;
use Workerman\Lib\Timer;
use think\worker\Server;

class Worker extends Server
{
    protected $socket = 'websocket://0.0.0.0:2347';

    public function __construct()
    {
        parent::__construct();
        $this->onWorkerStart();

    }

    public function onWorkerStart()
    {

        $this->add_timer();
    }
    public function add_timer(){
        #设置每60秒执行一次定时任务
        /**
         *前端启动方式：
        // 假设服务端ip为127.0.0.1
        ws = new WebSocket("ws://127.0.0.1:2347");
        ws.onopen = function() {
        alert("连接成功");
        };
        ws.onmessage = function(e) {
        alert("收到服务端的消息：" + e.data);
        };
         */
        Timer::add(120, array($this, 'index'), array(), true);
    }
    /**
     * @param $connection
     * @param $data 142842567084ds
     */
    public function onMessage($client_id,$message)
    {

//        $message = [
//            'application_ids.require' => '应用类型必须选定',
//            'upgrade_start.require' => '升级开始时间不能为空',
//            'upgrade_start.dateFormat' => '时间格式不正确',
//            'upgrade_end.dateFormat' => '时间格式不正确',
//            'upgrade_end.gt' => '结束时间必须大于开始时间',
//            'upgrade_end.require' => '升级结束时间不能为空',
//            'tips.require' => '升级备注不能为空',
//            'users_ids.require' => '请选择升级用户或类型',
//            'close_type.require' => '必须选择关闭某个端',
//        ];
//        $connection->send(json_encode($message));
        $message=json_decode($message,true);
        if(!$message)
        {
            return;
        }
        switch ($message['type']) {
            case "bind":
                Gateway::bindUid($client_id,$message['fid']);
                break;
            case "text":
                $date=[
                    "type"=>"text",
                    "fid"=>$message['fid'],
                    "tid"=>$message['tid'],
                    "data"=>nl2br(htmlspecialchars($message['data'])),
                    "time"=>time()
                ];
                Gateway::sendToUid($message['tid'],json_encode($date));
                break;
            default:
                Gateway::sendToAll("21211");
                break;
        }


    }


    public function onConnect($client_id){
        Gateway::sendToClient($client_id,
            json_encode(
                ["type"=>"init",
                    "client_id"=>$client_id])
        );
    }




    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        file_put_contents('a.log',date('Y-m-d H:i:s',time()).'执行了一次定时任务。'.PHP_EOL,FILE_APPEND);
//        $to = "2335253436@qq.com";         // 邮件接收者
//        $subject = "参数邮件";                // 邮件标题
//        $message = "Hello! 这是邮件的内容。";  // 邮件正文
//        $from = "396671526@qq.com";   // 邮件发送者
//        $headers = "From:" . $from;         // 头部信息设置
//        mail($to,$subject,$message,$headers);




        echo "执行任务";
        //每天0点执行任务
        if(time()/86400 === 0){
            echo date("Y-m-d H:i:s");
            echo "每天0点执行任务";
        }
        //每天8点执行任务
        if(time()/86400 === 39600){
            echo date("Y-m-d H:i:s");
            echo "每天8点执行任务";
        }
//        return view();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
