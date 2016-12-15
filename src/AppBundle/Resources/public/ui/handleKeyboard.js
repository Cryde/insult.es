import $ from 'jquery';

function handleSpaceTap(e) {
  if ($('.form-send').is(':hidden')) {
    const k = parseInt(e.which, 10);
    if (k === 32 || k === 73) {
      $('.menu a:first').click();
      e.preventDefault();
    }
  }
}

export default function handleKeyboard() {
  $(document).keydown(handleSpaceTap);
}
