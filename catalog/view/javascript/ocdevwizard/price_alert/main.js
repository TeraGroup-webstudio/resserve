$(function() {
  ocdw_price_alert_action();
});

function ocdw_price_alert_action() {
  let products = [],
      product_id_on_page = $("#product input[name='product_id']").val(),
      add_function_selector = ["cart.add","addToCart"];
  
  $.each(add_function_selector, function (i, selector) {
    $('[onclick^="' + selector + '("]').each(function () {
      let product = $(this).attr('onclick').match(/[0-9]{1,}/);
      if (product[0].length) {
        products.push(product[0]);
      }
    });
  });
  
  if (typeof(product_id_on_page) != 'undefined') {
    products.push(product_id_on_page);
  }
  
  $.ajax({
    type: 'post',
    url: 'index.php?route=extension/ocdevwizard/price_alert/get_products',
    data: {'products': products},
    dataType: 'json',
    success: function (json) {
      let display_type = 1,
          sidebar_type = 1,
          button_location = 1,
          button_location_product_page = 1,
          button_class_global = '',
          button_class_product_page = 'btn btn-primary btn-lg btn-block',
          icon = '',
          add_id_selector = ["#button-cart"];
        
      $('button.ocdw_price_alert-call-button').remove();
      
      $.each(json['products'], function(i,value) {
        $.each(add_function_selector, function(i,selector) {
          $('[onclick^="'+selector+'(\''+value+'\'"]').each(function() {
            if ($('body').attr('class') == 'product-compare') {
              if (button_location == 1) {
                $(this).parent().before('<div class="compare-page ocdw_price_alert-call-static-before"><button type="button" class="'+button_class_global+' ocdw_price_alert-call-static-button" onclick="ocdw_price_alert_open({a:this,b:\''+value+'\',c:\''+display_type+'\'})">'+(icon ? '<img src="'+icon+'" alt=""/>' : json['call_button'])+'</button></div>');
              } else {
                $(this).parent().after('<div class="compare-page ocdw_price_alert-call-static-after"><button type="button" class="'+button_class_global+' ocdw_price_alert-call-static-button" onclick="ocdw_price_alert_open({a:this,b:\''+value+'\',c:\''+display_type+'\'})">'+(icon ? '<img src="'+icon+'" alt=""/>' : json['call_button'])+'</button></div>');
              }
            } else if ($('body').attr('class') == 'account-wishlist') {
              if (button_location == 1) {
                $(this).parent().before('<button type="button" class="'+button_class_global+' wishlist-page ocdw_price_alert-call-static-button" onclick="ocdw_price_alert_open({a:this,b:\''+value+'\',c:\''+display_type+'\'})">'+(icon ? '<img src="'+icon+'" alt=""/>' : json['call_button'])+'</button>');
              } else {
                $(this).parent().after('<button type="button" class="'+button_class_global+' wishlist-page ocdw_price_alert-call-static-button" onclick="ocdw_price_alert_open({a:this,b:\''+value+'\',c:\''+display_type+'\'})">'+(icon ? '<img src="'+icon+'" alt=""/>' : json['call_button'])+'</button>');
              }
            } else {
              if (button_location == 1) {
                $(this).parent().before('<div class="button-group ocdw_price_alert-call-static-before"><button type="button" class="'+button_class_global+' ocdw_price_alert-call-static-button" onclick="ocdw_price_alert_open({a:this,b:\''+value+'\',c:\''+display_type+'\'})">'+(icon ? '<img src="'+icon+'" alt=""/>' : json['call_button'])+'</button></div>');
              } else {
                $(this).parent().after('<div class="button-group ocdw_price_alert-call-static-after"><button type="button" class="'+button_class_global+' ocdw_price_alert-call-static-button" onclick="ocdw_price_alert_open({a:this,b:\''+value+'\',c:\''+display_type+'\'})">'+(icon ? '<img src="'+icon+'" alt=""/>' : json['call_button'])+'</button></div>');
              }
            }
          });
        });
        
        if (typeof(product_id_on_page) != 'undefined') {
          $.each(add_id_selector, function(i,selector) {
            if (product_id_on_page == value) {
              if (button_location_product_page == 1) {
                $(selector).before('<button type="button" class="'+button_class_product_page+' ocdw_price_alert-call-static-button" onclick="ocdw_price_alert_open({a:this,b:\''+product_id_on_page+'\',c:\''+display_type+'\'})">'+(icon ? '<img src="'+icon+'" alt=""/>' : json['call_button_product_page'])+'</button>');
              } else {
                $(selector).after('<button type="button" class="'+button_class_product_page+' ocdw_price_alert-call-static-button" onclick="ocdw_price_alert_open({a:this,b:\''+product_id_on_page+'\',c:\''+display_type+'\'})">'+(icon ? '<img src="'+icon+'" alt=""/>' : json['call_button_product_page'])+'</button>');
              }
            }
          });
        }
      });
      
      if (display_type == 2) {
        let sidebar_position = (sidebar_type == 1) ? 'left' : 'right';

        $('body').prepend('<div id="ocdw_price_alert-sidebar" class="ocdw_price_alert-sidebar sidebar-'+sidebar_position+' no-active"><div class="ocdw_price_alert-sidebar-bg"></div><div class="ocdw_price_alert-sidebar-body"></div></div>');
      }
    }
  });
}

