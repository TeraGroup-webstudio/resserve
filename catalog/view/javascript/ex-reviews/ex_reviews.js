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

function addDrag(selector) {
  const sliders = document.getElementsByClassName(selector);

  for (i = 0; i < sliders.length; i++) {
    const slider = sliders[i];
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
      isDown = true;
      
      startX = e.pageX - slider.offsetLeft;
      scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('mouseleave', () => {
      isDown = false;
      slider.classList.remove('active');
    });
    slider.addEventListener('mouseup', () => {
      isDown = false;
      slider.classList.remove('active');
    });
    slider.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      slider.classList.add('active');
      e.preventDefault();
      const x = e.pageX - slider.offsetLeft;
      const walk = (x - startX) * 3; //scroll-fast
      slider.scrollLeft = scrollLeft - walk;
    });
  }
}


$(document).on('click', '.modal-thumbnail',  function(){
  var review_id = $(this).data('id');
  var image_id = $(this).data('image');
  $('#modal-id').val(review_id);
  showSlides(image_id);

  //$('#myModal .ex-modal-image').html('<image src="' + image + '" class="modal-review-image">');
  $('#myModal').modal('show');
  $('#myModal .modal-review-info').load('index.php?route=product/extended_reviews/getReviewInfo&review_id=' + review_id);
});


function getReviewInfo(review_id){

}


// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  slideIndex = n;
  var i;
  var slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  review_id = $(slides[slideIndex-1]).data('id');
  modal_id = $('#modal-id').val();
  if(review_id != modal_id){
    $('#myModal .modal-review-info').load('index.php?route=product/extended_reviews/getReviewInfo&review_id=' + review_id);
    $('#modal-id').val(review_id);
  }
  slides[slideIndex-1].style.display = "block";
}

function addTouch(selector) {
  const slider = document.getElementsByClassName(selector)[0];
    let isDown = false;
    let startX;

    if(slider){
      slider.addEventListener('touchstart', function(e){
        isDown = true;
        startX = e.changedTouches[0].screenX;
      });
      slider.addEventListener('touchend', function(e){
        var endX = e.changedTouches[0].screenX;
        if(startX > endX + 5){
          plusSlides(1);
        }else if(startX < endX - 5){
          plusSlides(-1);
        }
      });
      slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
      });
      slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active');
      });
      slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX);
        if(walk > 50 && slider.classList.contains('active')){
          plusSlides(-1);
          slider.classList.remove('active');
          return;
        } else if(walk < -50 && slider.classList.contains('active')){
          plusSlides(1);
          slider.classList.remove('active');
          return;
        }
      });
    }
  }

function youtube_parser(url) {
  var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
  var match = url.match(regExp);
  return (match && match[7].length == 11) ? match[7] : false;
}

function removeVideo(video_id){
  video_links[video_id] = null;
  $('#video-' + video_id).remove();
}

function alertRemove(){
  $('.ex-alert').remove();
}