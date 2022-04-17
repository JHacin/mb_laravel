export const errorMessages = {
  required: 'Polje je obvezno.',
  mustBeFullNumber: 'Vrednost mora biti polna številka (npr. 5)',
};

export function isNumber(value) {
  return /^\d+$/.test(value);
}
