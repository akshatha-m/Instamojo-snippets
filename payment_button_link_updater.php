<?php

/*
Author: Ashwini Chaudhary
Purpose: If you want to use Instamojo's remote checkout button on your website and you are
generating the URL on your own as well then this script will help you use that
URL with the remote checkout button so that we can pre-fill the form with data
obtained from URL.

*/

function Instamojo_remote_checkout_button_updater($new_payment_link, $payment_button_html){
    $doc = new DOMDocument();
    $doc->loadHTML($payment_button_html);
    $nodes = $doc->getElementsByTagName('a');
    foreach($nodes as $node){
        $payment_link = $node->getAttribute('href');
        break;
    }
    


    $node->setAttribute('href', $new_payment_link);
    $html = $doc->saveHTML();
    $output = Array(); 
    preg_match("/<html><body>(.*?)<\/body><\/html>/", $html, $output);
    return html_entity_decode($output[1]);
	
}

//Example input:

$button_html = '<a href="https://www.instamojo.com/ashwch/test-magento/" rel="im-checkout" data-behavior="remote" data-style="light" data-text="Checkout with Instamojo" data-token="3bcde71b220ccc7bc44dba0881894f47"></a><script src="https://d2xwmjc4uy2hr5.cloudfront.net/im-embed/im-embed.min.js"></script>';
$new_payment_link = 'https://www.instamojo.com/Sameeraggarwal/wealth-advice/?embed=form&data_readonly=data_amount&data_readonly=data_email&data_readonly=data_name&data_readonly=data_phone&data_hidden=data_Field_8546&data_sign=1b850dc20cd4ab47b45cf480bc8225dd7627ce2d&data_amount=10&data_email=sam@sam.com&data_name=asasa&data_phone=1234567890&data_Field_8546=ADVSR1000013';
$new_button_html = Instamojo_remote_checkout_button_updater($new_payment_link, $button_html);

/*
echo $new_button_html;
<a href="https://www.instamojo.com/Sameeraggarwal/wealth-advice/?embed=form&data_readonly=data_amount&data_readonly=data_email&data_readonly=data_name&data_readonly=data_phone&data_hidden=data_Field_8546&data_sign=1b850dc20cd4ab47b45cf480bc8225dd7627ce2d&data_amount=10&data_email=sam@sam.com&data_name=asasa&data_phone=1234567890&data_Field_8546=ADVSR1000013" rel="im-checkout" data-behavior="remote" data-style="light" data-text="Checkout with Instamojo" data-token="3bcde71b220ccc7bc44dba0881894f47"></a><script src="https://d2xwmjc4uy2hr5.cloudfront.net/im-embed/im-embed.min.js"></script>
*/


?>
