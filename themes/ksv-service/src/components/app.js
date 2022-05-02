import initInView from './utils/initInView/_';

document.querySelectorAll( '.js-main-menu-toggler' ).forEach( $el => {
  if (document.querySelectorAll( '.js-main-menu-toggler' )) {
    initInView( $el, () => {
      import(
        './main-menu/_.js' /* webpackChunkName: "/js/main-menu" */
      ).then( module => {
        const initMenu = module.default;
        initMenu( $el )
      });
    });
  }
});

document.querySelectorAll( '.js-carousel' ).forEach( $el => {
  if (document.querySelectorAll( '.js-carousel' )) {
    initInView( $el, () => {
      import(
        './carousel/_.js' /* webpackChunkName: "/js/carousel" */
      ).then( module => {
        const initCarousel = module.default;
        initCarousel( $el )
      });
    });
  }
});

document.querySelectorAll( '.js-accordion' ).forEach( $el => {
  if (document.querySelectorAll( '.js-accordion' )) {
    initInView( $el, () => {
      import(
        './accordion/_.js' /* webpackChunkName: "/js/accordion" */
      ).then( module => {
        const initAccordion = module.default;
        initAccordion( $el )
      });
    });
  }
});

document.querySelectorAll( '.js-modal-open' ).forEach( $el => {
  if (document.querySelectorAll( '.js-modal-open' )) {
    initInView( $el, () => {
      import(
        './modal/_.js' /* webpackChunkName: "/js/modal" */
      ).then( module => {
        const initModal = module.default;
        initModal( $el )
      });
    });
  }
});

document.querySelectorAll( '.js-map' ).forEach( $el => {
  if (document.querySelectorAll( '.js-map' )) {
    initInView( $el, () => {
      import(
        './ymaps/_.js' /* webpackChunkName: "/js/map" */
      ).then( module => {
        const initMap = module.default;
        initMap( $el )
      });
    });
  }
});