<?php

    // Get composer autoloader

    require_once __DIR__ . '/../../vendor/autoload.php';

    // Example parameters

    $partner_id = 0;
    $secret = '';
    $tracking_id = '';
    $product = check24\energy\partner\client\client::PRODUCT_POWER;
    $style = 'default';

    // Create instance of client to communicate with middleware

    $client = new check24\energy\partner\client\client($partner_id, $secret, $tracking_id);

    // Request page

    $response = $client->handle($product, $style);

    // Use helper for easy client side implementation

    $helper = new \check24\energy\partner\client\helper($response);
    $split = $helper->handle();

    echo $split['head'];
    echo $split['body'];
