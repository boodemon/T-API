/*****
* CONFIGURATION
*/

//Main navigation
$.navigation = $('nav > ul.nav');

$.panelIconOpened = 'icon-arrow-up';
$.panelIconClosed = 'icon-arrow-down';

//Default colours
$.brandPrimary =  '#20a8d8';
$.brandSuccess =  '#4dbd74';
$.brandInfo =     '#63c2de';
$.brandWarning =  '#f8cb00';
$.brandDanger =   '#f86c6b';

$.grayDark =      '#2a2c36';
$.gray =          '#55595c';
$.grayLight =     '#818a91';
$.grayLighter =   '#d1d4d7';
$.grayLightest =  '#f8f9fa';

'use strict';

/****
* MAIN NAVIGATION
*/

$(document).ready(function($){

  // Add class .active to current link
  $.navigation.find('a').each(function(){

    var cUrl = String(window.location).split('?')[0];

    if (cUrl.substr(cUrl.length - 1) == '#') {
      cUrl = cUrl.slice(0,-1);
    }

    if ($($(this))[0].href==cUrl) {
      $(this).addClass('active');

      $(this).parents('ul').add(this).each(function(){
        $(this).parent().addClass('open');
      });
    }
  });

  // Dropdown Menu
  $.navigation.on('click', 'a', function(e){

    if ($.ajaxLoad) {
      e.preventDefault();
    }

    if ($(this).hasClass('nav-dropdown-toggle')) {
      $(this).parent().toggleClass('open');
      resizeBroadcast();
    }

  });

  function resizeBroadcast() {

    var timesRun = 0;
    var interval = setInterval(function(){
      timesRun += 1;
      if(timesRun === 5){
        clearInterval(interval);
      }
      window.dispatchEvent(new Event('resize'));
    }, 62.5);
  }

  /* ---------- Main Menu Open/Close, Min/Full ---------- */
  $('.sidebar-toggler').click(function(){
    $('body').toggleClass('sidebar-hidden');
    resizeBroadcast();
  });

  $('.sidebar-minimizer').click(function(){
    $('body').toggleClass('sidebar-minimized');
    resizeBroadcast();
  });

  $('.brand-minimizer').click(function(){
    $('body').toggleClass('brand-minimized');
  });

  $('.aside-menu-toggler').click(function(){
    $('body').toggleClass('aside-menu-hidden');
    resizeBroadcast();
  });

  $('.mobile-sidebar-toggler').click(function(){
    $('body').toggleClass('sidebar-mobile-show');
    resizeBroadcast();
  });

  $('.sidebar-close').click(function(){
    $('body').toggleClass('sidebar-opened').parent().toggleClass('sidebar-opened');
  });

  /* ---------- Disable moving to top ---------- */
  $('a[href="#"][data-top!=true]').click(function(e){
    e.preventDefault();
  });

});

/****
* CARDS ACTIONS
*/

$('.card-actions').on('click', 'a, button', function(e){
  e.preventDefault();

  if ($(this).hasClass('btn-close')) {
    $(this).parent().parent().parent().fadeOut();
  } else if ($(this).hasClass('btn-minimize')) {
    // var $target = $(this).parent().parent().next('.card-body').collapse({toggle: true});
    if ($(this).hasClass('collapsed')) {
      $('i',$(this)).removeClass($.panelIconOpened).addClass($.panelIconClosed);
    } else {
      $('i',$(this)).removeClass($.panelIconClosed).addClass($.panelIconOpened);
    }
  } else if ($(this).hasClass('btn-setting')) {
    $('#myModal').modal('show');
  }

});

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function init(url) {

  /* ---------- Tooltip ---------- */
  $('[rel="tooltip"],[data-rel="tooltip"]').tooltip({"placement":"bottom",delay: { show: 400, hide: 200 }});

  /* ---------- Popover ---------- */
  $('[rel="popover"],[data-rel="popover"],[data-toggle="popover"]').popover();

}

//Image manage file upload preview //
function tools() {
  this.textdel = 'Please confirl delete this!';

  this.confirm_del = function () {
    var _this = this;
    if ($('.del').length > 0) {
      $('.del').on('click', function () {
        console.log('text contirm : ' + _this.textdel);
        if (!confirm(_this.textdel)) {
          return false;
        }
      });
    }
  };
	/*---------------------------------
	 :: SET CHECKBOX ALL :: 
	 ----------------------------------*/
  this.checkboxAll = function () {
    $('.checkboxAll').on('click', function (e) {
      var chekednum = $('.checkboxAll:checked').length;
      var chekboxnum = $('.checkboxAll').length;
      if (chekednum == chekboxnum) {
        $('#checkAll').prop('checked', true);
      } else {
        $('#checkAll').prop('checked', false);
      }
    });

    $('#checkAll').on('click', function (e) {
      if ($(this).is(':checked')) {
        $('.checkboxAll').prop('checked', true);
      } else {
        $('.checkboxAll').prop('checked', false);
      }
    });
  };
	/*----------------------------
	:: Preload on submit form 
	---------------------------*/
  this.preload = function () {
    $('form').on('submit', function (e) {
      $('body').append('<div class="preoverlay text-center"></div>'
        + '<div class="preloading text-center">'
        + '<img src="' + _base + '/public/images/loading.gif"/><br/>'
        + 'Loading...'
        + '</div>');
      var jobHeight = $(document).height();
      $('html, body').animate({ scrollTop: 0 }, 800);
      $('.preloading').removeClass('hide').show('slow');
      $('.preoverlay').removeClass('hide').show('slow').css('height', jobHeight);
    });
  };
	/*----------------------------
	:: Open Color Box 
	---------------------------*/
  this.cbox = function () {
    $('.cbox').on('click', function (e) {
      e.preventDefault();
      var cWidth = $(this).attr('box-width');
      var cHeight = $(this).attr('box-height');
      if (cWidth !== undefined || cHeight !== undefined) {
        $($(this)).colorbox({
          rel: 'cbox',
          href: $(this).attr('href'),
          width: cWidth,
          height: cHeight,
          transition: "fade",
          iframe: true,
          fixed: true
        });
      } else {
        $($(this)).colorbox({
          rel: 'cbox',
          href: $(this).attr('href'),
          transition: "fade"

        });
      }
    });
  }
}

(function ($) {
  var tool = new tools;
  tool.confirm_del();
  tool.checkboxAll();
}(jQuery));