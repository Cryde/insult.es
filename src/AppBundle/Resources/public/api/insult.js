/* global Routing */

import responseJson from '../utils/responseJson';

function getRandom() {
  return fetch(Routing.generate('api_get_random_insult')).then(responseJson);
}

function getInsult(id) {
  return fetch(Routing.generate('api_get_insult', { id })).then(responseJson);
}

export { getRandom, getInsult };
