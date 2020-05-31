<?php

namespace App\Console\Commands\Rabbit;

use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Producer extends Command
{
    /**
     * @var string
     */
    protected $signature = 'rabbit:publish {queue-name} {message}';

    /**
     * @var string
     */
    protected $description = 'Produce a message to a queue';

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
     * Send message to queue
     *
     * @throws Exception
     */
    public function handle()
    {
        // Fetch args
        $queueName = $this->argument("queue-name");
        $messageBody = $this->argument('message');

        // Create connection and channel to interact with rabbit
        $connection = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);

        $msg = new AMQPMessage(
            $messageBody,
            array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );

        $channel->basic_publish($msg, '', $queueName);

        echo ' [x] Sent ', $messageBody, " to ", $queueName, " queue \n";

        $channel->close();
        $connection->close();
    }
}
