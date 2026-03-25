"user strict";

$(document).ready(function () {

  //menu top fixed bar
  var fixed_top = $(".header-section");
  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 220) {
      fixed_top.addClass("menu-fixed animated fadeInDown");
      fixed_top.removeClass("slideInUp");
      $("body").addClass("body-padding");
    } else {
      fixed_top.removeClass("menu-fixed fadeInDown");
      fixed_top.addClass("slideInUp");
      $("body").removeClass("body-padding");
    }
  });
  //menu top fixed bar

  //--Header Menu
  $(".header-bar").on("click", function (e) {
    $(".main-menu, .header-bar").toggleClass("active");
  });
  $(".main-menu li a").on("click", function (e) {
    var element = $(this).parent("li");
    if (element.hasClass("open")) {
      element.removeClass("open");
      element.find("li").removeClass("open");
      element.find("ul").slideUp(300, "swing");
    } else {
      element.addClass("open");
      element.children("ul").slideDown(300, "swing");
      element.siblings("li").children("ul").slideUp(300, "swing");
      element.siblings("li").removeClass("open");
      element.siblings("li").find("li").removeClass("open");
      element.siblings("li").find("ul").slideUp(300, "swing");
    }
  });
  $(".scrollToTop").on("click", function () {
    $("html, body").animate({
      scrollTop: 0,
    },
      700
    );
    return false;
  });
  //--Header Menu--

  //search-area-start-here
  var $searchWrap = $(".search-wrap");
  var $navSearch = $(".nav-search");
  var $searchClose = $("#search-close");

  $(".search-trigger").on("click", function (e) {
    e.preventDefault();
    $searchWrap.animate({ opacity: "toggle" }, 500);
    $navSearch.add($searchClose).addClass("open");
  });

  $(".search-close").on("click", function (e) {
    e.preventDefault();
    $searchWrap.animate({ opacity: "toggle" }, 500);
    $navSearch.add($searchClose).removeClass("open");
  });

  function closeSearch() {
    $searchWrap.fadeOut(200);
    $navSearch.add($searchClose).removeClass("open");
  }

  $(document.body).on("click", function (e) {
    closeSearch();
  });

  $(".search-trigger, .main-search-input").on("click", function (e) {
    e.stopPropagation();
  });
  //search-area-end-here

  // Hide & show a div js area start here ***
  $(document).ready(function () {
    $(document).on("click", ".share-btn", function () {
      var target = $(this).data("target");
      $("#" + target).toggle();
    });
  });
  // Hide & show a div js area end here ***

  // Hide & show js area start here ***
  $(document).ready(function () {
    $(document).on("click", "#openButton", function () {
      $("#targetElement").removeClass("side_bar_hidden");
    });
    $(document).on("click", "#closeButton", function () {
      $("#targetElement").addClass("side_bar_hidden");
    });
  });
  // Hide & show js area end here ***

  // Banner three slider area end here ***
  var sliderActive2 = ".banner__slider";
  var sliderInit2 = new Swiper(sliderActive2, {
    loop: true,
    slidesPerView: 1,
    effect: "fade",
    speed: 3000,
    autoplay: {
      delay: 7000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".arry__prev",
      prevEl: ".arry__next",
    },
  });
  // Here this is use for animate ***
  function animated_swiper(selector, init) {
    var animated = function animated() {
      $(selector + " [data-animation]").each(function () {
        var anim = $(this).data("animation");
        var delay = $(this).data("delay");
        var duration = $(this).data("duration");
        $(this)
          .removeClass("anim" + anim)
          .addClass(anim + " animated")
          .css({
            webkitAnimationDelay: delay,
            animationDelay: delay,
            webkitAnimationDuration: duration,
            animationDuration: duration,
          })
          .one("animationend", function () {
            $(this).removeClass(anim + " animated");
          });
      });
    };
    animated();
    init.on("slideChange", function () {
      $(sliderActive2 + " [data-animation]").removeClass("animated");
    });
    init.on("slideChange", animated);
  }
  animated_swiper(sliderActive2, sliderInit2);
  // Banner three slider area end here ***


  //project-slide-area-start-here
  var swiper = new Swiper(".project__wrapper", {
    spaceBetween: 30,
    speed: 1000,
    loop: "true",
    slidesPerView: 1,
    speed: 1000,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".dot",
      clickable: true,
    },
    breakpoints: {
      992: {
        slidesPerView: 3,
      },
    },
  });
  //project-slide-area-start-End

  //Donate-slide-area-start-here
  var swiper = new Swiper(".donate__wrapper", {
    spaceBetween: 30,
    speed: 1000,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    loop: "true",
    pagination: {
      el: ".dot",
      clickable: true,
    },
    breakpoints: {
      575: {
        slidesPerView: 1,
      },
      992: {
        slidesPerView: 3,
      },
    },
  });
  //Donate-slide-area-start-End

  //Testimonial-slide-area-start-here
  new Swiper('.testimonial__wrapper', {
    slidesPerView: 1,
    spaceBetween: 0,
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 5000,
    },
    pagination: {
        el: '.swiper-dot .dot',
        clickable: true,
    },
});

  //Testimonial-slide-area-start-End

  //Wow-animation-area-start-here
  new WOW().init();
  //Wow-animation-area-start-End

  // select area start here
  $('select').niceSelect();
  // select area end here

  //Back-to-top-area-start-here
  // Back-to-top-area-start-here
  var scrollPath = document.querySelector(".scroll-up path");

  // ✅ SAFETY CHECK (THIS FIXES THE ERROR)
  if (scrollPath) {
    var pathLength = scrollPath.getTotalLength();
    scrollPath.style.transition = scrollPath.style.WebkitTransition = "none";
    scrollPath.style.strokeDasharray = pathLength + " " + pathLength;
    scrollPath.style.strokeDashoffset = pathLength;
    scrollPath.getBoundingClientRect();
    scrollPath.style.transition = scrollPath.style.WebkitTransition =
      "stroke-dashoffset 10ms linear";

    var updatescroll = function () {
      var scroll = $(window).scrollTop();
      var height = $(document).height() - $(window).height();
      var dashoffset = pathLength - (scroll * pathLength) / height;
      scrollPath.style.strokeDashoffset = dashoffset;
    };

    updatescroll();
    $(window).on("scroll", updatescroll);
  }

  // Scroll-up button visibility
  var offset = 50;
  var duration = 950;

  jQuery(window).on("scroll", function () {
    if (jQuery(this).scrollTop() > offset) {
      jQuery(".scroll-up").addClass("active-scroll");
    } else {
      jQuery(".scroll-up").removeClass("active-scroll");
    }
  });

  // Scroll-up click
  jQuery(".scroll-up").on("click", function (event) {
    event.preventDefault();
    jQuery("html, body").animate(
      { scrollTop: 0 },
      duration
    );
    return false;
  });

  //Back-to-top-area-end-here

  //image-popup-area-start-here
  $('.video-btn').magnificPopup({
    type: 'iframe',
    callbacks: {
    }
  });
  $(".img-popup-footer").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });
  $(".img-popup").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });
  //image-popup-area-end-here

  //feature-slide-area-start-here
  var swiper = new Swiper(".feature__wrapper", {
    spaceBetween: 30,
    speed: 1000,
    loop: "true",
    slidesPerView: 1,
    speed: 1000,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".dot",
      clickable: true,
    },
    breakpoints: {
      992: {
        slidesPerView: 2,
      },
    },
  });
  //feature-slide-area-start-End


  //logo-slide-area-start-here
  $('.logo__wrapper').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 30,
    autoplayTimeout: 3000,
    smartSpeed: 700,
    navText: [
      '<i class="fa-solid fa-arrow-left-long"></i>',
      '<i class="fa-solid fa-arrow-right-long"></i>'
    ],
    responsive: {
      0: {
        items: 1
      },
      576: {
        items: 1
      },
      600: {
        items: 2
      },
      1000: {
        items: 4
      },
      1199: {
        items: 6
      }
    }
  })
  //logo-slide-area-start-End

  //shop-cart-area-start-start
  let quantity = 0;
  let price = 0;
  $(".cart-item-quantity-amount, .product-quant").html(quantity);
  $(".total-price, .product-pri").html(price.toFixed(2));
  $(".cart-increment, .cart-incre").on("click", function () {
    if (quantity <= 4) {
      quantity++;
      $(".cart-item-quantity-amount, .product-quant").html(quantity);
      var basePrice = $(".base-price, .base-pri").text();
      $(".total-price, .product-pri").html((basePrice * quantity).toFixed(2));
    }
  });

  $(".cart-decrement, .cart-decre").on("click", function () {
    if (quantity >= 1) {
      quantity--;
      $(".cart-item-quantity-amount, .product-quant").html(quantity);
      var basePrice = $(".base-price, .base-pri").text();
      $(".total-price, .product-pri").html((basePrice * quantity).toFixed(2));
    }
  });

  $(".cart-item-remove>a").on("click", function () {
    $(this).closest(".cart-item").hide(300);
  });
  //shop-cart-area-start-End

  //shop-single-area-start-start
  var swiper = new Swiper(".choose__slide__two", {
    speed: 1000,
    loop: true,
    spaceBetween: 10,
    slidesPerView: 5,
    freeMode: true,
    autoplay: true,
    watchSlidesProgress: true,
    navigation: {
      nextEl: ".right-arry",
      prevEl: ".left-arry",
    },
  });
  var swiper2 = new Swiper(".choose__slide__one", {
    speed: 1000,
    loop: "true",
    grabCursor: true,
    autoplay: true,
    navigation: {
      nextEl: ".right-arry",
      prevEl: ".left-arry",
    },
    thumbs: {
      swiper: swiper,
    },
  });
  //shop-single-area-start-End

  //contact form js
  $(function () {
    // Get the form.
    var form = $("#contact-form");
    // Get the messages div.
    var formMessages = $(".form-message");
    // Set up an event listener for the contact form.
    $(form).submit(function (e) {
      // Stop the browser from submitting the form.
      e.preventDefault();
      // Serialize the form data.
      var formData = $(form).serialize();
      // Submit the form using AJAX.
      $.ajax({
        type: "POST",
        url: $(form).attr("action"),
        data: formData,
      })
        .done(function (response) {
          // Make sure that the formMessages div has the 'success' class.
          $(formMessages).removeClass("error");
          $(formMessages).addClass("success");
          // Set the message text.
          $(formMessages).text(response);
          // Clear the form.
          $("#form input, #form textarea").val("");
        })
        .fail(function (data) {
          // Make sure that the formMessages div has the 'error' class.
          $(formMessages).removeClass("success");
          $(formMessages).addClass("error");
          // Set the message text.
          if (data.responseText !== "") {
            $(formMessages).text(data.responseText);
          } else {
            $(formMessages).text(
              "Oops! An error occured and your message could not be sent."
            );
          }
        });
    });
  });

  /*-------- Odometer Counter Start--------*/
  $(".odometer-item").each(function () {
    $(this).isInViewport(function (status) {
      if (status === "entered") {
        for (
          var i = 0;
          i < document.querySelectorAll(".odometer").length;
          i++
        ) {
          var el = document.querySelectorAll(".odometer")[i];
          el.innerHTML = el.getAttribute("data-odometer-final");
        }
      }
    });
  });
  /*-------- Odometer Counter End--------*/

  // Add payment amount area start here ***
  $(document).on("click", ".amount__btn", function () {
    // Remove the "active" class from all buttons
    $(".amount__btn").removeClass("active");

    // Add the "active" class to the clicked button
    $(this).addClass("active");

    // Get the text value of the clicked button
    var buttonValue = $(this).text();

    // Update the value attribute of the input element
    $(".addAmount-value").val(buttonValue);
  });
  // Add payment amount area end here ***

  // Payment button area start here ***
  $(document).on("click", ".cmn--btn", function () {
    // Check if the clicked button already has the "active" class
    if ($(this).hasClass("active")) {
      // If it does, remove the "active" class
      $(this).removeClass("active");
    } else {
      // If it doesn't, remove the "active" class from all buttons
      $(".cmn--btn").removeClass("active");
      // Add the "active" class to the clicked button
      $(this).addClass("active");
    }
  });
  // Payment button area end here ***

  $(function () {
    $('body').addClass('loaded');
  });
});

