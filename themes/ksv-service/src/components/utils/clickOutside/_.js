let outsideClickListener;

const onClickOutsideListener = (element, selector, action) => {
  outsideClickListener = event => {
    if (event.target.contains(element) && event.target.closest(selector) === null) {
      action()
      offClickOutsideListener()
    }
  }

  document.addEventListener('click', outsideClickListener)
}

const offClickOutsideListener = () => {
  document.removeEventListener('click', outsideClickListener)
}

export { onClickOutsideListener, offClickOutsideListener }