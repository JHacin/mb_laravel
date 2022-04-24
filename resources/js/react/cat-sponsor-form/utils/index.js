import * as yup from 'yup';

export const createPersonDataValidationRules = (prefix) => ({
  [`${prefix}_email`]: yup.string().email().required(),
  [`${prefix}_first_name`]: yup.string().required(),
  [`${prefix}_last_name`]: yup.string().required(),
  [`${prefix}_gender`]: yup.string().required(),
  [`${prefix}_address`]: yup.string().required(),
  [`${prefix}_zip_code`]: yup.string().required(),
  [`${prefix}_city`]: yup.string().required(),
  [`${prefix}_country`]: yup.string().required(),
});
