import post from '../api/post';

/**
 * @param insult
 * @returns {function(*)}
 */
function handlePostResponse(insult) {
  return (response) => {
    if (response.success) {
      location.hash = response.insult.id;
      location.reload();
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
    .then(handlePostResponse(insult));
}

export default function handlePost() {
  document
    .querySelector('.form-send input')
    .addEventListener('click', submitInsult, false);
}
