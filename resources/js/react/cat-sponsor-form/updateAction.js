export function updateAction(state, payload) {
  return {
    ...state,
    ...payload,
  };
}
