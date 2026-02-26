(function ($) {
  "use strict";

  const FURNOB_APP = {
    init() {
      this.dom();
      this.cartSide();
      this.searcHolder();
      this.mobileMenu();
      this.siteCountdown();
      this.siteTooltip();
      this.themeQuantity();
      this.gdprCookie();
      this.mobileBottomMenu();
    },
    dom() {
      this.overlay = document.querySelector( '.site-mask' );
    },
    cartSide() {
      const button = document.querySelectorAll( '.cart-button' );

      if ( button !== null ) {
        for( var i = 0; i < button.length; i++ ) {
          const self = button[i];

          const cartSide = document.querySelector( '.cart-widget-side' );
          const close = cartSide.querySelector( '.cart-side-close' );

          const tl = gsap.timeline( { paused: true, reversed: true } );

          tl.to( this.overlay, { duration: .2, autoAlpha: 1 } );
          tl.to( cartSide, {  duration: .4, ease: 'power3.inOut', x:0 }, "-=.3" );

          self.addEventListener( 'click', (e) => {
            e.preventDefault();
            tl.play();
          });

          close.addEventListener( 'click', (e) => {
            e.preventDefault();
            tl.reverse();
          });
		  
		  $('.site-mask').on( 'click', function(e) {
			e.preventDefault();
			tl.reverse();
			setTimeout( function() {
			 $('.site-mask').removeClass( 'active' );
			}, 1000);
		  });
		  
        }
      }
    },
    searcHolder() {
      const container = document.querySelector( '.search-holder' );

      if ( container !== null ) {
        const button = document.querySelectorAll( '.search-button' );
        const close = document.querySelector( '.search-holder-close' );

        const focusInput = () => {
          if ( window.innerWidth > 1024 ) {
            document.querySelector( '.search-holder .search-form input' ).focus();
          }
        }

        const search = gsap.timeline( { paused: true, reversed: true } );
        let forward = true;

        search.to( this.overlay, { duration: .2, autoAlpha: 1 } );
        search.to( container, { duration: .4, y:0, ease: 'power2.inOut' } );
        search.to( '.search-holder .search-item', { duration: .4, ease: 'ease.inOut', y:0, opacity: 1, stagger: .1, onComplete: focusInput }, "-=.2" );

        if ( forward ) {
          if ( button !== null ) {
            for ( var i = 0; i < button.length; i++ ) {
              button[i].addEventListener( 'click', ( e ) => {
                e.preventDefault();
                search.play();
                forward = false;
              }, false);
            }
          }
        }

        close.addEventListener( 'click', ( e ) => {
          e.preventDefault();
          if ( !forward ) {
            search.reverse(1.5);
          }
          forward = true;
        }, false );

        this.overlay.addEventListener( 'click', ( e ) => {
          e.preventDefault();
          if ( !forward ) {
            search.reverse(1.5);
          }
          forward = true;
        }, false );

        document.addEventListener( 'keyup', ( ev ) => {
          if( ev.keyCode == 27 ) {
            if ( !forward ) {
              search.reverse(1.5);
            }
            forward = true;
          }
        });
      }
    },
    mobileMenu() {
      const canvasMenu = document.querySelector( '.site-offcanvas' );

      if ( canvasMenu != null || this.overlay !== null ) {

        let tl = gsap.timeline( { paused: true, reversed: true } );
        tl.set( canvasMenu, {
          autoAlpha: 1
        }).to( canvasMenu, .5, {
          x:0,
          ease: 'power4.inOut'
        }).to( this.overlay, .5, {
          autoAlpha: 1,
          ease: 'power4.inOut'
        }, "-=.5");

        const button = document.querySelectorAll( '.toggle-menu' );
		const categoryButton = $( '.mobile-bottom-menu a.categories' );
        const close = document.querySelector( '.offcanvas-close' );

        if ( button !== null ) {
          for ( var i = 0; i < button.length; i++ ) {
            const self = button[i];

            self.addEventListener( 'click', ( e ) => {
              e.preventDefault();
              tl.play();
            });

          }
        }
		
        if ( categoryButton !== null ) {
          for ( var i = 0; i < categoryButton.length; i++ ) {
            const self = categoryButton[i];

            self.addEventListener( 'click', ( e ) => {
              e.preventDefault();
              tl.play();
            });

          }
        }

        close.addEventListener( 'click', (e) => {
          e.preventDefault();
          tl.reverse(1.5);
        });
		
		$('.site-mask').on( 'click', function(e) {
		  e.preventDefault();
		  tl.reverse();
		  setTimeout( function() {
		    $('.site-mask').removeClass( 'active' );
		  }, 1000);
		});
		

        const hasChildren = document.querySelectorAll( '.site-offcanvas .menu-item-has-children' );

        const subMenu = ( e ) => {
          let subUl;
          if ( e.target.tagName === 'A' ) {
            e.preventDefault();
            subUl = e.target.nextElementSibling;
          } else {
            subUl = e.target.previousElementSibling;
          }
          let parentUl = e.target.closest( 'ul' );
          let parentLi = e.target.closest( 'li' );
          let activeLi = parentUl.querySelectorAll( '.menu-item-has-children.active' );

          const closeSubs = () => {
            for ( var i = 0; i < activeLi.length; i++ ) {
              const activeSub = activeLi[i].children[1];
              const childSubs = activeSub.querySelectorAll( '.sub-menu' );
              for ( var i = 0; i < childSubs.length; i++ ) {
                if ( childSubs[i] != null ) {
                  gsap.set( childSubs[i], { height: 0 } );
                }
              }
            }
          }

          const subAnimation = ( element, event ) => {
            gsap.to( element, { duration: .4, height: event, ease: 'power4.inOut', onComplete: closeSubs } );
          }

          if ( ! parentLi.classList.contains( 'active' ) ) {
            for ( var i = 0; i < activeLi.length; i++ ) {
              activeLi[i].classList.remove( 'active' );
              const sub = activeLi[i].children[1];
              subAnimation( sub, 0 );
            }
            parentLi.classList.add( 'active' );
            subAnimation( subUl, 'auto' );
          } else {
            parentLi.classList.remove( 'active' );
            subAnimation( subUl, 0 );
          }

        }

        for( var i = 0; i < hasChildren.length; i++ ) {
          const dropdown = document.createElement( 'span' );
          dropdown.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>';
          dropdown.className = 'menu-dropdown';
          hasChildren[i].appendChild( dropdown );

          const link = hasChildren[i].querySelector( 'a[href*="#"]' );
          const sub = hasChildren[i].children[1];
          gsap.set( sub, { height: 0 } );
          dropdown.addEventListener( 'click', subMenu );
		  if ( link !== null ) {
          link.addEventListener( 'click', subMenu );
		  }
        }
      }
    },

    siteCountdown() {
      const countdown = document.querySelectorAll( '.countdown' );

      if ( countdown !== null ) {
        for ( var i = 0; i < countdown.length; i++ ) {
          const self = countdown[i];

          const countDate = self.dataset.date;
          const expired = self.dataset.text;
          let countDownDate = new Date( countDate ).getTime();

          const d = self.querySelector( '.days' );
          const h = self.querySelector( '.hours' );
          const m = self.querySelector( '.minutes' );
          const s = self.querySelector( '.second' );

          var x = setInterval(function() {

            var now = new Date().getTime();
  
            var distance = countDownDate - now;
  
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            d.innerHTML = ( '0' + days ).slice(-2);
            h.innerHTML = ( '0' + hours ).slice(-2);
            m.innerHTML = ( '0' + minutes ).slice(-2);
            s.innerHTML = ( '0' + seconds ).slice(-2);
  
            if (distance < 0) {
              clearInterval(x);
              console.log( 'expired' );
              self.innerHTML = '<div class="expired">' + expired + '</div>'
              /* document.getElementById("demo").innerHTML = expired; */
            }
          }, 1000);
        }
      }
    },

    siteTooltip() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    },

    themeQuantity() {
      function qty() {
        var container = $( '.quantity:not(.ajax-quantity)' );
		$("form.cart.grouped_form .input-text.qty").attr("value", "0");

        container.each( function() {
          var self = $( this );
          var buttons = $( this ).find( '.quantity-button' );
          buttons.each( function() {
            $(this).on( 'click', function(event) {
              var qty_input = self.find( '.input-text.qty' );
              if ( $(qty_input).prop('disabled') ) return;
              var qty_step = parseFloat($(qty_input).attr('step'));
              var qty_min = parseFloat($(qty_input).attr('min'));
              var qty_max = parseFloat($(qty_input).attr('max'));


              if ( $(this).hasClass('minus') ){
                var vl = parseFloat($(qty_input).val());
                vl = ( (vl - qty_step) < qty_min ) ? qty_min : (vl - qty_step);
                $(qty_input).val(vl);
              } else if ( $(this).hasClass('plus') ) {
                var vl = parseFloat($(qty_input).val());
                vl = ( (vl + qty_step) > qty_max ) ? qty_max : (vl + qty_step);
                $(qty_input).val(vl);
              }

              qty_input.trigger( 'change' );
            });
          });
        });
      }

      qty();
      $('body').on( 'updated_cart_totals', qty );
    },

    gdprCookie() {
      const body = $( 'body' );
      var popup = $( '.gdpr-content' );
      var popupClose = $( '.gdpr-content .btn' );
      var expiresDate = popup.data( 'expires' );

      const tl = gsap.timeline( { paused: true, reversed: true } );
      tl.to( popup, { duration: .6, opacity: 1, visibility: 'visible', y: 0, ease: 'power4.inOut' } );

      if ( body.hasClass( 'cookie-popup-enable' ) && !( Cookies.get( 'cookie-popup-visible' ) ) ) {
        window.addEventListener('DOMContentLoaded', (event) => {
          tl.play();
          popup.addClass( 'active' );
        });
      }

      popupClose.on( 'click', function(e) {
        e.preventDefault();
        Cookies.set( 'cookie-popup-visible', 'disable', { expires: expiresDate, path: '/' });
        tl.reverse();
        popup.removeClass( 'active' );
      });
    },


    mobileBottomMenu() {
      const container = document.querySelector( '.mobile-bottom-menu' );
      const footer = document.querySelector( '.site-footer' );

      if ( container !== null ) {
        document.body.classList.add( 'mobile-menu-active' );

        const height = container.clientHeight;
        footer.style.paddingBottom = height + 'px';
      } else {
        document.body.classList.remove( 'mobile-menu-active' );
      }
    }
  };

  FURNOB_APP.init();
  
	$(document).ready(function() {
		$('.site-departments a.dropdown-toggle').on('click', function (e) {
			e.preventDefault();
			$(".departments-menu").collapse('toggle');
		});
	});
	
	$(window).on('load', function(){
		$('.site-loading').fadeOut('slow',function(){$(this).remove();});
	});
	
    $(window).scroll(function() {
        $(this).scrollTop() > 135 ? $("header.site-header").addClass("sticky-header") : $("header.site-header").removeClass("sticky-header")
    });

}(jQuery));