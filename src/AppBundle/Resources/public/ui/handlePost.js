import $ from 'jquery';
import post from '../api/post';

/**
 * @param $textarea
 * @param insult
 * @returns {function(*)}
 */
function handlePostResponse({ $textarea, insult }) {
  return (response) => {
    if (response.success) {
      const $insultContainer = $('.insult');
      $insultContainer.find('a').attr('href', response.insult.id);
      $insultContainer.find('span').text(response.insult.value);
      $('nav li a.add').click();
    } else {
      $textarea.val(insult);
      alert(response.message.join('\n'));
    }
  };
}

/**
 * @param e
 */
function submitInsult(e) {
  e.preventDefault();

  const $textarea = $('textarea[name="insult"]');
  const insult = $textarea.val().trim();

  $textarea.val('');

  post(insult)
    .done(handlePostResponse({ $textarea, insult }));
}

export default function handlePost() {
  $('.form-send form').submit(submitInsult);
}
