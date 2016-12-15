import $ from 'jquery';
import getRandom from '../api/getRandom';

let totalClick = 0; // Refresh

/**
 * @param response
 */
function handleGetRandomResponse(response) {
  const $insultContainer = $('.insult');
  const $link = $insultContainer.find('a');

  if ($link.length) {
    $link.attr('href', response.insult.id);
    $insultContainer.find('span').text(response.insult.value);
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
      .done(handleGetRandomResponse);
  } else {
    location.reload();
  }
}

/**
 * @param e
 */
function addInsultMenuItemClick(e) {
  e.preventDefault();
  $(this).toggleClass('active');
  $('.form-send').toggle();
}


export default function handleClickMenu() {
  $('nav li a.add').click(addInsultMenuItemClick);
  $('.menu a:first').click(randomMenuItemClick);
}
