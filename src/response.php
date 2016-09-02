<?php

    namespace check24\energy\partner\client;

    /**
     * Response
     *
     * @author Tobias Albrecht
     * @copyright CHECK24 Vergleichsportal Energie GmbH
     * @version 1.0
     */
    class response {
        
        private $status_code;
        private $header;
        private $cookies;
        private $data;

        /**
         * @var request
         */
        private $request;

        /**
         * Constructor
         *
         * @param request|NULL $request Current request (this is needed for sending cookies)
         */
        public function __construct(request $request = null) {

            if ($request === null) {
                $request = new request();
            }

            $this->request = $request;

        }

        /**
         * Set status code
         *
         * @param integer $code Code
         * @return void
         */
        public function set_status_code($code) {
            $this->status_code = $code;
        }

        /**
         * Set header
         *
         * @param array $header Header
         * @return void
         */
        public function set_header(array $header) {
            $this->header = $header;
        }

        /**
         * Set cookies
         *
         * @param array $cookies Cookies
         * @return void
         */
        public function set_cookies(array $cookies) {
            $this->cookies = $cookies;
        }

        /**
         * Set data
         *
         * @param string $data Data
         * @return void
         */
        public function set_data($data) {
            $this->data = $data;
        }

        /**
         * Sent header
         *
         * @return void
         */
        public function sent_header() {

            http_response_code($this->status_code);

            foreach ($this->header AS $name => $value) {
                header($name . ':' . $value);
            }

        }

        /**
         * Sent cookies with prefix
         *
         * @return void
         */
        public function sent_cookies() {

            foreach ($this->cookies as $cookie) {

                setcookie(
                    client::COOKIE_PREFIX . $cookie['name'],
                    $cookie['value'],
                    $cookie['expire'],
                    $cookie['path'],
                    $this->get_request()->get_http_host()
                );

            }

        }

        /**
         * Get data
         *
         * @return string
         */
        public function get_data() {
            return $this->data;
        }

        /**
         * Get http header from response
         *
         * @param string $key Header name
         * @return string|array|null
         */
        public function get_header($key) {

            if (!is_string($key)) {
                throw new \InvalidArgumentException('Invalid key "' . $key . '"');
            }

            if (isset($this->header[$key])) {
                return $this->header[$key];
            } else {
                return null;
            }

        }

        /**
         * Get client request
         *
         * @return request
         */
        public function get_request() {
            return $this->request;
        }

    }