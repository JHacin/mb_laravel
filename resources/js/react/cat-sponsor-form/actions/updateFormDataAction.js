export function updateFormDataAction(state, payload) {
  return {
    ...state,
    formData: {
      ...state.formData,
      ...payload,
    },
  };
}
