export default function initInView( $el, fn ) {
  const isInViewport = (element) => {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }


  const scrollHandler = (e) => {
   if( !isInViewport( $el ) )
    return;
  
   window.removeEventListener('DOMContentLoaded', scrollHandler, false);
   window.removeEventListener('load', scrollHandler, false);
   window.removeEventListener('scroll', scrollHandler, false);
   window.removeEventListener('resize', scrollHandler, false);
 
   fn();
  }
  
  window.addEventListener('DOMContentLoaded', scrollHandler, false);
  window.addEventListener('load', scrollHandler, false);
  window.addEventListener('scroll', scrollHandler, false);
  window.addEventListener('resize', scrollHandler, false);
}
