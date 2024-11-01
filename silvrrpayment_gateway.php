<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2022/5/30
 * Time: 17:47
 */

class Silvrrpayment_Gateway extends WC_Payment_Gateway {
    /**
     * Class constructor, more about it in Step 3
     */
    private $is_error_displayed = false;
    public function __construct() {

        $this->id = 'silvrr'; // payment gateway plugin ID
        $this->icon = ''; // URL of the icon that will be displayed on checkout page near your gateway name
        $this->has_fields = false; // in case you need a custom credit card form
        $this->title =  __( 'SILVRR Pay Later', 'woocommerce' );
        $this->method_title = __( 'SILVRR Pay Later', 'woocommerce' );
        $this->method_description = __( 'SILVRR Pay Later', 'woocommerce' ); // will be displayed on the options page

        // gateways can support subscriptions, refunds, saved payment methods,
        // but in this tutorial we begin with simple payments
        $this->supports = array(
            'products',
            'refunds'

        );

        $this->init_form_fields();

        // Load the settings.
        $this->init_settings();

        $this->api_key = $this->get_option('api_key');
        $this->private_key = $this->get_option('private_key');
        $this->public_key = $this->get_option('public_key');
        $this->private_key_version = $this->get_option('private_key_version');

        // This action hook saves the settings
        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

        // We need custom JavaScript to obtain a token
        add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );

        // You can also register a webhook here
        // add_action( 'woocommerce_api_{webhook name}', array( $this, 'webhook' ) );

