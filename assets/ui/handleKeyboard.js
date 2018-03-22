/**
 * @param e
 */
function handleSpaceTap(e) {
  const formClassList = document.querySelector('.form-send').classList;
  if (!formClassList.contains('show')) {
    const key = parseInt(e.keyCode, 10);
    if (key === 32 || key === 73) {
      document.querySelector('li.random').click();
      e.preventDefault();
    }
  }
}

export default function handleKeyboard() {
  document.addEventListener('keydown', handleSpaceTap, false);
}
