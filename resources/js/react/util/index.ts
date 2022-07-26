import * as yup from 'yup';
import { locale } from '../config/yup-locale'

yup.setLocale(locale)

const Rules = {
  email: yup.string().email().required(),
  first_name: yup.string().required(),
  last_name: yup.string().required(),
  gender: yup.number().required(),
  address: yup.string().required(),
  zip_code: yup.string().required(),
  city: yup.string().required(),
  country: yup.string().required(),
};

export const createPayerValidationRules = () => ({
  payer_email: Rules.email,
  payer_first_name: Rules.first_name,
  payer_last_name: Rules.last_name,
  payer_gender: Rules.gender,
  payer_address: Rules.address,
  payer_zip_code: Rules.zip_code,
  payer_city: Rules.city,
  payer_country: Rules.country,
});

export const createGifteeValidationRules = () => ({
  giftee_email: Rules.email,
  giftee_first_name: Rules.first_name,
  giftee_last_name: Rules.last_name,
  giftee_gender: Rules.gender,
  giftee_address: Rules.address,
  giftee_zip_code: Rules.zip_code,
  giftee_city: Rules.city,
  giftee_country: Rules.country,
});