        if(file_exists('displayed.txt'))
        {
            unlink("displayed.txt");
        }


    }
    public function process_admin_options()
    {
        $re = parent::process_admin_options();
        $post_data = $this->get_post_data();
        $this->check_private_key($post_data['woocommerce_silvrr_private_key']);
        $this->check_public_key($post_data['woocommerce_silvrr_public_key']);
        $this->check_config($post_data['woocommerce_silvrr_api_key'],$post_data['woocommerce_silvrr_private_key'],$post_data['woocommerce_silvrr_public_key'],$post_data['woocommerce_silvrr_private_key_version']);
        if(!file_exists('displayed.txt'))
        {
            $this->display_errors();
//            file_put_contents("displayed.txt",'test');
           // $this->is_error_displayed = true;
        }

        return $re;

    }
    private function check_config($api_key,$prifvate_key,$public_key,$private_key_version)
    {

    }
    private function check_public_key($public_key)
    {

        $public_key_re = openssl_get_publickey($public_key);
        if($public_key_re==false)
        {
            $error_msg = __('ERROR').":".__("Public Key's format is wrong");
            if(!in_array($error_msg,$this->errors))
            {
               $this->add_error($error_msg);
            }
        }
        else
        {
            openssl_free_key($public_key_re);
        }
    }
    private function check_private_key($private_key)
    {

        $secret_key_re= openssl_get_privatekey($private_key);
        if($secret_key_re==false)
        {

            $error_msg = __('ERROR').":".__("Private Key's format is wrong");
            if(!in_array($error_msg,$this->errors))
            {
                $this->add_error($error_msg);
            }
        }
        else
        {
            openssl_free_key($secret_key_re);
        }

    }


    /**
     * Plugin options, we deal with it in Step 3 too
     */
    public function init_form_fields(){
        $this->form_fields = array(
            'api_key' => array(
                'title'       => __('Api Key', 'woocommerce' ),
                'type'        => 'text',
                'description' => '',
                'default'     => '',
                'desc_tip'    => true,
            ),
            'private_key' => array(
                'title'       => __('Private Key', 'woocommerce' ),
                'type'        => 'textarea',
                'description' => '',
                'default'     => '',
            ),
            'public_key' => array(
                'title'       => __('Public Key', 'woocommerce' ),
                'type'        => 'textarea',
                'description' => '',
                'default'     => '',
            ),
            'private_key_version' => array(
                'title'       => __('Private Key Version', 'woocommerce' ),
                'type'        => 'text',
                'description' => '',
                'default'     => '1.0',
                'desc_tip'    => true,
            )

        );


    }

    /**
     * You will need it if you want your custom credit card form, Step 4 is about it
     */
    public function payment_fields() {



    }

    /*
     * Custom CSS and JS, in most cases required only when you decided to go with a custom credit card form
     */


    public function payment_scripts() {



    }

    /*
      * Fields validation, more in Step 5
     */

    /*
    public function validate_fields() {



    }*/

    /*
     * We're processing the payments here, everything about it is in Step 5
     */
    public function process_payment( $order_id ) {
        require_once __DIR__."/silvrr/Http/Request/SilvrrOrderPay.php";

        $order = new WC_Order($order_id);
        $order->update_status('on-hold', __( 'Awaiting cheque payment', 'woocommerce' ));
        
        
        $partnerOrderId = $order_id;
        $config = new SilvrrConfiguration($this->api_key , $this->private_key,$this->private_key_version,"3075246698788960258-WooCommerce Checkout",WC_VERSION);
//        file_put_contents('abc_q.txt',$this->api_key.'---'.$this->private_key.'--'.$this->private_key_version);


        $orderPay = new SilvrrOrderPay($config,$partnerOrderId);  #创建订单请求

        //    $shipping_address = new Address($cart->id_address_delivery);
        //  $country_object = new Country( $shipping_address->id_country);
        //  $state_object = new State( $shipping_address->id_state );


        $orderPay->partnerOrderId = $partnerOrderId;
        $orderPay->currency = $order->get_currency();
        $orderPay->partnerOrderAmount =$order->get_total();


        $country_code = $order->get_shipping_country();
        $country_code = empty($country_code)?$order->get_billing_country():$country_code;
        $orderPay->purchaseCountry= $country_code;


        $callback_url = add_query_arg('wc-api', 'silvrrpayment_gateway', home_url('/'));
        
      
        $redirect_url = $this->get_return_url($order);

        $orderPay->redirectUrl = $redirect_url;
        $orderPay->callbackUrl = $callback_url;

        $customer =  new WC_Customer($order->get_customer_id());
        $buyer = new SilvrrBuyer();  #购买者, SilvrrOrderPay的成员变量buyer
        $buyer->buyerId = $order->get_customer_id();  #购买者id


        $buyer->birthDate = "2000-01-01";  ######
        $buyer->gender = "male";  #####
        $buyer->name = $customer->get_first_name();


        ///////////////////shipping
        $shipping = new SilvrrShipping();

//        $shipping->city = $order->get_shipping_city();
        $shipping->city  = empty($order->get_shipping_city()) ? $order->get_billing_city(): $order->get_shipping_city();
        $shipping->countryCode = $order->get_shipping_country();
        $shipping->countryCode = $shipping->countryCode=='ID'?"IDN": $shipping->countryCode;

        $shipping->receiverName = $order->get_shipping_first_name();
        $shipping->receiverPhone = $order->get_billing_phone();
        $shipping->region = $order->get_shipping_state();
        $shipping->postcode = $order->get_shipping_postcode();
        $shipping->addressLine = $order->get_shipping_address_1();


        ///Optional
        #$shipping->district = order->get_shipping_address_1();
        #$shipping->street =$shipping_address->address2;


        $billingAddress = new SilvrrBillingAddress();
        ////Required
        $billingAddress->firstName = $order->get_billing_first_name();
        $billingAddress->lastName =  $order->get_billing_last_name();
        $billingAddress->countryCode =$order->get_billing_country();
        $billingAddress->city = $order->get_billing_city();
        $billingAddress->region = $order->get_billing_state();
        $billingAddress->postcode = $order->get_billing_postcode();
        $billingAddress->addressLine = $order->get_billing_address_1();
        $billingAddress->email = $order->get_billing_email();

        ////Optional
        $billingAddress->street = $order->get_billing_address_2();
        $billingAddress->title = "Billing Details";

        $products = $order->get_items();


        $item_arr = [];
        foreach($products  as $product) {
            $item1 = new SilvrrItem();

            $meta_data = $product->get_data();

            $item1->categoryId = "none"; ######
            $item1->skuId = $product->get_id();
            $item1->skuName = $product->get_name();
            $item1->unitPrice = $meta_data['total'];
            $item1->qty = $product->get_quantity();

            $item1->categoryName = "none";
            //$item1->pictureUrl = "https://www.baidu.com/1.jpg";
            $item1->type = "PhysicalGood";

            $item1->seller = new SilvrrSeller("none","none"); #########
            $item_arr[] = $item1;

        }

        /**
         * 将前面创建的四个类对象赋值给SilvrrOrderPay对象
         */
        $orderPay->buyer = $buyer;
        $orderPay->shipping = $shipping;
        $orderPay->items = array($item1);
        $orderPay->billingAddress = $billingAddress;


        try {
            $result = $orderPay->request();
            
            if (!empty($result)) {
                $dataArr = json_decode($result, true);
                if (is_array($dataArr)) {
                    if ($dataArr['code'] == "SUCCESS" || $dataArr['code'] == "DUPLICATE")  //如果成功则可以跳到支付, 或作其他处理
                    {
                        $payUrl = $dataArr['order']['paymentEntryUrl'];
                        global $woocommerce;
                        $woocommerce->cart->empty_cart();
                        return array(
                            'result' => 'success',
                            'redirect' => $payUrl
                        );
                    } else {
                        throw new Exception($dataArr['message']);
                    }

                } else {
                    throw new Exception('Unknown Error occurs');
                }
            }
        }catch (\Exception $exception)
        {
            wc_add_notice( __('Payment error:', 'woothemes') . $exception->getMessage(), 'error' );
            return;
        }
        return;

    }


    public function process_refund($order_id, $amount = null, $reason = '' ) {
  
      
    
        $order = new WC_Order($order_id);

        require_once __DIR__."/silvrr/Http/Request/SilvrrCreateRefund.php";
        $config = new SilvrrConfiguration($this->api_key , $this->private_key,$this->private_key_version,"3075246698788960258-WooCommerce Checkout",WC_VERSION);
        $partnerOrderId = $order_id;

        $refund = new SilvrrCreateRefund($config,$partnerOrderId);

        $refund->currency = $order->get_currency();
        $refund->refundId = $order_id.''.time();  ##########
        $refund->refundAmount =  $amount;
      
        try{
            $result = $refund->request();
//            file_put_contents(__DIR__.'/refund.txt',$refund->refundId.'--'.$refund->currency.'--'.$refund->refundAmount.'--'.$partnerOrderId.'--'.$result);
            $dataArr = json_decode($result,true);
            if(!empty($result))
            {
               
                
                if(is_array($dataArr))
                {
                    
                    if($dataArr['code']=="SUCCESS" )
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                
            }
            return false;
        }
        catch (Exception $exception)
        {

            return false;
        }
        

    }


    /*
     * In case you need a webhook, like PayPal IPN etc
     */
    public function webhook() {


    }
}