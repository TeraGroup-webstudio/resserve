$(document).ready(function() 
{
    kjmodal.init_event();
});

var kjmodal = 
{
    modal_delay: 200,
    reset_option_delay: 1000,
    price_cache : [],
    $modal: null,
    base_inputs: "input[name='product_id'], input[name='quantity']",
    all_options: "input[type='text'], input[type='number'], input[type='hidden'], textarea, input[type='radio']:checked, input[type='checkbox']:checked, select",
    main_class: ".series-options-modal",

    datetime_load: function() 
    {
        if(this.is_modal_exists())
        {
            this.$modal.find('.date').datetimepicker({
                language: '',
                pickTime: false
            });

            this.$modal.find('.datetime').datetimepicker({
                language: '',
                pickDate: true,
                pickTime: true
            });

            this.$modal.find('.time').datetimepicker({
                language: '',
                pickDate: false
            });
        }
    },
    init_event: function() 
    {
        let self = this;
     
        $(document).on("change", self.main_class + " select, " + self.main_class + " input[type='radio'], " + self.main_class + " input[type='checkbox']", function() {
            //console.log("change opttt");
            if($(this).data("price") != 0)
            {
                let $modal = $(this).parents(self.main_class);
                let pid = parseInt($modal.data('productid'));
                let modal_opt_data = $modal.find(self.all_options).serialize();
                let modal_qty = parseInt($modal.find("input[name='quantity']").val());

                self.get_current_price(modal_opt_data, function(modal_price_json)
                {
                    self.init(pid);
                    self.refresh_total(modal_price_json);
                    self.get_product_thumbs(pid).trigger('changeOptprice', [ modal_qty, modal_price_json ]);
                });
            }
        });

        $(document).on("change", self.main_class + " input[name='quantity']", function() 
        {
            let $modal = $(this).parents(self.main_class);
            let pid = parseInt($modal.data('productid'));
            let modal_opt_data = $modal.find(self.all_options).serialize();
            
            self.get_current_price(modal_opt_data, function(modal_price_json)
            {
                self.init(pid);
                self.refresh_total(modal_price_json);
            });
        });
    },

    refresh_total: function(price_json) 
    {
        if (this.is_modal_exists()) 
        {
            var newhtml = this.price_html(price_json['format']['total'], price_json['format']['old_total']);
            this.$modal.find(".price").html(newhtml);
        }
        return this;
     },

    product_option: function($product)
    {
        let pid = $product.data('productid');
        let $modal = this.get_modal(pid);
        let opt_data, option_selector;
        let qty = $product.find("input[name='quantity']").val();

        if($modal.length)
        {
            opt_data = $modal.find(this.all_options).serialize();
            opt_data = helperv2.replace_param_in_url(opt_data, 'quantity', qty);
        }
        else
        {
            opt_data = $product.find(this.base_inputs).serialize();
        }

        return opt_data;
    },

    reset_modal_option: function() 
    {
        $(this.main_class).data('firstshow', 0);
        $(this.main_class).find("input[type = 'date'], input[type = 'time'], input[type = 'datetime'], textarea").val('');

        $(this.main_class).each(function()
        {
            $(this).find("select").val('');
            $(this).find("input[type = 'radio'], input[type = 'checkbox']").removeAttr('checked');
            $(this).find("input[type = 'radio'], input[type = 'checkbox'], select").last().trigger('change');
        });
    },

    get_current_price: function(opt_data, callback) 
    {
        let self = this;
        let cache_key = helperv2.hashcode(opt_data);

        if(typeof self.price_cache[cache_key] != 'undefined')
        {
            callback(self.price_cache[cache_key]);
            return;
        }

        $.ajax({
            type: "POST",
            url: 'index.php?route=extension/module/kjmodal/get_price',
            data: opt_data,
            success: function(json)
            {
                self.price_cache[cache_key] = json;
                callback(json);
            }
        });
    },

    price_html: function(total, old_total) 
    {
        if(typeof old_total !== "undefined")
        {
            return "<span class='price-old'>" + old_total + "</span> "+
            "<span class='price-new'>" + total + "</span>";
        }
        else
        {
            return "<span class=''>" + total + "</span>";
        }
    },

    get_product_thumbs: function(pid) 
    {
        return $("[data-productid='" + pid + "']");
    },

    get_modal: function(pid) 
    {
        return $("#kjmodal" + pid);
    },

    exist_modal: function(pid) 
    {
        return $("#kjmodal" + pid).length > 0;
    },

    set_qty: function(qty) 
    {
        let $qty = this.$modal.find('input[name="quantity"]');
        if (this.is_modal_exists() && typeof qty !== 'undefined' && $qty.val() != qty) 
        {
            $qty.val(qty).trigger('change');
        }
        return this;
    },

    set_onclick: function(onclick) 
    {
        if (this.is_modal_exists() && typeof onclick !== 'undefined') 
        {
            this.$modal.find(".apply-options").attr("onclick", onclick);
        }
        return this;
    },

    init: async function(pid) 
    {
        this.$modal = this.get_modal(pid);
        if (!this.is_modal_exists()) 
        {
           const html = await $.get("index.php?route=extension/module/kjmodal/getModal&pid=" + pid);
           $("body").append(html);
           this.$modal = this.get_modal(pid);
        }
        return this;
    },

    is_modal_exists: function()
    {
        return this.$modal.length > 0;
    },

    show: function() 
    {
        let self = this;
        if (self.is_modal_exists() && !self.$modal.hasClass("in")) 
        {
            self.$modal.data('firstshow', self.$modal.data('firstshow') + 1);
            setTimeout(function() 
            {
                self.$modal.modal('show');
            }, self.modal_delay);
        }
        return self;
    },

    opt_err_hgl(err)
    {
        if (err['option']) 
        {
            for (i in err['option']) 
            {
                let element = this.$modal.find('#set-input-option' + i.replace('_', '-'));
                element.after('<div class="text-danger">' + err['option'][i] + '</div>');
            }
        }
        this.$modal.find('.text-danger').parent().addClass('has-error');
    },

    check_options: async function() 
    {
        let result = false;

        if (this.is_modal_exists()) 
        {
            let $options = this.$modal.find(this.all_options);
            let json = await $.ajax({
                url: 'index.php?route=extension/module/kjmodal/checkProductOption',
                type: 'post',
                data: $options,
            });

            this.$modal.find('.text-danger').parent().removeClass('has-error');
            this.$modal.find('.text-danger').remove();

            if(json['error'])
            {
                this.opt_err_hgl(json['error']);
                this.show();
            }
            else if (json['success']) 
            {
                this.$modal.modal('hide');
            }

            result = json['success'];
        }
        return result;
    }
};

