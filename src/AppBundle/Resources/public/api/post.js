/* global Routing */

import responseJson from '../utils/responseJson';

export default function post(insult) {
  const datas = new FormData();
  datas.append('insult', insult);
  return fetch(Routing.generate('api_add_insult'), {
    method: 'POST',
    body: datas,
  }).then(responseJson);
}
