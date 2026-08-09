
// aos js
AOS.init({
  duration: 1200,
});
// mobile version
AOS.init({disable: 'mobile'});
	AOS.init({
	disable: function() {
	  var maxWidth = 800;
	  return window.innerWidth < maxWidth;
	}
});

$(document).ready(function(){
  $tigger = ".sub-dropdown > a";
  $openBox = ".sub-menu"
  $($tigger).click(function(){
    $($openBox).toggleClass("submenuOpen");
  });
});

// brands slider js

$('#brands-slider').slick({
  dots: false,
  arrows: false,
  autoplay: true,
  autoplaySpeed: 0,
  //infinite: false,
  speed: 8000,
  slidesToShow: 6,
  slidesToScroll: 1,
  cssEase: 'linear',
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
        //infinite: true,
        //dots: true
      }
    },
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }

  ]
});


// partners slider js

$('#banner-slider').slick({
  dots: false,
  arrows: false,
  autoplay: true,
  autoplaySpeed: 3000,
  //infinite: false,
  speed: 300,
  slidesToShow: 1,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        //infinite: true,
        //dots: true
      }
    },
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }

  ]
});


/*## Login register tab ##*/ 
$(document).ready(function () {
    $('#logregNav .nav-link').on('click', function (e) {
      e.preventDefault();

      // Activate the clicked tab
      $('#logregNav .nav-link').removeClass('active');
      $(this).addClass('active');

      // Get which tab was clicked
      var tabId = $(this).data('tab');

      // Hide all tab panes
      $('#tabContentOne .tab-pane, #tabContentTwo .tab-pane').removeClass('show active');

      // Show matching tab panes in both content sections
      $('#'+tabId+'-pane-1, #'+tabId+'-pane-2').addClass('show active');
    });
});


$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    input = $(this).parent().find("input");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

$('.floating-btn-tigger').on('click', function () {
	$('.floating-btn-wrap').toggleClass('open');
});

/*## Login register tab end ##*/ 


/**/ 
$(document).ready(function () {
  $('.accordion-btn').on('click', function () {
    // Toggle class on the button itself (for rotate icon or styling)
    $(this).toggleClass('active');

    // Toggle the accordion body (next .comment-accordion-body)
    $(this)
      .closest('.forum-list') // Go up to the main wrapper
      .find('.comment-accordion-body') // Find the body inside it
      .slideToggle(); // Show/hide with animation
  });
});


$('.sidebar-tigger').on('click', function () {
  $('.user-dashboard-wrapper').toggleClass('menuopen');
});