<?php if($sets) { ?>
    <div class='sets' id='prd-sets'>

        <?php if ($sets_slider == 'swiper') { ?>
            <div class='sets-slider swiper'>
            <div class="swiper-wrapper">
        <?php } elseif($sets_slider == 'owl') { ?>
            <div class='sets-slider owl-carousel'>
        <?php } ?>

        <?php if($sets_orientation == 'hor') { ?>
            <?php include 'sets_hor_slider.tpl';?>
        <?php } else if($sets_orientation == 'ver') { ?>
            <?php include 'sets_ver_slider.tpl';?>
        <?php } ?>

        <?php if($sets_slider == 'swiper') { ?>
            </div>
            
              <div class="swiper-pagination"></div>

              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>

            </div>
        <?php } elseif($sets_slider == 'owl') { ?>
            </div>
        <?php } ?>

    </div>
    <script>
        $( document ).ready(function() {
            <?php if(!empty($sets_position)) { ?>
                <?php if ($sets_position == 'prepend' || $sets_position == 'append') { ?>
                    $('<?php echo $sets_selector; ?>').<?php echo $sets_position; ?>($('#prd-sets'));
                <?php } else { ?> 
                    $('#prd-sets').<?php echo $sets_position; ?>('<?php echo $sets_selector; ?>');
                <?php } ?>
            <?php } ?>
            <?php if ($sets_slider == 'swiper') { ?>
                new Swiper('.sets-slider',
                {
                    direction: 'horizontal',
                    slidesPerView: 1,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            <?php } elseif ($sets_slider == 'owl') { ?>
                $(".sets-slider").owlCarousel({
                    singleItem: true,
                    autoWidth: false,
                    navigation: true,
                    stopOnHover: true,
                    navigationText: ['<i class="fa fa-chevron-left fa-2x"></i>', '<i class="fa fa-chevron-right fa-2x"></i>'],
                    pagination: false
                });
            <?php } ?>
            helperv2.set_decimal_place(<?php echo $decimal_place; ?>);
        });
        if (typeof successCartAddTemplateDefault === "undefined") { 
            function successCartAddTemplateDefault(json) { 
                <?php echo $sets_js_cart_add; ?> 
            }
        }
    </script>
    <style><?php echo $sets_custom_css;?></style>
<?php } ?>