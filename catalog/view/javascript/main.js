window.addEventListener('DOMContentLoaded', (event) => {
    const windowInnerWidth = window.innerWidth;
//Readmore block
  const readMoreButtons = document.querySelectorAll('.read__more');
  if(readMoreButtons){
  readMoreButtons.forEach(button => {
    const readMorebutton = button.querySelector('button');
    const readMoreContent = button.querySelector('.read__more--text');
    const readMoreContainer = button.querySelector('.readmore__block');
      readMorebutton.addEventListener('click', function () {
        button.classList.toggle('open');
        readMoreContent.classList.toggle('open');
        readMoreContainer.classList.toggle('open');
      });
  });
  }
  const productAttributes = document.getElementById('attributes_product');
  if (productAttributes) {
    let button = productAttributes.querySelector('.attribute__more--button button');
    let content = productAttributes.querySelector('.attributemore__block--large');
    if (content){
        button.addEventListener('click', function () {
            button.classList.toggle('open');
            content.classList.toggle('open');
          });
    }
  }
  //Products carousell
  let productsCarousel = document.querySelectorAll(".product__carousel");
  if(productsCarousel){
  productsCarousel.forEach((carouselP) => {
      let swiperCarouselP = carouselP.getElementsByClassName("swiper-container")[0];
      let nx = carouselP.getElementsByClassName("product__carousel--next")[0];
      let pr = carouselP.getElementsByClassName("product__carousel--prev")[0];
      new Swiper(swiperCarouselP, {navigation: {nextEl: nx, prevEl: pr}, slidesPerView: 6,watchSlidesProgress: true,spaceBetween: 0, autoplay: {delay:5000, disableOnInteraction: false, }, speed: 800,
        breakpoints: {
            320: {
                slidesPerView: 2,
              },
            480: {
                slidesPerView: 3,
              },
            768: {
                slidesPerView: 4,
              },
              1023: {
                slidesPerView: 6,
              },
        }});
  });
  }
  //Hero block carousell
  let heroCarousel = document.querySelectorAll(".hero__slider");
  if(heroCarousel){
  heroCarousel.forEach((carouselH) => {
      let swiperCarouselH = carouselH.getElementsByClassName("swiper-container")[0];
      // let nx = carouselP.getElementsByClassName("product__carousel--next")[0];
      // let pr = carouselP.getElementsByClassName("product__carousel--prev")[0];
      new Swiper(swiperCarouselH, {pagination: {el: '.hero__slider--pagination',type: 'bullets',clickable:true},slidesPerView: 1,watchSlidesProgress: true,spaceBetween: 0, autoplay: {delay: 5000, disableOnInteraction: false, }, speed: 800});
  });
  }
  //Manufacturers carousell
  let heroManufacturerCarousel = document.querySelectorAll(".hero__manufacturers");
  if(heroManufacturerCarousel){
  heroManufacturerCarousel.forEach((carouselManufacturer) => {
      let swiperCarouselManufacturer = carouselManufacturer.getElementsByClassName("swiper-container")[0];
      let nx = carouselManufacturer.getElementsByClassName("product__carousel--next")[0];
      let pr = carouselManufacturer.getElementsByClassName("product__carousel--prev")[0];
      new Swiper(swiperCarouselManufacturer, {navigation: {nextEl: nx, prevEl: pr},grid: {rows: 2,},slidesPerView: 7,watchSlidesProgress: true,spaceBetween: 0, autoplay: {delay: 5000, disableOnInteraction: false, }, speed: 800});
  });
  }
  //Catalog menu
    if(windowInnerWidth > 991){
    const homePage = document.getElementById('common-home');
    const heroBlock = document.getElementsByClassName('hero');
    if (homePage && heroBlock.length > 0) {
        // Отримуємо перший елемент з класом 'hero'
        const firstHeroBlock = heroBlock[0];

        // Отримуємо блоки, які ви хочете перемістити
        var sourceBlock = document.getElementsByClassName('header__catalog')[0];
        var defaultBlock = document.getElementById('header__wrapper');
        var destinationBlock = document.getElementById('hero__slider--container');
        var sourceBlockButton = sourceBlock.getElementsByClassName('header__catalog--button')[0];
        var catalogMenu = sourceBlock.getElementsByClassName('catalog__menu')[0];
        // Переміщуємо блоки
        if (sourceBlock && destinationBlock) {
            destinationBlock.prepend(sourceBlock);
            sourceBlockButton.setAttribute('disabled', 'disabled');
            catalogMenu.classList.add('__open');
        }

        // Відслідковуємо подію прокрутки
        window.addEventListener('scroll', function() {
            if (window.scrollY >= 700) { // Якщо сторінку прокручено на 200 пікселів
                // Повертаємо блок назад в defaultBlock
                var secondChild = defaultBlock.children[1];
                defaultBlock.insertBefore(sourceBlock, secondChild);
                sourceBlockButton.removeAttribute('disabled', 'disabled');
                catalogMenu.classList.remove('__open');
            } else {
               destinationBlock.prepend(sourceBlock);
                sourceBlockButton.setAttribute('disabled', 'disabled');
                catalogMenu.classList.add('__open');
            }
        });
    }
    } else {
        var sourceBlock = document.getElementsByClassName('header__catalog')[0];
        var sourceMenuBlock = document.getElementsByClassName('main__menu--header')[0];
        if (sourceBlock && sourceMenuBlock) {
            sourceMenuBlock.after(sourceBlock);
        }
    }
//Footer menu slidedown
if(windowInnerWidth < 769){
    const footerBlockTitle = document.querySelectorAll('.footer__block--title');
    footerBlockTitle.forEach((footerBlock) => {
        footerBlock.addEventListener('click', function () {
            const footerBlockElem = footerBlock.parentElement;
            const footerBlockList = footerBlockElem.querySelector('.footer__block--list');
            console.log(footerBlockList);
            $(footerBlockList).slideToggle();
        });
    });
}
//Burger menu
    const burgerButton = document.getElementsByClassName('header__menu--button')[0];
    const menuBurger = document.getElementsByClassName('main__menu--wrapper')[0];
    const menuBurgerBody = document.getElementsByClassName('main__menu--body')[0];
    const closeBurger = document.getElementsByClassName('main__menu--close')[0];

    burgerButton.addEventListener('click', function () {
        callBurger();
    });

    closeBurger.addEventListener('click', function () {
        callBurger();
    });

    document.body.addEventListener('click', function (e) {
        if (e.target === menuBurger && e.target !== menuBurgerBody){
            callBurger();
        }
    
    });

    function callBurger() {
        menuBurger.classList.toggle('open');
        document.body.classList.toggle('lock');
    }
});
$(document).ready(function() {
$('body').on('click', '.header__catalog--button', function(e){
    e.preventDefault();
    var catalogMenu = $(this).parent().find('#catalog__menu');
    var mainMenu = $(this).parent().parent();
    catalogMenu.toggleClass('__open');
    console.log(mainMenu);
    if (catalogMenu.hasClass('__open')) {
        if(!mainMenu.hasClass('main__menu--body')){
        $('<div class="backdrop"></div>').appendTo('body');
        }
        catalogMenu.slideDown(); // Замість '.your-element' вставте селектор вашого елемента
        // або
        // parentElement.find('.your-element').fadeIn(); // для ефекту засвітлення
    } else {
        if(!mainMenu.hasClass('main__menu--body')){
        $('.backdrop').remove();
        }
        catalogMenu.slideUp(); // Замість '.your-element' вставте селектор вашого елемента
        // або
        // parentElement.find('.your-element').fadeOut(); // для ефекту затемнення
    }
});
$('body').on('click', '.sub__categories--show', function(e){
    e.preventDefault();
    var parentElement = $(this).parent().parent();
    parentElement.toggleClass('__open');
    if (parentElement.hasClass('__open')) {
        parentElement.find('.sub__categories').slideDown(); // Замість '.your-element' вставте селектор вашого елемента
        // або
        // parentElement.find('.your-element').fadeIn(); // для ефекту засвітлення
    } else {
        parentElement.find('.sub__categories').slideUp(); // Замість '.your-element' вставте селектор вашого елемента
        // або
        // parentElement.find('.your-element').fadeOut(); // для ефекту затемнення
    }
});
//Show all subcategories
    const showSubcategories = document.getElementById('show__subcategories');
    const subcategoriesWrapper = document.getElementsByClassName('__long')[0];
    if (showSubcategories){
    showSubcategories.addEventListener('click', function () {
        subcategoriesWrapper.classList.remove('__long');
        this.parentElement.classList.add('hidden');
    });
    }
})

