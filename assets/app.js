import 'whatwg-fetch';

import handlePost from './ui/handlePost';
import handleKeyboard from './ui/handleKeyboard';
import handleClickMenu from './ui/handleClickMenu';
import handleVote from './ui/handleVote';
import fixMobileHover from './utils/hover-mobile-fix';

handlePost();
handleKeyboard();
handleClickMenu();
handleVote();
fixMobileHover();