import { onScrollLockHandler, offScrollLockHandler } from "@c/utils/scrollLock/_";
import { onClickOutsideListener, offClickOutsideListener } from "../utils/clickOutside/_";
import focusLock from "dom-focus-lock";

let isMenuShow = false; 
const $menu = document.querySelector(".js-main-menu");
const $menuList = $menu.querySelector(".js-main-menu-list");

let currentBranch;
let dropdownButtonsOpen;
let dropdownButtonClose;

const onHideDropdownMenu = () => {
  const $dropdownsActive = $menuList.querySelectorAll(".dropdown--active")
  if ($dropdownsActive)
    $dropdownsActive.forEach(dropdown => {
        dropdown.classList.remove("dropdown--active");
    })
}

const clickDropdownBtnOpenHandler = (e) => { 
  e.preventDefault();
  offDropdownBtnOpenHandler();
  offDropdownBtnCloseHandler();  
  focusLock.off(currentBranch);
  currentBranch = e.target.parentNode;
  currentBranch.classList.add("dropdown--active");

  currentBranch = currentBranch.querySelector(".js-dropdown-menu");
  onDropdownBtnOpenHandler();
  onDropdownBtnCloseHandler();
  focusLock.on(currentBranch);
}

const onDropdownBtnOpenHandler = () => {
  dropdownButtonsOpen = currentBranch.querySelectorAll(":scope > .js-dropdown > .js-dropdown-btn-open");
  if (dropdownButtonsOpen)
    dropdownButtonsOpen.forEach(el => el.addEventListener("click", clickDropdownBtnOpenHandler))
}

const offDropdownBtnOpenHandler = () => {
  if (dropdownButtonsOpen)
    dropdownButtonsOpen.forEach(el => el.removeEventListener("click", clickDropdownBtnOpenHandler))
}

const clickDropdownBtnCloseHandler = (e) => {
  e.preventDefault();
  offDropdownBtnOpenHandler();
  offDropdownBtnCloseHandler();
  focusLock.off(currentBranch);
  currentBranch = currentBranch.parentNode;
  currentBranch.classList.remove("dropdown--active");

  currentBranch = currentBranch.parentNode;
  onDropdownBtnOpenHandler();
  onDropdownBtnCloseHandler();
  focusLock.on(currentBranch);
}

const onDropdownBtnCloseHandler = () => {
  dropdownButtonClose = currentBranch.querySelector(":scope > .js-dropdown-btn-close");
  if (dropdownButtonClose)
    dropdownButtonClose.addEventListener("click", clickDropdownBtnCloseHandler)
}

const offDropdownBtnCloseHandler = () => {
  if (dropdownButtonClose)
    dropdownButtonClose.removeEventListener("click", clickDropdownBtnCloseHandler)
}

const onMenuShow = () => {
  currentBranch = $menuList;
  isMenuShow = true;
  document.body.classList.add("main-menu--show");
  onScrollLockHandler();
  focusLock.on(currentBranch);
  onDropdownBtnOpenHandler();
  onClickOutsideListener($menu, ".js-main-menu", onMenuHide);
}

const onMenuHide = () => {
  isMenuShow = false;
  document.body.classList.remove("main-menu--show");
  onHideDropdownMenu();
  offScrollLockHandler();
  focusLock.off(currentBranch);
  offDropdownBtnOpenHandler();
  offClickOutsideListener();
}

const onToggleMenu = () => {
  isMenuShow = !isMenuShow;

  if (isMenuShow) {
    onMenuShow();
  } else {
    onMenuHide();
  }
}

export default function initMenu($menuToglers) {
  $menuToglers.addEventListener("click", (function(e) {
    e.preventDefault(); 
    onToggleMenu();
  }))
}