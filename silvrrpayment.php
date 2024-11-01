<?php
/*
 * Plugin Name: SILVRR PayLater
 * Description: SILVRR PayLater is a payment method that allows you to offer flexible and hassle-free payment options to your customers. SILVRR is already trusted by thousands of merchants around the world to take their business to a whole new level.
 * Author: SILVRR team
 * Author URI:
 * Version: 1.0.0
 */


/*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter( 'woocommerce_payment_gateways', 'silvrr_add_gateway_class' );
function silvrr_add_gateway_class( $gateways ) {
    $gateways[] = 'Silvrrpayment_Gateway'; // your class name is here
    return $gateways;
}



/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action( 'plugins_loaded', 'silvrr_init_gateway_class' );
function silvrr_init_gateway_class() {
    require_once __DIR__."/silvrrpayment_gateway.php";
    global $wc_silvrr_gateway;
    $wc_silvrr_gateway = new Silvrrpayment_Gateway();

}

add_action( 'woocommerce_api_silvrrpayment_gateway', 'silvrr_callback');
function silvrr_callback()
{
  
    $callback_url = add_query_arg('wc-api', 'silvrrpayment_gateway', home_url('/'));
    //$base_url = site_url();
    $uri_info = parse_url($callback_url);
  
  
  
  //  $uri = $this->context->link->getModuleLink( $this->module->name, 'callback' ) ;
    //$uri_info = parse_url($callback_url);
    $uri = $uri_info['path'];//str_replace($base_url,'',$callback_url);
 
    
   

    $headers =  silvrr_getallheaders();
   

    $apiKey =$headers['X-Op-Apikey'];// $headers['X-Op-Apikey'];
    $reqId =  $headers['X-Op-Reqid'];
    $reqTime = $headers['X-Op-Reqtime'];

    $reqData = file_get_contents('php://input');

    $headSign = $headers['Signature'];
    $sign = $headSign;//substr($headSign,strpos($headSign,'signature=')+10);
    $sign =   strtr($sign, '-_', '+/');


    $data_arr = json_decode($reqData,true);

    // if($data_arr && $data_arr['Payment'])

    if($data_arr && $data_arr['eventType'] && $data_arr['eventType']!='Payment')
    {
        echo json_encode(['success'=>false]);
        exit;
    }
     

    $wc_silvrr_gateway = new Silvrrpayment_Gateway();

    if($data_arr && $data_arr['payment'])
    {
        $orderId = $data_arr['payment']['orderId'];
        $partnerOrderId = $data_arr['payment']['partnerOrderId'];
        $order = new WC_Order($partnerOrderId);

 
        if(empty($order->get_id()))
        {
            return;
        }

 
        if($data_arr['payment']['orderStatus']=='PAID')
        {
            $verify_status = silvrr_verify('POST',$uri,$apiKey,$reqId,$reqTime,$reqData,$sign,$wc_silvrr_gateway->public_key);
            
            
            if($verify_status)
            {
                $order->payment_complete();
                
                 echo json_encode(['success'=>true]);
                 exit;
            }
        }
    }


}
function  silvrr_getallheaders()
{
    $headers = array();
    foreach ($_SERVER as $name => $value)
    {
        if (substr($name, 0, 5) == 'HTTP_')
        {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
}

 function silvrr_verify($method,$uri,$apiKey,$reqId,$reqTime,$reqData, $sign, $publicKey)
{
    $content = strtoupper($method).
        '|'.$uri.
        '|'.$apiKey.
        '|'.$reqId.
        '|'.$reqTime.'|';

    if(!empty($reqData))
    {
        $content.=$reqData;
    }
   
    

    $key= openssl_get_publickey($publicKey);
    $ok= openssl_verify($content,base64_decode($sign), $key, 'SHA256');

    openssl_free_key($key);
    return $ok;

}