function ocdw_price_alert_sidebar_close() {
  $('body, #ocdw_price_alert-sidebar').removeClass('sidebar-active');
}

function ocdw_price_alert_open(options) {
  let element = options.a || '',
      product_id = options.b || '',
      display_type = options.c || '',
      product_option_id = options.d || '',
      product_option_value_id = options.e || '',
      record_type = options.f || '1',
      popup_background_type = 1,
      popup_animation_type = '0',
      record_data = (record_type == '2') ? {'product_id':product_id,'display_type':display_type,'product_option_id':product_option_id,'product_option_value_id':product_option_value_id,'record_type':record_type} : {'product_id':product_id,'display_type':display_type,'record_type':record_type};
    
  if (display_type == 1) {
    ocdw_price_alert_load_css('catalog/view/javascript/ocdevwizard/helper/magnific-popup/magnific-popup.min.css', 'helper-magnific',function() {
      ocdw_price_alert_load_js('catalog/view/javascript/ocdevwizard/helper/magnific-popup/jquery.magnific-popup.min.js', 'helper-magnific',function() {
        $.magnificPopup.open({
          tLoading: '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
          items: {src:'index.php?route=extension/ocdevwizard/price_alert'},
          type: 'ajax',
          ajax: {
            settings: {
              type: 'post',
              data: record_data
            }
          },
          closeOnContentClick: 0,
          closeOnBgClick: 1,
          closeBtnInside: 1,
          enableEscapeKey: 1,
          alignTop: 0,
          showCloseBtn: 0,
          removalDelay: (popup_animation_type) ? 300 : 0,
          mainClass: popup_animation_type,
          callbacks: {
            beforeOpen: function() {
              this.wrap.removeAttr('tabindex');
            },
            open: function() {
              $('.mfp-content').addClass('mfp-with-anim');
              $('.mfp-container').removeClass('mfp-ajax-holder').addClass('mfp-iframe-holder');
            }
          }
        });
    
        $('.spinner > div').css({
          'background-color': '#ffffff'
        });
    
        $('.mfp-bg').css({
          'background': (popup_background_type == 1) ? 'url(image/catalog/ocdevwizard/price_alert/background/bg_7.png)' : '#000000',
          'opacity': '0.8'
        });
      });
    });
  } else {
    $.ajax({
      type: 'post',
      url: 'index.php?route=extension/ocdevwizard/price_alert',
      data: record_data,
      dataType: 'html',
      beforeSend: function() {
        $(element).prop('disabled', true);
      },
      complete: function() {
        $(element).prop('disabled', false);
      },
      success: function(data) {
        $('body').addClass('sidebar-active');

        $('#ocdw_price_alert-sidebar .ocdw_price_alert-sidebar-bg').css({
          'background': (popup_background_type == 1) ? 'url(image/catalog/ocdevwizard/price_alert/background/bg_7.png)' : '#000000'
        });

        $('#ocdw_price_alert-sidebar .ocdw_price_alert-sidebar-body').html(data);
        $('#ocdw_price_alert-sidebar').addClass('sidebar-active');
      }
    });
  }
}

function ocdw_price_alert_prepare_form(options) {
  let block = options.a || '';

  $(block).each(function () {
    if (typeof $(this).data('mask') !== 'undefined') {
      let that = this;
      
      ocdw_price_alert_load_js('catalog/view/javascript/ocdevwizard/helper/inputmask/inputmask.min.js', 'helper-inputmask-1',function() {
        ocdw_price_alert_load_js('catalog/view/javascript/ocdevwizard/helper/inputmask/inputmask.extensions.min.js', 'helper-inputmask-2',function() {
          ocdw_price_alert_load_js('catalog/view/javascript/ocdevwizard/helper/inputmask/jquery.inputmask.min.js', 'helper-inputmask-3',function() {
            $(that).find('input').inputmask($(that).data('mask'), {showMaskOnHover: false});
          });
        });
      });
    }
  });
}

function ocdw_price_alert_load_js(src, src_type, callback) {
  var element = ((document.getElementById(src_type+'-js')) ? true:false);

  if (!element) {
    var s = document.createElement('script');
    
    s.src = src;
    s.id = src_type+'-js';
    s.onreadystatechange = s.onload = function () {
      var state = s.readyState;
      if (!callback.done && (!state || /loaded|complete/.test(state))) {
        callback.done = true;
        callback();
      }
    };
    
    document.getElementsByTagName('head')[0].appendChild(s);
  } else {
    callback.done = true;
    callback();
  }
}

function ocdw_price_alert_load_css(src, src_type, callback) {
  var element = ((document.getElementById(src_type+'-css')) ? true:false);

  if (!element) {
    var s = document.createElement('link');
    
    s.rel = 'stylesheet';
    s.type = 'text/css';
    s.href = src;
    s.id = src_type+'-css';
    s.onreadystatechange = s.onload = function () {
      var state = s.readyState;
      if (!callback.done && (!state || /loaded|complete/.test(state))) {
        callback.done = true;
        callback();
      }
    };
    
    document.getElementsByTagName('head')[0].appendChild(s);
  } else {
    callback.done = true;
    callback();
  }
}