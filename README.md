## Run a Rabbitmq server on ubuntu

You can run a rabbitmq server on your ubuntu with one of following ways:

#### 1) Run as sysmtemctl services

Because rabbitmq uses erlang/otp you should install erlang first:

Through this [link](https://computingforgeeks.com/how-to-install-latest-erlang-on-ubuntu-linux/) you can install erlang on your ubuntu.

After you installed erlang now you can install rabbitmq with following  [link](https://computingforgeeks.com/how-to-install-latest-rabbitmq-server-on-ubuntu-linux/) link.
You should follow only three first steps.

#### 2) Run with docker
With following command you will have a rabbitmq server that has admin api and amqp protocol with `5672` and `15672` ports.

`$ docker run --name="rabbitmq" -d -p 15672:15672 -p 5672:5672 rabbitmq:3.8-management-alpine`

## Interact with rabbitmq queues

### 1) Laravel
We have 2 basic produce and consume commands that is created with laravel's artisan console and they are defined in:
`app/Console/Commands/Rabbit` directory.

#### Publish
After running a rabbitmq server, now you can publish messages to server with this command:

` php artisan rabbit:publish {queue-name} {message-body}`

#### Consume
And also you can consume messages and see them with following command:

` php artisan rabbit:consume {queue-name}`

### 2) Terminal

You can interact with rabbitmq server with `rabbitmqadmin` command in terminal.

To have a basic interact with rabbtiqn first you must declare a queue with a name:  
`rabbitmqadmin declare queue name=sms durable=false`

and in the output you must see:  
`queue declared`

You can see list of queues with following command:  
`rabbitmqadmin list queues`

After you created queue now you can publish a message to your queue:    
`rabbitmqadmin publish routing_key=sms payload="hello, world"`

You can see list of messages that is published to queue:    
`rabbitmqadmin get queue=sms`
