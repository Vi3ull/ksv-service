const onScrollLockHandler = () => {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

      window.onscroll = function() {
          window.scrollTo(scrollLeft, scrollTop);
      };
}

const offScrollLockHandler = () => {
  window.onscroll = function() {};
}

export { onScrollLockHandler, offScrollLockHandler };