function formatInsultResponse(response) {
  return {
    id: response.insult.id,
    value: response.insult.value,
    totalVote: response.insult.total_vote,
    totalVoteUp: response.insult.total_vote_up,
    totalVoteDown: response.insult.total_vote_down,
    currentVote: response.insult.current_vote,
  };
}

export {formatInsultResponse};