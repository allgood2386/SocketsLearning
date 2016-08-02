<?php
// post.php ???
// This all was here before  ;)

// This is our new stuff
$context = new ZMQContext();
$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
$socket->connect("tcp://localhost:5555");

for ($i = 0; $i < 100000; $i++ ) {
  $entryData = array(
    'channel' => 'updates',
    'title'    => 'title' . $i,
    'article'  => 'artile',
    'when'     => time()
  );

  $socket->send(json_encode($entryData));
}
