# Partner affiliate client for CHECK24 Vergleichsportal Energie GmbH.

## Usage
Create client instance of check24\energy\partner\client\client.
You can find your partner id and client secret in your account.
if you want a different tracking than default, you can spec. this as third parameter in the constructor.

Call the handle method of the client to request the product (strom or gas => use the consts). To create your own custom style use the partner cockpit and pass the name.
For easy handling the response you can use the client helper. 
Pass the response as constructor parameter and call handle.
It will exit the script if needed (for ajax calls e.g.) or return splitted head and body from html, so that you can put it everywhere you want to.

Example call
```php
$partner_id = 0;
$secret = '';
$tracking_id = '';
$product = check24\energy\partner\client\client::PRODUCT_POWER;
$style = 'default';

$presets = [];

$presets['zipcode'] = 80636;
$presets['totalconsumption'] = 4000;

$client = new check24\energy\partner\client\client($partner_id, $secret, $tracking_id);

$response = $client->handle($product, $style, $presets);

$helper = new check24\energy\partner\client\helper($response);
$split = $helper->handle();

echo $split['head'];
echo $split['body'];
```
