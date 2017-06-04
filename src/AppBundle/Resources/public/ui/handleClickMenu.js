/* global Routing */

import getRandom from "../api/getRandom";

let totalClick = 0; // Refresh

/**
 * @param response
 */
function handleGetRandomResponse(response) {
  const insultContainer = document.querySelector('.insult');
  const link = insultContainer.querySelector('a');

  if (link) {
    link.setAttribute('href', Routing.generate('single_insult', { id: response.insult.id }));
    insultContainer.querySelector('span').innerText = response.insult.value;
  } else {
    location.href = '/';
  }
}

/**
 * @param e
 */
function randomMenuItemClick(e) {
  if (totalClick < 10) {
    e.preventDefault();
    totalClick += 1;

    getRandom()
      .then(handleGetRandomResponse);
  } else {
    location.reload();
  }
}

/**
 * @param e
 */
function addInsultMenuItemClick(e) {
  e.preventDefault();
  this.classList.toggle('active');
  document
    .querySelector('.form-send')
    .classList
    .toggle('show');
}


export default function handleClickMenu() {
  document
    .querySelector('nav li a.add')
    .addEventListener('click', addInsultMenuItemClick, false);

  document
    .querySelector('.menu a:first-child')
    .addEventListener('click', randomMenuItemClick, false);
}
