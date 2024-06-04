<!--
##========================================================##
## @author    : OCdevWizard                               ##
## @contact   : ocdevwizard@gmail.com                     ##
## @support   : http://help.ocdevwizard.com               ##
## @license   : Distributed on an "AS IS" basis           ##
## @copyright : (c) OCdevWizard. OCdevWizard Helper, 2014 ##
##========================================================##
-->
<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
  <meta charset="UTF-8"/>
  <title><?php echo $title; ?></title>
  <base href="<?php echo $base; ?>"/>
  <?php if ($description) { ?>
  <meta name="description" content="<?php echo $description; ?>"/>
  <?php } ?>
  <?php if ($keywords) { ?>
  <meta name="keywords" content="<?php echo $keywords; ?>"/>
  <?php } ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" integrity="sha256-h0cGsrExGgcZtSZ/fRz4AwV+Nn6Urh/3v3jFRQ0w9dQ=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw=" crossorigin="anonymous"></script>
  <link type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet"/>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha384-pPttEvTHTuUJ9L2kCoMnNqCRcaMPMVMsWVO+RLaaaYDmfSP5//dP6eKRusbPcqhZ" crossorigin="anonymous"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
  <link href="//ocdevwizard.com/helper/main/bootstrap.css" type="text/css" rel="stylesheet"/>
  <script type="text/javascript" src="https://use.fontawesome.com/f781f96cd8.js"></script>
  <script src="//ocdevwizard.com/helper/datetimepicker/moment/moment.min.js" type="text/javascript"></script>
  <script src="//ocdevwizard.com/helper/datetimepicker/moment/moment-with-locales.min.js" type="text/javascript"></script>
  <script src="//ocdevwizard.com/helper/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="//ocdevwizard.com/helper/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen"/>
  <link type="text/css" href="//ocdevwizard.com/helper/main/stylesheet.css" rel="stylesheet" media="screen"/>
  <?php foreach ($styles as $style) { ?>
  <link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>"/>
  <?php } ?>
  <?php foreach ($links as $link) { ?>
  <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>"/>
  <?php } ?>
  <?php foreach ($scripts as $script) { ?>
  <script type="text/javascript" src="<?php echo $script; ?>"></script>
  <?php } ?>
</head>
<body>
<script>
  function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
      var part = query[1].split('&');

      for (i = 0; i < part.length; i++) {
        var data = part[i].split('=');

        if (data[0] && data[1]) {
          value[data[0]] = data[1];
        }
      }

      if (value[key]) {
        return value[key];
      } else {
        return '';
      }
    }
  }

  $(document).ready(function () {
    $('button[type=\'submit\']').on('click', function () {
      $("form[id*='form-']").submit();
    });

    $('.text-danger').each(function () {
      var element = $(this).parent().parent();

      if (element.hasClass('form-group')) {
        element.addClass('has-error');
      }
    });

    $('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

    $(document).ajaxStop(function () {
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
    });

    $.event.special.remove = {
      remove: function (o) {
        if (o.handler) {
          o.handler.apply(this, arguments);
        }
      }
    }

    $('[data-toggle=\'tooltip\']').on('remove', function () {
      $(this).tooltip('destroy');
    });

    $(document).on('click', '[data-toggle=\'tooltip\']', function (e) {
      $('body > .tooltip').remove();
    });

    $(document).on('click', 'a[data-toggle=\'image\']', function (e) {
      var $element = $(this);
      var $popover = $element.data('bs.popover');

      e.preventDefault();

      $('a[data-toggle="image"]').popover('destroy');

      if ($popover) {
        return;
      }

      $element.popover({
        html: true,
        placement: 'right',
        trigger: 'manual',
        content: function () {
          return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
        }
      });

      $element.popover('show');

      $('#button-image').on('click', function () {
        var $button = $(this);
        var $icon = $button.find('> i');

        $('#dialog').remove();

        $('body').prepend('<div id="dialog"><iframe src="index.php?route=common/filemanager&token=' + getURLVar('token') + '&field=' + encodeURIComponent($element.parent().find('input').attr('id')) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

        $('#dialog').dialog({
          title: 'File manager',
          close: function (event, ui) {
            if ($element.parent().find('input').attr('value')) {
              $.ajax({
                url: 'index.php?route=common/filemanager/image&token=' + getURLVar('token') + '&image=' + encodeURIComponent($element.parent().find('input').attr('value')),
                dataType: 'text',
                success: function (text) {
                  $element.find('input').attr('value', text);
                  $element.find('img').attr('src', text);
                }
              });
            }
          },
          bgiframe: false,
          width: 800,
          height: 400,
          resizable: false,
          modal: false
        });

        $element.popover('destroy');
      });

      $('#button-clear').on('click', function () {
        $element.find('img').attr('src', $element.find('img').attr('data-placeholder'));

        $element.parent().find('input').val('');

        $element.popover('destroy');
      });
    });
  });

  (function ($) {
    $.fn.autocomplete = function (option) {
      return this.each(function () {
        var $this = $(this);
        var $dropdown = $('<ul class="dropdown-menu" />');

        this.timer = null;
        this.items = [];

        $.extend(this, option);

        $this.attr('autocomplete', 'off');

        $this.on('focus', function () {
          this.request();
        });

        $this.on('blur', function () {
          setTimeout(function (object) {
            object.hide();
          }, 200, this);
        });

        $this.on('keydown', function (event) {
          switch (event.keyCode) {
            case 27: // escape
              this.hide();
              break;
            default:
              this.request();
              break;
          }
        });

        this.click = function (event) {
          event.preventDefault();

          var value = $(event.target).parent().attr('data-value');

          if (value && this.items[value]) {
            this.select(this.items[value]);
          }
        }

        this.show = function () {
          var pos = $this.position();

          $dropdown.css({
            top: pos.top + $this.outerHeight(),
            left: pos.left
          });

          $dropdown.show();
        }

        this.hide = function () {
          $dropdown.hide();
        }

        this.request = function () {
          clearTimeout(this.timer);

          this.timer = setTimeout(function (object) {
            object.source($(object).val(), $.proxy(object.response, object));
          }, 200, this);
        }

        this.response = function (json) {
          var html = '';
          var category = {};
          var name;
          var i = 0, j = 0;

          if (json.length) {
            for (i = 0; i < json.length; i++) {
              this.items[json[i]['value']] = json[i];

              if (!json[i]['category']) {
                html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
              } else {
                name = json[i]['category'];
                if (!category[name]) {
                  category[name] = [];
                }

                category[name].push(json[i]);
              }
            }

            for (name in category) {
              html += '<li class="dropdown-header">' + name + '</li>';

              for (j = 0; j < category[name].length; j++) {
                html += '<li data-value="' + category[name][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[name][j]['label'] + '</a></li>';
              }
            }
          }

          if (html) {
            this.show();
          } else {
            this.hide();
          }

          $dropdown.html(html);
        }

        $dropdown.on('click', '> li > a', $.proxy(this.click, this));
        $this.after($dropdown);
      });
    }
  })(window.jQuery);
</script>
<style>.ui-front{z-index:10000}</style>
<div id="container"
<?php if (!$is_helper_page) { ?>style="padding-top:100px"<?php } ?>>
