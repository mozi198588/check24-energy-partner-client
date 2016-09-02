<?php

    namespace check24\energy\partner\client;

    /**
     * Class helper for CHECK24 Vergleichsportal Energie GmbH partner middleware
     *
     * @author Tobias Albrecht
     * @copyright CHECK24 Vergleichsportal Energie GmbH
     * @version 1.0
     */
    class helper {

        private $response;

        /**
         * Constructor.
         *
         * @param response $response Response
         */
        public function __construct(response $response) {
            $this->response = $response;
        }

        /**
         * Handles response for partner
         * Returns array with head and body if given, otherwise it dies (for example ajax requests and so on)
         *
         * @return array
         */
        public function handle() {

            $content_type = $this->response->get_header('Content-Type');

            if (mb_strpos($content_type, ';') !== false) {
                $content_type = mb_substr($content_type, 0, mb_strpos($content_type, ';'));
            }

            // If we have nothing, request failed. We always send content type!
            // So we show up the error (partner might can't handle exceptions)

            if ($content_type === null) {
                echo $this->response->get_data();
                exit(1);
            }

            // Sent header and cookies to client

            $this->response->sent_header();
            $this->response->sent_cookies();

            // Handle based on content type what to do.
            // If html is given we have to split the content (if current request is not ajax)
            // Otherwise echo data and exit current script

            switch (mb_strtolower($content_type)) {

                case 'text/html' :

                    $data = $this->response->get_data();

                    // Seems like ajax request

                    if (count($this->response->get_request()->get_additional_x_header()) > 0) {
                        echo $data;
                        exit(0);
                    }

                    return $this->split_head_body($data);

                default :

                    echo $this->response->get_data();
                    exit(0);

            }

        }

        /**
         * Split head and body from data
         *
         * @param string $data Data from response
         * @return array
         * @throws \Exception
         */
        private function split_head_body($data) {

            $match = [];
            $split = ['head' => '', 'body' => ''];

            if (preg_match('/<head>(.*)<\/head>/is', $data, $match)) {
                $split['head'] = $match[1];
            } else {
                throw new \Exception('Failed to split head and body');
            }

            if (preg_match('/<body>(.*)<\/body>/is', $data, $match)) {
                $split['body'] = $match[1];
            } else {
                throw new \Exception('Failed to split head and body');
            }

            return $split;

        }

    }