<?php

    class ApiResponse {
        private $statusCode;
        private $status;
        private $data;
        private $message;

        public function __construct($statusCode, $status, $message = null, $data = null) {
            $this->statusCode = $statusCode;
            $this->status = $status;
            $this->message = $message;
            $this->data = $data;
        }

        public function getStatusCode() {
            return $this->statusCode;
        }

        public function getData() {
            return $this->data;
        }

        public function getMessage() {
            return $this->message;
        }

        public function toJson() {
            http_response_code($this->statusCode); 
            header('Content-Type: application/json');

            return json_encode(array(
                'status' => $this->status,
                'message' => $this->message,
                'data' => $this->data,
            ));
        }
    }


?>