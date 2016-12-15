/* global Routing */

import $ from 'jquery';

export default function post(insult) {
  return $.ajax({
    url: Routing.generate('api_add_insult'),
    type: 'POST',
    data: { insult },
    dataType: 'json',
  });
}
