/* global Routing */

import $ from 'jquery';

export default function getRandom() {
  return $.get(Routing.generate('api_get_random_insult'));
}
