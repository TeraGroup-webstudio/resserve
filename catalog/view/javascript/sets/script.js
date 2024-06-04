$(document).ready(function() {
    kjset.init_event();
});

var kjset = {
    $products: [],
    init_event: function() {
        if($('.sets').length == 0)
        {
            return;
        }

        let _this = this;

        $('.sets').show();
        _this.start_timer();

        $(document).on('click', ".set .add-set-btn", function() {
            recursive_cart.$products = $(this).parents('.set').find('.set-product');
            recursive_cart.recursive_check_option(0);
        });

        $(document).on('changeOptprice', ".set .set-product", function(e, modal_qty, modal_price_json) 
        {

            let $product = $(this);
            let qty = parseInt($product.find("input[name='quantity']").val());

            if(qty == modal_qty)
            {
                _this.update_price($product, modal_price_json);
            }
            else
            {
                kjmodal.get_current_price(kjmodal.product_option($product), function(price_json)
                { 
                    _this.update_price($product, price_json);
                });
            }
            
        });
        
        $(document).on('click', ".set .open-options", function() {
            let modal_selector = $(this).data('target');
            let pid = $(this).parents('.set-product').data("productid");
            let $set = $(this).parents('.set');
            let $product = $(this).parents('.set-product');
            let qty = parseInt($product.find("input[name='quantity']").val());
            let onclick = "$(this).parents('.modal').modal('hide');";
            //let finalcprice = parseFloat($product.data('finalcprice'));

            kjmodal.init(pid).then(function(data) {
                kjmodal.show(1).set_qty(qty).set_onclick(onclick);
            });
        });
    },
    update_price: function($product, price_json)
    {
        let discount = $product.data("discount").toString();
        let $set = $product.parents(".set");
        
        if(price_json['no_format']['old_price'])
        {
            helperv2.replace_price($product.find('.price .price-new'), price_json['no_format']['price']);
            helperv2.replace_price($product.find('.price .price-old'), price_json['no_format']['old_price']);
        }
        else
        {
            helperv2.replace_price($product.find('.price'), price_json['no_format']['price']);
        }
        
        $product.data("price", price_json['no_format']['price']);
        this.update_total($set);
    },
    discount_parser: function(price, discount_str)
    {
        if (discount_str.substring(discount_str.length - 1) == "%") {
            return (price / 100) * parseFloat(discount_str.slice(0, -1));
        } else {
            return parseFloat(discount_str);
        }
    },
    update_total: function($set) {
        let self = this;
        let id, cprice, qty, economy, total = 0, total_economy = 0;
        if (typeof $set === 'undefined') {
            return;
        }

        //let disc_type = $set.data("disc-type");
        $set.find('.set-product').each(function(index) {
            qty = parseInt($(this).find("input[name='quantity']").val());
            cprice = parseFloat($(this).data("price"));
            id = parseFloat($(this).data("productid"));
            discount = $(this).data("discount").toString();
            economy = self.discount_parser(cprice, discount);
            total_economy += economy * qty;
            total += (cprice * qty);
        });
     
        if ($set.find('.set-total .economy').length) {
            helperv2.replace_price($set.find('.set-total .economy .economy_val'), total_economy);
        }
        helperv2.replace_price($set.find('.set-total .new_summ'), total - total_economy);
    },
    start_timer: function() {
        let i = 1;
        $('.set').each(function() {
            let set = this;
            let timestamp = $(this).find("input[name='sp_timer']").val();
            if (timestamp == 0) return;
            $(this).find('.timer').show();
            let sel = $(this).find('.timer');
            let now = new Date().getTime();
            let distance = timestamp * 1000 - now;
            let x = setInterval(function() {
                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                let text = "До кінця акції: ";
                if (days !== 0) text += days + " д. ";
                if (hours !== 0 || days !== 0) text += hours + " г. ";
                if (minutes !== 0 || hours !== 0 || days !== 0) text += minutes + " х. ";
                if (seconds !== 0 || minutes !== 0 || hours !== 0 || days !== 0) text += seconds + " с. ";
                $(sel).html(text);
                distance -= 1000;
                if (distance <= 0) {
                    clearInterval(x);
                    $(set).hide("slow");
                }
            }, 1000);
        });
    }
};