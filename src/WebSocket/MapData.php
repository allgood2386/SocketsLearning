<?php

namespace D3Sockets;

use Ratchet\Wamp\WampServerInterface;
use Ratchet\ConnectionInterface;

/**
 * MapData.php
 * Send any incoming messages to all connected clients (except sender)
 */
class MapData implements WampServerInterface {
  private $topics;
  private $interfaceDevice;
  
  public function __construct(DeviceInterface $deviceInterface) {
    $this->interfaceDevice = $deviceInterface;
  }

  /**
   * A lookup of all the topics clients have subscribed to
   */
  protected $subscribedTopics = array();

  public function onSubscribe(ConnectionInterface $conn, $topic) {
    $this->subscribedTopics[$topic->getId()] = $topic;
  }

  /**
   * Checks if channel is populated and broadcasts message if so.
   *
   * @param data
   *   A JSON string
   */
  public function onUpdate($data) {
    $data = new Map($data);


    if (!array_key_exists($data['channel'], $this->subscribedTopics)) {
      return;
    }

    $topic = $this->subscribedTopics[$data['channel']];
    
    $topic->broadcast($data);
  }

  public function onUnSubscribe(ConnectionInterface $conn, $topic) {
  }
  public function onOpen(ConnectionInterface $conn) {
  }
  public function onClose(ConnectionInterface $conn) {
  }
  public function onCall(ConnectionInterface $conn, $id, $topic, array $params) {
    // In this application if clients send data it's because the user hacked around in console
    $conn->close();
  }
  public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible) {
    // In this application if clients send data it's because the user hacked around in console
    $conn->close();
  }
  public function onError(ConnectionInterface $conn, \Exception $e) {
  }
}