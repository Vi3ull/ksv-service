const onToggle = (event) => {
  if (event.target.open) {
    document
      .querySelectorAll(".js-accordion > .js-accordion-item > details[open]")
      .forEach((el) => {
        if (el === event.target) {
          return;
        }

        el.open = false;
      });
  }
}

export default function initAccordion($accordion) {
  const $accordionDetails = $accordion.querySelectorAll(".js-accordion-item > details")
  $accordionDetails.forEach((el) => el.addEventListener("toggle", onToggle));
}