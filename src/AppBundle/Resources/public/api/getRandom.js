/* global Routing */

import responseJson from '../utils/responseJson';

export default function getRandom() {
  return fetch(Routing.generate('api_get_random_insult')).then(responseJson);
}
