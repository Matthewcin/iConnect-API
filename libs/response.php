<?php
class Response {
    public function send($message, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode(['message' => $message]);
    }
}