var recursive_cart =
{
    $products : null,
    recursive_add_to_cart: function() 
    {
        let self = this;
        var success_counter = 0;
        
        self.$products.each(function(key, product) 
        {
            var proddata = kjmodal.product_option($(product));
            
            $.ajax({
                url: 'index.php?route=checkout/cart/add',
                type: 'post',
                data: proddata,
                dataType: 'json',
                success: function(json) 
                {
                    success_counter++;
                    if(success_counter == self.$products.length)
                    {
                        successCartAddTemplateDefault(json);
                        self.$products = [];
                        setTimeout(function() {
                            kjmodal.reset_modal_option()
                        }, kjmodal.reset_option_delay);
                    }
                }
            });
        });
    },

    recursive_check_option: function(i) 
    {
        let self = this;

        if (typeof(i) === "undefined") 
        {
            i = 0;
        }
        else if(self.$products.length <= i)
        {
            self.recursive_add_to_cart();
            return;
        }

        let $product = self.$products.eq(i);
        let option_type = $product.data("optiontype");
        let pid = $product.data("productid");
        let onclick = 'recursive_cart.recursive_check_option(' + i + ')';
        let qty = parseInt($product.find('input[name = "quantity"]').val());
        //holy sh1t
        if (qty > 0 && option_type == 'modal') 
        {
            kjmodal.init(pid).then(function(data) 
            {
                kjmodal.set_qty(qty).set_onclick(onclick);
                return kjmodal.$modal.data('firstshow') > 0;
            }).then(function(alredy_shown) 
            {
                if (alredy_shown) 
                {
                    kjmodal.check_options().then(function(is_valid_opts) 
                    {
                        if(is_valid_opts)
                        {
                            self.recursive_check_option(i + 1);
                        }
                    });
                } 
                else 
                {
                    kjmodal.show();
                }
            });
        } 
        else 
        {
            self.recursive_check_option(i + 1);
        }
    },
}

var helperv2 = 
{
    decimal_place: 1,
    price_regex: /\d[\d\s\.]*/g,
    space_after: true,

    set_decimal_place: function(number)
    {
        this.decimal_place = number;
    },

    replace_price: function($el, new_price) 
    {
        if ($el.length == 0) {
            return;
        }
        let round_number = this.round_number(new_price);
        let new_number = $el.text().trim().replace(this.price_regex, round_number + " ");
        $el.text(new_number);
    },

    replace_param_in_url(url, param, val)
    {
        let params = new URLSearchParams(url);
        params.set(param, val);
        return params.toString();
    },

    round_number: function(number) 
    {
        return number.toFixed(this.decimal_place);
    },

    get_selector_of_el: function($el) 
    {
        let selector = "";
        let id = $el.attr("id");
        if (id) {
            selector += "#" + id;
        }
        let classNames = $el.attr("class");
        if (classNames) {
            selector += "." + $.trim(classNames).replace(/\s/gi, ".");
        }
        //console.log("return selector: " + selector);
        return selector;
    },

    is_category: function() 
    {
        return $("#product").length == 0;
    },

    hashcode: function(str) 
    {
      return str.split('').reduce((prevHash, currVal) =>
        (((prevHash << 5) - prevHash) + currVal.charCodeAt(0))|0, 0);
    },
};