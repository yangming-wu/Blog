import "./jquery_1_7_2.js"
// import "../../js/modernizr.js"
import "./box-slider-all.js"


// 3D轮播图效果

let init3D = function(Effect){
		var $box = $('#box')
		, $indicators = $('.goto-slide')
		, $effects = $('.effect')
		, $timeIndicator = $('#time-indicator')
		, slideInterval = 2000;

		var switchIndicator = function ($c, $n, currIndex, nextIndex) {
			$timeIndicator.stop().css('width', 0);
			$indicators.removeClass('current').eq(nextIndex).addClass('current');
		};

		var startTimeIndicator = function () {
			$timeIndicator.animate({width: '100%'}, slideInterval);
		};

		// initialize the plugin with the desired settings
		$box.boxSlider({
			speed: 1000
			, autoScroll: true
			, timeout: slideInterval
			, next: '#next'
			, prev: '#prev'
			, pause: '#pause'
			, effect: Effect
			, blindCount: 15
			, onbefore: switchIndicator
			, onafter: startTimeIndicator
		});

		startTimeIndicator(); 

		// pagination isn't built in simply because it's easy to
		// roll your own with the plugin API methods
		$('#controls').on('click', '.goto-slide', function (ev) {
			$box.boxSlider('showSlide', $(this).data('slideindex'));
			ev.preventDefault();
		});
		
  }

  export default init3D;
