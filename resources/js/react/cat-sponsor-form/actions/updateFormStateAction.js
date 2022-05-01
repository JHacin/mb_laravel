export function updateFormStateAction(state, payload) {
  return {
    ...state,
    formState: {
      ...state.formState,
      ...payload,
    },
  };
}
