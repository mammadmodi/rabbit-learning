<?php

namespace App\Console\Commands\Rabbit;

use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer extends Command
{
    /**
     * @var string
     */
    protected $signature = 'rabbit:consume {queue-name}';

    /**
     * @var string
     */
    protected $description = 'Consume to rabbitmq queue';

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
     * Consume queue
     *
     * @throws Exception
     */
    public function handle()
    {
        // Fetch args
        $queueName = $this->argument("queue-name");

        // Create connection and channel to interact with rabbit
        $connection = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);

        echo " [*] Waiting for messages from $queueName queue. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($queueName, '', false, false, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
