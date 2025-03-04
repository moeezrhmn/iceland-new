<?php
    class Response {

        /**
         * @var array
         */
        protected $_reason_phrases = array(
            //Informational 1xx
            100 => "Continue",
            101 => "Switching Protocols",

            // Successful 2xx
            200 => "OK",
            201 => "Created",
            202 => "Accepted",
            203 => "Non-Authoritative Information",
            204 => "No Content",
            205 => "Reset Content",
            206 => "Partial Content",

            // Redirection 3xx
            300 => "Multiple Choices",
            301 => "Moved Permanently",
            302 => "Found",
            303 => "See Other",
            304 => "Not Modified",
            305 => "Use Proxy",
            306 => "(Unused)",
            307 => "Temporary Redirect",

            // Client Error 4xx
            400 => "Bad Request",
            401 => "Unauthorized",
            402 => "Payment Required",
            403 => "Forbidden",
            404 => "Not Found",
            405 => "Method Not Allowed",
            406 => "Not Acceptable",
            407 => "Proxy Authentication Required",
            408 => "Request Timeout",
            409 => "Conflict",
            410 => "Gone",
            411 => "Length Required",
            412 => "Precondition Failed",
            413 => "Request Entity Too Large",
            414 => "Request-URI Too Long",
            415 => "Unsupported Media Type",
            416 => "Requested Range Not Satisfiable",
            417 => "Expectation Failed",

            // Server Error 5xx
            500 => "Internal Server Error",
            501 => "Not Implemented",
            502 => "Bad Gateway",
            503 => "Service Unavailable",
            504 => "Gateway Timeout",
            505 => "HTTP Version Not Supported"
        );

        /**
         * @var integer
         */
        protected $_status_code;

        /**
         * @var string
         */
        protected $_body;

        /**
         * Constructor
         *
         * @param   string      $body
         */
        public function __construct($body) {

            $this->_body = $body;
        }

        /**
         * Constructor
         *
         * @param   string      $status_code
         */
        public function setStatusCode($status_code) {

            $this->_status_code = $status_code;
        }

        /**
         * Get status code
         *
         * @return  integer
         */
        public function getStatusCode() {

            return $this->_status_code;
        }

        /**
         * Get body
         *
         * @return  string
         */
        public function getBody() {

            return $this->_body;
        }

        /**
         * Get body JSON Decoded
         *
         * @return  object|null
         */
        public function getBodyDecoded() {

            return json_decode($this->_body);
        }

        /**
         * Get reason phrase
         *
         * @return string|boolean
         */
        public function getReasonPhrase() {

            if(array_key_exists($this->_status_code, $this->_reason_phrases)) {

                return $this->_reason_phrases[$this->_status_code];
            }
            else {

                return false;
            }
        }
    }


























