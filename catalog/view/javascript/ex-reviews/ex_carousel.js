function addMagnific(selector) {
  $(selector).magnificPopup({
    type: 'image',
    delegate: 'a',
    gallery: {
      enabled: true,
    },
    callbacks: {
      beforeOpen: function () {
        var magnificPopup = $.magnificPopup.instance,
          cur = magnificPopup.st.el.focus();
      },
      open: function () {
        $('.container').addClass('blur');
      },
      close: function () {
        $('.container').removeClass('blur');
      }
    }
  });
}

function addMagnificVideo(selector) {
  $(selector).magnificPopup({
    type: 'iframe',
    mainClass: 'mfp-fade',
    preloader: true,
    callbacks: {
      beforeOpen: function () {
        var magnificPopup = $.magnificPopup.instance,
          cur = magnificPopup.st.el.focus();
      },
      open: function () {
        $('.container').addClass('blur');
      },
      close: function () {
        $('.container').removeClass('blur');
      }
    }
  });
}

function alertRemove(){
  $('.ex-alert').remove();
}