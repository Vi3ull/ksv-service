let focusTarget;

const focusLockHandler = (e) => {
  const focusableEls = focusTarget.querySelectorAll(':scope a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])');
  const firstFocusableEl = focusableEls[0];  
  const lastFocusableEl = focusableEls[focusableEls.length - 1];
  let KEYCODE_TAB = 9;
  let isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

  console.log("first", firstFocusableEl);
  console.log("last", lastFocusableEl);

  if (!isTabPressed) { 
    return; 
  }

  if (e.shiftKey) {
    if (document.activeElement === firstFocusableEl) {
      lastFocusableEl.focus();
      e.preventDefault();
    }
  } else {
    if (document.activeElement === lastFocusableEl) {
      firstFocusableEl.focus();
      e.preventDefault();
    }
  }
}

const onFocusLockHandler = (currentTarget) => {
  focusTarget = currentTarget;

  focusTarget.addEventListener("keydown", focusLockHandler);
}

const offFocusLockHandler = () => {
  focusTarget.removeEventListener("keydown", focusLockHandler);
}

export { onFocusLockHandler, offFocusLockHandler };