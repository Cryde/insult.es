/* global Routing */

import post from '../api/post';


/**
 * @param {String} insult - The insult
 * @returns {function(*)}
 */
function handlePostResponse({ insult }) {
  return (response) => {
    if (response.success) {
      const insultContainer = document.querySelector('.insult');
      const link = insultContainer.querySelector('a');
      const route = Routing.generate('single_insult', { id: response.insult.id });

      if (link) {
        link.setAttribute('href', route);
        insultContainer.querySelector('span').innerText = response.insult.value;
        document.querySelector('nav li a.add').click();
      } else {
        location.href = route;
      }
    } else {
      document.querySelector('textarea[name="insult"]').value = insult;
      alert(response.message.join('\n'));
    }
  };
}

/**
 * @param e
 */
function submitInsult(e) {
  e.preventDefault();

  const textarea = document.querySelector('textarea[name="insult"]');
  const insult = textarea.value.trim();

  textarea.value = '';

  post(insult)
    .then(handlePostResponse({ insult }));
}

export default function handlePost() {
  document
    .querySelector('.form-send form')
    .addEventListener('submit', submitInsult, false);
}
