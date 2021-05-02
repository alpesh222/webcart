<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    if(\DB::table('currencies')->count() == 0) {
	        
            \DB::insert("
                INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `format`, `exchange_rate`, `active`, `created_at`, `updated_at`) VALUES
                (1, 'Albania, Lek', 'ALL', 'Lek', '1,0.00Lek', '0', 0, '2017-09-26 12:46:07', '2017-09-26 12:46:07'),
                (2, 'Algerian Dinar', 'DZD', 'د.ج‏', 'د.ج‏ 1,0.00', '0', 0, '2017-09-26 12:46:07', '2017-09-26 12:46:07'),
                (3, 'US Dollar', 'USD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:07', '2017-09-26 12:46:07'),
                (4, 'Euro', 'EUR', '€', '1.0,00 €', '0', 0, '2017-09-26 12:46:07', '2017-09-26 12:46:07'),
                (5, 'Angola, Kwanza', 'AOA', 'Kz', 'Kz1,0.00', '0', 0, '2017-09-26 12:46:07', '2017-09-26 12:46:07'),
                (6, 'East Caribbean Dollar', 'XCD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:07', '2017-09-26 12:46:07'),
                (7, 'Norwegian Krone', 'NOK', 'kr', '1.0,00 kr', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (8, 'Armenian Dram', 'AMD', '&#1423;', '1,0.00 &#1423;', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (9, 'Aruban Guilder', 'AWG', 'ƒ', 'ƒ1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (10, 'Australian Dollar', 'AUD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (11, 'Bahamian Dollar', 'BSD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (12, 'Bahraini Dinar', 'BHD', '.د.', '.د. 1,0.000', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (13, 'Bangladesh, Taka', 'BDT', '৳', '৳ 1,0.', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (14, 'Barbados Dollar', 'BBD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (15, 'Belarussian Ruble', 'BYR', 'р.', '1 0,00 р.', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (16, 'Belize Dollar', 'BZD', 'BZ$', 'BZ$1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (17, 'Franc CFA (XAF)', 'XAF', 'F.CFA', '1,0.00 F.CFA', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (18, 'Bermudian Dollar', 'BMD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (19, 'Bhutan, Ngultrum', 'BTN', 'Nu.', 'Nu. 1,0.0', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (20, 'Bolivia, Boliviano', 'BOB', 'Bs', 'Bs 1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (21, 'Bosnia and Herzegovina, Convertible Marks', 'BAM', 'КМ', '1,0.00 КМ', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (22, 'Botswana, Pula', 'BWP', 'P', 'P1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (23, 'Brazilian Real', 'BRL', 'R$', 'R$1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (24, 'Pound Sterling', 'GBP', '£', '£1,0.00', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (25, 'Brunei Dollar', 'BND', '$', '$1,0.', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (26, 'Bulgarian Lev', 'BGN', 'лв.', '1 0,00 лв.', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (27, 'Burundi Franc', 'BIF', 'FBu', '1,0.FBu', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (28, 'Cambodia, Riel', 'KHR', '៛', '1,0.៛', '0', 0, '2017-09-26 12:46:08', '2017-09-26 12:46:08'),
                (29, 'Canadian Dollar', 'CAD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (30, 'Cape Verde Escudo', 'CVE', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (31, 'Cayman Islands Dollar', 'KYD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (32, 'China Yuan Renminbi', 'CNY', '¥', '¥1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (33, 'Colombian Peso', 'COP', '$', '$ 1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (34, 'Comoro Franc', 'KMF', 'CF', '1,0.00CF', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (35, 'New Zealand Dollar', 'NZD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (36, 'Costa Rican Colon', 'CRC', '₡', '₡1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (37, 'Croatian Kuna', 'HRK', 'kn', '1,0.00 kn', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (38, 'Cuban Peso', 'CUP', '\$MN', '\$MN1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (39, 'Czech Koruna', 'CZK', 'Kč', '1 0,00 Kč', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (40, 'Danish Krone', 'DKK', 'kr.', '1 0,00 kr.', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (41, 'Djibouti Franc', 'DJF', 'Fdj', '1,0.Fdj', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (42, 'Dominican Peso', 'DOP', 'RD$', 'RD$1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (43, 'Egyptian Pound', 'EGP', 'ج.م', 'ج.م 1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (44, 'Eritrea, Nakfa', 'ERN', 'Nfk', '1,0.00Nfk', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (45, 'Ethiopian Birr', 'ETB', 'ETB', 'ETB1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (46, 'Falkland Islands Pound', 'FKP', '£', '£1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (47, 'Fiji Dollar', 'FJD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (48, 'CFP Franc', 'XPF', 'F', '1,0.00F', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (49, 'Gambia, Dalasi', 'GMD', 'D', '1,0.00D', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (50, 'Georgia, Lari', 'GEL', 'Lari', '1 0,00 Lari', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (51, 'Gibraltar Pound', 'GIP', '£', '£1,0.00', '0', 0, '2017-09-26 12:46:09', '2017-09-26 12:46:09'),
                (52, 'Guatemala, Quetzal', 'GTQ', 'Q', 'Q1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (53, 'Guyana Dollar', 'GYD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (54, 'Haiti, Gourde', 'HTG', 'G', 'G1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (55, 'Honduras, Lempira', 'HNL', 'L.', 'L. 1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (56, 'Hong Kong Dollar', 'HKD', 'HK$', 'HK$1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (57, 'Hungary, Forint', 'HUF', 'Ft', '1 0,00 Ft', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (58, 'Iceland Krona', 'ISK', 'kr.', '1,0. kr.', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (59, 'Indian Rupee', 'INR', '₹', '₹1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (60, 'Indonesia, Rupiah', 'IDR', 'Rp', 'Rp1,0.', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (61, 'Iranian Rial', 'IRR', '﷼', '﷼ 1,0/00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (62, 'Iraqi Dinar', 'IQD', 'د.ع.‏', 'د.ع.‏ 1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (63, 'New Israeli Shekel', 'ILS', '₪', '₪ 1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (64, 'Jamaican Dollar', 'JMD', 'J$', 'J$1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (65, 'Japan, Yen', 'JPY', '¥', '¥1,0.', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (66, 'Jordanian Dinar', 'JOD', 'د.ا.‏', 'د.ا.‏ 1,0.000', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (67, 'Kazakhstan, Tenge', 'KZT', '₸', '₸1 0-00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (68, 'Kenyan Shilling', 'KES', 'S', 'S1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (69, 'North Korean Won', 'KPW', '₩', '₩1,0.', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (70, 'South Korea, Won', 'KRW', '₩', '₩1,0.', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (71, 'Kuwaiti Dinar', 'KWD', 'دينار‎‎‏', 'دينار‎‎‏ 1,0.000', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (72, 'Kyrgyzstan, Som', 'KGS', 'сом', '1 0-00 сом', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (73, 'Laos, Kip', 'LAK', '₭', '1,0.₭', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (74, 'Lebanese Pound', 'LBP', 'ل.ل.‏', 'ل.ل.‏ 1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (75, 'Lesotho, Loti', 'LSL', 'M', '1,0.00M', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (76, 'Liberian Dollar', 'LRD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (77, 'Libyan Dinar', 'LYD', 'د.ل.‏', 'د.ل.‏1,0.000', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (78, 'Swiss Franc', 'CHF', 'CHF', '1''0.00 CHF', '0', 0, '2017-09-26 12:46:10', '2017-09-26 12:46:10'),
                (79, 'Macao, Pataca', 'MOP', 'MOP$', 'MOP$1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (80, 'Macedonia, Denar', 'MKD', 'ден.', '1,0.00 ден.', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (81, 'Malawi, Kwacha', 'MWK', 'MK', 'MK1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (82, 'Malaysian Ringgit', 'MYR', 'RM', 'RM1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (83, 'Maldives, Rufiyaa', 'MVR', 'MVR', '1,0.0 MVR', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (84, 'Mauritania, Ouguiya', 'MRO', 'UM', '1,0.00UM', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (85, 'Mauritius Rupee', 'MUR', '₨', '₨1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (86, 'Mexican Peso', 'MXN', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (87, 'Moldovan Leu', 'MDL', 'lei', '1,0.00 lei', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (88, 'Mongolia, Tugrik', 'MNT', '₮', '₮1 0,00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (89, 'Moroccan Dirham', 'MAD', 'د.م.‏', 'د.م.‏ 1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (90, 'Myanmar, Kyat', 'MMK', 'K', 'K1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (91, 'Namibian Dollar', 'NAD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (92, 'Nepalese Rupee', 'NPR', '₨', '₨1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (93, 'Netherlands Antillian Guilder', 'ANG', 'ƒ', 'ƒ1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (94, 'Franc CFA (XOF)', 'XOF', 'F.CFA', '1,0.00 F.CFA', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (95, 'Nigeria, Naira', 'NGN', '₦', '₦1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (96, 'Rial Omani', 'OMR', '﷼', '﷼ 1,0.000', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (97, 'Pakistan Rupee', 'PKR', '₨', '₨1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (98, 'Panama, Balboa', 'PAB', 'B/.', 'B/. 1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (99, 'Papua New Guinea, Kina', 'PGK', 'K', 'K1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (100, 'Paraguay, Guarani', 'PYG', '₲', '₲ 1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (101, 'Philippine Peso', 'PHP', '₱', '₱1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (102, 'Poland, Zloty', 'PLN', 'zł', '1 0,00 zł', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (103, 'Qatari Rial', 'QAR', '﷼', '﷼ 1,0.00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (104, 'Russian Ruble', 'RUB', '₽', '1 0,00 ₽', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (105, 'Rwanda Franc', 'RWF', 'RWF', 'RWF 1 0,00', '0', 0, '2017-09-26 12:46:11', '2017-09-26 12:46:11'),
                (106, 'Samoa, Tala', 'WST', 'WS$', 'WS$1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (107, 'Sao Tome and Principe, Dobra', 'STD', 'Db', 'Db1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (108, 'Saudi Riyal', 'SAR', '﷼', '﷼ 1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (109, 'Seychelles Rupee', 'SCR', '₨', '₨1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (110, 'Sierra Leone, Leone', 'SLL', 'Le', 'Le1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (111, 'Singapore Dollar', 'SGD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (112, 'Solomon Islands Dollar', 'SBD', '$', '$1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (113, 'Somali Shilling', 'SOS', 'S', 'S1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (114, 'South Africa, Rand', 'ZAR', 'R', 'R 1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (115, 'Sri Lanka Rupee', 'LKR', '₨', '₨ 1,0.', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (116, 'Saint Helena Pound', 'SHP', '£', '£1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (117, 'Swaziland, Lilangeni', 'SZL', 'E', 'E1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (118, 'Swedish Krona', 'SEK', 'kr', '1 0,00 kr', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (119, 'Syrian Pound', 'SYP', '£', '£ 1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (120, 'New Taiwan Dollar', 'TWD', 'NT$', 'NT$1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (121, 'Tanzanian Shilling', 'TZS', 'TSh', 'TSh1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (122, 'Thailand, Baht', 'THB', '฿', '฿1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (123, 'Tonga, Paanga', 'TOP', 'T$', 'T$1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (124, 'Trinidad and Tobago Dollar', 'TTD', 'TT$', 'TT$1,0.00', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (125, 'Tunisian Dinar', 'TND', 'د.ت.‏', 'د.ت.‏ 1,0.000', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (126, 'New Turkish Lira', 'TRY', 'TL', '1,0.00 TL', '0', 0, '2017-09-26 12:46:12', '2017-09-26 12:46:12'),
                (127, 'Ukraine, Hryvnia', 'UAH', '₴', '1 0,00₴', '0', 0, '2017-09-26 12:46:13', '2017-09-26 12:46:13'),
                (128, 'UAE Dirham', 'AED', 'دإ‏', 'دإ‏ 1,0.00', '0', 0, '2017-09-26 12:46:13', '2017-09-26 12:46:13'),
                (129, 'Peso Uruguayo', 'UYU', '\$U', '\$U 1,0.00', '0', 0, '2017-09-26 12:46:13', '2017-09-26 12:46:13'),
                (130, 'Uzbekistan Sum', 'UZS', 'сўм', '1 0,00 сўм', '0', 0, '2017-09-26 12:46:13', '2017-09-26 12:46:13'),
                (131, 'Vanuatu, Vatu', 'VUV', 'VT', '1,0.VT', '0', 0, '2017-09-26 12:46:13', '2017-09-26 12:46:13'),
                (132, 'Venezuela Bolivares Fuertes', 'VEF', 'Bs. F.', 'Bs. F. 1,0.00', '0', 0, '2017-09-26 12:46:13', '2017-09-26 12:46:13'),
                (133, 'Viet Nam, Dong', 'VND', '₫', '1,0.0 ₫', '0', 0, '2017-09-26 12:46:13', '2017-09-26 12:46:13'),
                (134, 'Ghana Cedis', 'GHC', 'GH¢', 'GH¢1,0.00', '0', 0, '2017-09-26 12:46:13', '2017-09-26 12:46:13'),
                (135, 'Kenyan Shilling', 'KES', 'Ksh', 'Ksh. 1,0.00', '0', 0, '2017-09-26 12:46:13', '2017-09-26 12:46:13')
            ");
	    }
    }
}
