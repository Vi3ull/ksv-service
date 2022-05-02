import { onScrollLockHandler, offScrollLockHandler } from "@c/utils/scrollLock/_";
import { onClickOutsideListener, offClickOutsideListener } from "@c/utils/clickOutside/_";
import focusLock from "dom-focus-lock";
  
let $modal;
let $btnModalClose;
const classShow = "modal--show";

const onModalShow = (selector) => {
  $modal = selector;
  $btnModalClose = $modal.querySelector(".js-modal-close");

  $modal.classList.add(classShow);
  onModalHideHandler($btnModalClose);
  onScrollLockHandler();
  focusLock.on($modal);
  onClickOutsideListener($modal, ".js-modal-wrapper", onModalHide);
}

const onModalHide = () => {
  $modal.classList.remove(classShow);
  offModalHideHandler($btnModalClose);
  offScrollLockHandler();
  focusLock.off($modal);
  offClickOutsideListener();
}

const onModalHideHandler = (selector) => {
  selector.addEventListener("click", onModalHide);
}

const offModalHideHandler = (selector) => {
  selector.removeEventListener("click", onModalHide);
}

export default function initModal($modalBtnOpen) {
  $modalBtnOpen.addEventListener("click", function(e) {
    const $modal = $modalBtnOpen.parentNode.querySelector(".js-modal");
    e.preventDefault();
    onModalShow($modal);
  })
}