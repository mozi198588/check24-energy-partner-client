<?php

    namespace check24\energy\partner\client;

    /**
     * Request wrapper class
     *
     * @author Tobias Albrecht
     * @copyright CHECK24 Vergleichsportal Energie GmbH
     * @version 1.0
     */
    class request {

        /**
         * Get additional sent x-header for json requests and format them well
         *
         * @return array
         */
        public function get_additional_x_header() {

            $additional_header = [];

            foreach ($_SERVER AS $field => $value) {

                if (substr($field, 0, 6) == 'HTTP_X' || substr($field, 0, 6) == 'HTTP-X') {

                    if (is_array($value)) {

                        foreach ($value AS $sub_field => $sub_value) {
                            $additional_header[] = str_replace('_', '-', substr($field, 5)) . '[' . $sub_field . ']: ' . $sub_value;
                        }

                    } else {
                        $additional_header[] = str_replace('_', '-', substr($field, 5)) . ': ' . $value;
                    }

                }

            }

            return $additional_header;

        }

        /**
         * Get server name
         *
         * @return string
         */
        public function get_server_name() {
            return $_SERVER['SERVER_NAME'];
        }

        /**
         * Get http clean host
         *
         * @return string
         */
        public function get_http_host() {

            $http_host = $_SERVER['HTTP_HOST'];

            // remove port

            if (strpos($http_host, ':') !== false) {
                $http_host = substr($http_host, 0, strpos($http_host, ':'));
            }

            return $http_host;

        }

        /**
         * Get current request method
         *
         * @return string
         */
        public function get_request_method() {
            return $_SERVER['REQUEST_METHOD'];
        }


        /**
         * Get client ip
         *
         * @return string
         */
        public function get_client_ip() {
            return $_SERVER['REMOTE_ADDR'];
        }

        /**
         * Get user agent
         *
         * @return string
         */
        public function get_user_agent() {
            return $_SERVER['HTTP_USER_AGENT'];
        }
        
        /**
         * Get cookies
         *
         * @return array
         */
        public function get_cookies() {
            return $_COOKIE;
        }

    }