<?php
namespace Sms;

class Sms {

    public function __construct($registry) {
        $this->config = $registry->get('config');
        $this->log = $registry->get('log');
        $this->customer = $registry->get('customer');
        $this->session = $registry->get('session');
        $this->db = $registry->get('db');
        $this->tax = $registry->get('tax');
        $this->weight = $registry->get('weight');


    }

    function replacetext($message,$product_info,$customer_info='') {
        $search_data = array( "%customer_name%", "%product_name%", "%product_price%", "%product_href%", "%option_name%","%product_model%","%shop_name%" );
        $replace_data = array( $product_info["name"], $product_info["product"], $product_info['price'], $product_info['href'], $product_info['option_name'], $product_info['model'],"");
        if( 1 < strlen($message) )
        {
            $sms_text = str_replace($search_data, $replace_data, $message);
            return $sms_text;
        }
        return false;
    }

    function sendsms($message_type,$data){

        // $this->log->write(unserialize($infobd['arbitrary_fields']));

        if($message_type <> 'test') {

            $arbitrary_fields = unserialize($data['arbitrary_fields']);
            $bd_arbitrary_fields = $this->config->get('avail_arbitrary');
            foreach ($arbitrary_fields as $key => $arbitrary_field){

                if(!empty($bd_arbitrary_fields[$key]) and $bd_arbitrary_fields[$key]['field_type'] == 'phone'  ){

                    $phone_recipients =   $res = preg_replace("/[^0-9]/", "", $arbitrary_field );

                }

            }
        }

        if($this->config->get('avail_smssend_status') == 1) {
            if ($this->config->get('avail_sms_type') == 'turbosms') {


// якщо ініціяці відправки відбувається в момент запису заявки. кліент залишив заявку
                if ($message_type == 'front') {
                    // відправляти сповіщення адміну
                    if ($this->config->get('avail_smssend_admin') == 1) {
                        $info[0]['message'] = strip_tags(html_entity_decode($this->config->get('avail_sms_frmsms_message3')));
                        $info[0]['phone'] = $this->config->get('avail_sms_admin_phone');
                    }
                    // відправляти сповіщення покупцю
                    if ($this->config->get('avail_sms_send1') == 1) {
                        $info[1]['message'] = strip_tags(html_entity_decode($this->config->get('avail_sms_frmsms_message1')));
                        $info[1]['phone'] =  $phone_recipients;
                    }

// якщо відправка відбувається з адмінки. повідомлення про те , що товар є  в наявності
                    // якщо вімкнуто відправка смс про надходження товару
                } else if ($message_type == 'beck' and $this->config->get('avail_sms_send2') == 1) {
                    $info[0]['message'] = strip_tags(html_entity_decode($this->config->get('avail_sms_frmsms_message2')));
                    $info[0]['phone'] = $phone_recipients;
// відправка тестового смс
                } else if ($message_type == 'test') {


                    $info[0]['message'] = strip_tags(html_entity_decode($this->config->get('avail_sms_frmsms_message')));
                    $info[0]['phone'] = $this->config->get('avail_sms_frmsms_phone');

                } else {
                    $info = false;
                }
                // якщо є сповіщення то починаємо відправку
                if ($info) {
                    foreach ($info as $inf) {
                        // отримуємо текст сповіщення з заміненими змінними
                        if ($message_type == 'test') {
                            $result =  $info[0]['message'];
                        } else {
                            $result = $this->replacetext($inf['message'], $data);
                        }
                        $postdata = array(
                            'recipients' => array($inf['phone']),// получатель
                            'sms' => array('sender' => 'WPHost.me',
                                'text' => $result),
                        );

                        if(!empty($this->config->get('avail_sms_start_time'))){

                            $postdata['start_time'] =  $this->config->get('avail_sms_start_time');
                        }
                        if(!empty($this->config->get('avail_image_url'))){
                            $postdata['image_url'] =  $this->config->get('avail_image_url');
                        }
                        if(!empty($this->config->get('avail_caption'))){
                            $postdata['caption'] =  $this->config->get('avail_caption');
                        }
                        if(!empty($this->config->get('avail_caption'))){
                            $postdata['action'] =  $this->config->get('avail_action');
                        }
                        if(!empty($this->config->get('avail_count_clicks'))){
                            $postdata['count_clicks'] =  $this->config->get('avail_count_clicks');
                        }



                        $postdata = json_encode($postdata);
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
                        curl_setopt($curl, CURLOPT_URL, "https://api.turbosms.ua/message/send.json");
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                            'Authorization: Basic ' . $this->config->get('avail_sms_key'),
                            'Content-Type: application/json',
                        ));


                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        $output = curl_exec($curl);

                        curl_close($curl);
                        return $output;
                    }
                }

            }
        }


    }
}