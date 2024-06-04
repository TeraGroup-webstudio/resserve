<?php echo $header; ?>
<?php echo $column_left; ?>
<!--
##========================================================##
## @author    : OCdevWizard                               ##
## @contact   : ocdevwizard@gmail.com                     ##
## @support   : http://help.ocdevwizard.com               ##
## @license   : Distributed on an "AS IS" basis           ##
## @copyright : (c) OCdevWizard. OCdevWizard Helper, 2014 ##
##========================================================##
-->
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right" id="top-nav-line">
				<div class="btn-group">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-life-ring"></i>&nbsp;&nbsp;<?php echo $button_need_help; ?>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><a onclick="open_support();"><i class="fa fa-envelope-o"></i> <?php echo $button_need_help_email; ?></a></li>
            <li><a href="http://help.ocdevwizard.com/" target="_blank"><i class="fa fa-ticket"></i> <?php echo $button_need_help_ticket; ?></li>
          </ul>
        </div>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
		</div>
	</div>
	<div class="container-fluid" id="top-alerts">
		<div class="row">
			<div class="col-sm-12">
				<?php if ($accessibility) { ?>
					<div class="panel panel-default ocdevwizard-panel-default" id="ocdevwizard-installed-produts">
						<div class="panel-heading">
							<h2 class="panel-title"><?php echo $text_in_your_store; ?></h2>
						</div>
						<div class="panel-body">
							<?php if ($installed_products) { ?>
								<div class="ocdevwizard-produts">
									<?php foreach ($installed_products as $product) { ?>
										<div <?php if (!$product['compatible']) { ?>class="not-compatible" data-toggle="tooltip" data-placement="bottom" title="<?php echo $button_not_completable; ?>"<?php } ?>>
											<?php if (!$product['compatible']) { ?>
												<img src="<?php echo $product['img']; ?>" alt="<?php echo $product['title']; ?>"/>
											<?php } else { ?>
												<a href="<?php echo $product['href']; ?>">
													<img src="<?php echo $product['img']; ?>" alt="<?php echo $product['title']; ?>"/>
												</a>
											<?php } ?>
										</div>
									<?php } ?>
								</div>
							<?php } else { ?>
								<div class="alert alert-danger" role="alert"><i class="fa fa-info-circle"></i> <?php echo $error_empty_installed_products; ?></div>
							<?php } ?>
						</div>
					</div>
					<?php if ($available_update_products) { ?>
						<div class="panel panel-default ocdevwizard-panel-default" id="ocdevwizard-available-update-produts">
							<div class="panel-heading">
								<h2 class="panel-title"><?php echo $text_available_new_version; ?><span><i class="fa fa-angle-up"></i><i class="fa fa-angle-down"></i></span></h2>
							</div>
							<div class="panel-body">
								<div class="ocdevwizard-produts">
									<?php foreach ($available_update_products as $product) { ?>
										<div data-toggle="tooltip" data-placement="bottom" data-promo-product-id="<?php echo $product['extension_id']; ?>" <?php if (!$product['compatible']) { ?>class="not-compatible" title="<?php echo $button_not_completable; ?>"<?php } else { ?>title="<?php echo $button_read_more; ?>"<?php } ?>>
											<img src="<?php echo $product['img']; ?>" alt="<?php echo $product['title']; ?>" />
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if ($available_upgrade_products) { ?>
						<div class="panel panel-default ocdevwizard-panel-default" id="ocdevwizard-available-upgrade-produts">
							<div class="panel-heading">
								<h2 class="panel-title"><?php echo $text_improve_to_pro_plus_version; ?><span><i class="fa fa-angle-up"></i><i class="fa fa-angle-down"></i></span></h2>
							</div>
							<div class="panel-body">
								<div class="ocdevwizard-produts">
									<?php foreach ($available_upgrade_products as $product) { ?>
										<div data-toggle="tooltip" data-placement="bottom" data-promo-product-id="<?php echo $product['extension_id']; ?>" <?php if (!$product['compatible']) { ?>class="not-compatible" title="<?php echo $button_not_completable; ?>"<?php } else { ?>title="<?php echo $button_read_more; ?>"<?php } ?>>
											<img src="<?php echo $product['img']; ?>" alt="<?php echo $product['title']; ?>" />
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if ($available_products) { ?>
						<div class="panel panel-default ocdevwizard-panel-default" id="ocdevwizard-available-produts">
							<div class="panel-heading">
								<h2 class="panel-title"><?php echo $text_you_also_may_like; ?><span><i class="fa fa-angle-up"></i><i class="fa fa-angle-down"></i></span></h2>
							</div>
							<div class="panel-body">
								<div class="ocdevwizard-produts">
									<?php foreach ($available_products as $product) { ?>
										<div data-toggle="tooltip" data-placement="bottom" data-promo-product-id="<?php echo $product['extension_id']; ?>" <?php if (!$product['compatible']) { ?>class="not-compatible" title="<?php echo $button_not_completable; ?>"<?php } else { ?>title="<?php echo $button_read_more; ?>"<?php } ?>>
											<img src="<?php echo $product['img']; ?>" alt="<?php echo $product['title']; ?>" />
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } else { ?>
					<div class="alert alert-danger" role="alert"><i class="fa fa-info-circle"></i> <?php echo $error_license_server; ?></div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
$(document).delegate('div[data-promo-product-id]', 'click', function() {
  var element = this;
  open_popup('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/get_promo_products&<?php echo $token; ?>&extension_id='+$(element).attr('data-promo-product-id'));
});

function open_support() {
  open_popup('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/need_help&<?php echo $token; ?>');
}

function open_popup(url) {
  notify_close();
  
  $.magnificPopup.open({
    tLoading: '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
    items: {
      src: url,
      type: 'ajax'
    },
    showCloseBtn: false,
	  closeOnBgClick: false,
    mainClass: 'mfp-move-from-left',
    callbacks: {
      beforeOpen: function() {
        this.wrap.removeAttr('tabindex');
        $('[data-toggle=\'tooltip\']').tooltip('destroy');
        $('.tooltip.fade.top.in').remove();
      },
      open: function() {
        $('.mfp-content').addClass('mfp-with-anim');
      },
      close: function() {
        $('[data-toggle=\'tooltip\']').tooltip('destroy');
        $('.tooltip.fade.top.in').remove();
        setTimeout(function(){
          $('.mfp-move-from-left.mfp-removing.mfp-bg').css('opacity', '0')
        },500);
        $('.mfp-content').addClass('mfp-with-anim');
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
        setTimeout(function(){
          notify_close();
        }, 3000);
      }
    },
    removalDelay: 500
  });
}

function show_explanation(options) {
  var element = options.a || '';
  $(element).parent().next().find('div.alert.alert-info').slideToggle();
}
</script>
<?php if ($available_products) { ?>
	<script>
    $('#ocdevwizard-available-produts > div').eq(1).toggleClass(window.localStorage.ocdev_t1);
    $('#ocdevwizard-available-produts > div').eq(0).toggleClass(window.localStorage.ocdev_t1);
    
    $('#ocdevwizard-available-produts > div').eq(0).on('click', function () {
      if (window.localStorage.ocdev_t1 != "active") {
        $('#ocdevwizard-available-produts > div').eq(1).toggleClass("active", true);
        $('#ocdevwizard-available-produts > div').eq(0).toggleClass("active", true);
        window.localStorage.ocdev_t1 = "active";
      } else {
        $('#ocdevwizard-available-produts > div').eq(1).toggleClass("active", false);
        $('#ocdevwizard-available-produts > div').eq(0).toggleClass("active", false);
        window.localStorage.ocdev_t1 = "";
      }
    });
    
    $('#ocdevwizard-available-update-produts > div').eq(1).toggleClass(window.localStorage.ocdev_t2);
    $('#ocdevwizard-available-update-produts > div').eq(0).toggleClass(window.localStorage.ocdev_t2);
    
    $('#ocdevwizard-available-update-produts > div').eq(0).on('click', function () {
      if (window.localStorage.ocdev_t2 != "active") {
        $('#ocdevwizard-available-update-produts > div').eq(1).toggleClass("active", true);
        $('#ocdevwizard-available-update-produts > div').eq(0).toggleClass("active", true);
        window.localStorage.ocdev_t2 = "active";
      } else {
        $('#ocdevwizard-available-update-produts > div').eq(1).toggleClass("active", false);
        $('#ocdevwizard-available-update-produts > div').eq(0).toggleClass("active", false);
        window.localStorage.ocdev_t2 = "";
      }
    });
    
    $('#ocdevwizard-available-upgrade-produts > div').eq(1).toggleClass(window.localStorage.ocdev_t3);
    $('#ocdevwizard-available-upgrade-produts > div').eq(0).toggleClass(window.localStorage.ocdev_t3);
    
    $('#ocdevwizard-available-upgrade-produts > div').eq(0).on('click', function () {
      if (window.localStorage.ocdev_t3 != "active") {
        $('#ocdevwizard-available-upgrade-produts > div').eq(1).toggleClass("active", true);
        $('#ocdevwizard-available-upgrade-produts > div').eq(0).toggleClass("active", true);
        window.localStorage.ocdev_t3 = "active";
      } else {
        $('#ocdevwizard-available-upgrade-produts > div').eq(1).toggleClass("active", false);
        $('#ocdevwizard-available-upgrade-produts > div').eq(0).toggleClass("active", false);
        window.localStorage.ocdev_t3 = "";
      }
    });
	</script>
<?php } ?>
<?php echo $footer; ?>