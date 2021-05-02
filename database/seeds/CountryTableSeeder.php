<?php

use Illuminate\Database\Seeder;
use App\Country;


class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['country_name'=>'United States' , 'country_status'=>'1'],
            ['country_name'=>'Canada' , 'country_status'=>'1'],
            ['country_name'=>'Afghanistan' , 'country_status'=>'1'],
            ['country_name'=>'Albania' , 'country_status'=>'1'],
            ['country_name'=>'Algeria' , 'country_status'=>'1'],
            ['country_name'=>'American Samoa' , 'country_status'=>'1'],
            ['country_name'=>'Andorra' , 'country_status'=>'1'],
            ['country_name'=>'Angola' , 'country_status'=>'1'],
            ['country_name'=>'Anguilla' , 'country_status'=>'1'],
            ['country_name'=>'Antarctica' , 'country_status'=>'1'],
            ['country_name'=>'Antigua and/or Barbuda' , 'country_status'=>'1'],
            ['country_name'=>'Argentina' , 'country_status'=>'1'],
            ['country_name'=>'Armenia' , 'country_status'=>'1'],
            ['country_name'=>'Aruba' , 'country_status'=>'1'],
            ['country_name'=>'Australia' , 'country_status'=>'1'],
            ['country_name'=>'Austria' , 'country_status'=>'1'],
            ['country_name'=>'Azerbaijan' , 'country_status'=>'1'],
            ['country_name'=>'Bahamas' , 'country_status'=>'1'],
            ['country_name'=>'Bahrain' , 'country_status'=>'1'],
            ['country_name'=>'Bangladesh' , 'country_status'=>'1'],
            ['country_name'=>'Barbados' , 'country_status'=>'1'],
            ['country_name'=>'Belarus' , 'country_status'=>'1'],
            ['country_name'=>'Belgium' , 'country_status'=>'1'],
            ['country_name'=>'Belize' , 'country_status'=>'1'],
            ['country_name'=>'Benin' , 'country_status'=>'1'],
            ['country_name'=>'Bermuda' , 'country_status'=>'1'],
            ['country_name'=>'Bhutan' , 'country_status'=>'1'],
            ['country_name'=>'Bolivia' , 'country_status'=>'1'],
            ['country_name'=>'Bosnia and Herzegovina' , 'country_status'=>'1'],
            ['country_name'=>'Botswana' , 'country_status'=>'1'],
            ['country_name'=>'Bouvet Island' , 'country_status'=>'1'],
            ['country_name'=>'Brazil' , 'country_status'=>'1'],
            ['country_name'=>'British lndian Ocean Territory' , 'country_status'=>'1'],
            ['country_name'=>'Brunei Darussalam' , 'country_status'=>'1'],
            ['country_name'=>'Bulgaria' , 'country_status'=>'1'],
            ['country_name'=>'Burkina Faso' , 'country_status'=>'1'],
            ['country_name'=>'Burundi' , 'country_status'=>'1'],
            ['country_name'=>'Cambodia' , 'country_status'=>'1'],
            ['country_name'=>'Cameroon' , 'country_status'=>'1'],
            ['country_name'=>'Cape Verde' , 'country_status'=>'1'],
            ['country_name'=>'Cayman Islands' , 'country_status'=>'1'],
            ['country_name'=>'Central African Republic' , 'country_status'=>'1'],
            ['country_name'=>'Chad' , 'country_status'=>'1'],
            ['country_name'=>'Chile' , 'country_status'=>'1'],
            ['country_name'=>'China' , 'country_status'=>'1'],
            ['country_name'=>'Christmas Island' , 'country_status'=>'1'],
            ['country_name'=>'Cocos (Keeling) Islands' , 'country_status'=>'1'],
            ['country_name'=>'Colombia' , 'country_status'=>'1'],
            ['country_name'=>'Comoros' , 'country_status'=>'1'],
            ['country_name'=>'Congo' , 'country_status'=>'1'],
            ['country_name'=>'Cook Islands' , 'country_status'=>'1'],
            ['country_name'=>'Costa Rica' , 'country_status'=>'1'],
            ['country_name'=>'Croatia (Hrvatska)' , 'country_status'=>'1'],
            ['country_name'=>'Cuba' , 'country_status'=>'1'],
            ['country_name'=>'Cyprus' , 'country_status'=>'1'],
            ['country_name'=>'Czech Republic' , 'country_status'=>'1'],
            ['country_name'=>'Democratic Republic of Congo' , 'country_status'=>'1'],
            ['country_name'=>'Denmark' , 'country_status'=>'1'],
            ['country_name'=>'Djibouti' , 'country_status'=>'1'],
            ['country_name'=>'Dominica' , 'country_status'=>'1'],
            ['country_name'=>'Dominican Republic' , 'country_status'=>'1'],
            ['country_name'=>'East Timor' , 'country_status'=>'1'],
            ['country_name'=>'Ecudaor' , 'country_status'=>'1'],
            ['country_name'=>'Egypt' , 'country_status'=>'1'],
            ['country_name'=>'El Salvador' , 'country_status'=>'1'],
            ['country_name'=>'Equatorial Guinea' , 'country_status'=>'1'],
            ['country_name'=>'Eritrea' , 'country_status'=>'1'],
            ['country_name'=>'Estonia' , 'country_status'=>'1'],
            ['country_name'=>'Ethiopia' , 'country_status'=>'1'],
            ['country_name'=>'Falkland Islands (Malvinas)' , 'country_status'=>'1'],
            ['country_name'=>'Faroe Islands' , 'country_status'=>'1'],
            ['country_name'=>'Fiji' , 'country_status'=>'1'],
            ['country_name'=>'Finland' , 'country_status'=>'1'],
            ['country_name'=>'France' , 'country_status'=>'1'],
            ['country_name'=>'France, Metropolitan' , 'country_status'=>'1'],
            ['country_name'=>'French Guiana' , 'country_status'=>'1'],
            ['country_name'=>'French Polynesia' , 'country_status'=>'1'],
            ['country_name'=>'French Southern Territories' , 'country_status'=>'1'],
            ['country_name'=>'Gabon' , 'country_status'=>'1'],
            ['country_name'=>'Gambia' , 'country_status'=>'1'],
            ['country_name'=>'Georgia' , 'country_status'=>'1'],
            ['country_name'=>'Germany' , 'country_status'=>'1'],
            ['country_name'=>'Ghana' , 'country_status'=>'1'],
            ['country_name'=>'Gibraltar' , 'country_status'=>'1'],
            ['country_name'=>'Greece' , 'country_status'=>'1'],
            ['country_name'=>'Greenland' , 'country_status'=>'1'],
            ['country_name'=>'Grenada' , 'country_status'=>'1'],
            ['country_name'=>'Guadeloupe' , 'country_status'=>'1'],
            ['country_name'=>'Guam' , 'country_status'=>'1'],
            ['country_name'=>'Guatemala' , 'country_status'=>'1'],
            ['country_name'=>'Guinea' , 'country_status'=>'1'],
            ['country_name'=>'Guinea-Bissau' , 'country_status'=>'1'],
            ['country_name'=>'Guyana' , 'country_status'=>'1'],
            ['country_name'=>'Haiti' , 'country_status'=>'1'],
            ['country_name'=>'Heard and Mc Donald Islands' , 'country_status'=>'1'],
            ['country_name'=>'Honduras' , 'country_status'=>'1'],
            ['country_name'=>'Hong Kong' , 'country_status'=>'1'],
            ['country_name'=>'Hungary' , 'country_status'=>'1'],
            ['country_name'=>'Iceland' , 'country_status'=>'1'],
            ['country_name'=>'India' , 'country_status'=>'1'],
            ['country_name'=>'Indonesia' , 'country_status'=>'1'],
            ['country_name'=>'Iran (Islamic Republic of)' , 'country_status'=>'1'],
            ['country_name'=>'Iraq' , 'country_status'=>'1'],
            ['country_name'=>'Ireland' , 'country_status'=>'1'],
            ['country_name'=>'Israel' , 'country_status'=>'1'],
            ['country_name'=>'Italy' , 'country_status'=>'1'],
            ['country_name'=>'Ivory Coast' , 'country_status'=>'1'],
            ['country_name'=>'Jamaica' , 'country_status'=>'1'],
            ['country_name'=>'Japan' , 'country_status'=>'1'],
            ['country_name'=>'Jordan' , 'country_status'=>'1'],
            ['country_name'=>'Kazakhstan' , 'country_status'=>'1'],
            ['country_name'=>'Kenya' , 'country_status'=>'1'],
            ['country_name'=>'Kiribati' , 'country_status'=>'1'],
            ['country_name'=>'Korea, Democratic People\'s Republic of' , 'country_status'=>'1'],
            ['country_name'=>'Korea, Republic of' , 'country_status'=>'1'],
            ['country_name'=>'Kuwait' , 'country_status'=>'1'],
            ['country_name'=>'Kyrgyzstan' , 'country_status'=>'1'],
            ['country_name'=>'Lao People\'s Democratic Republic' , 'country_status'=>'1'],
            ['country_name'=>'Latvia' , 'country_status'=>'1'],
            ['country_name'=>'Lebanon' , 'country_status'=>'1'],
            ['country_name'=>'Lesotho' , 'country_status'=>'1'],
            ['country_name'=>'Liberia' , 'country_status'=>'1'],
            ['country_name'=>'Libyan Arab Jamahiriya' , 'country_status'=>'1'],
            ['country_name'=>'Liechtenstein' , 'country_status'=>'1'],
            ['country_name'=>'Lithuania' , 'country_status'=>'1'],
            ['country_name'=>'Luxembourg' , 'country_status'=>'1'],
            ['country_name'=>'Macau' , 'country_status'=>'1'],
            ['country_name'=>'Macedonia' , 'country_status'=>'1'],
            ['country_name'=>'Madagascar' , 'country_status'=>'1'],
            ['country_name'=>'Malawi' , 'country_status'=>'1'],
            ['country_name'=>'Malaysia' , 'country_status'=>'1'],
            ['country_name'=>'Maldives' , 'country_status'=>'1'],
            ['country_name'=>'Mali' , 'country_status'=>'1'],
            ['country_name'=>'Malta' , 'country_status'=>'1'],
            ['country_name'=>'Marshall Islands' , 'country_status'=>'1'],
            ['country_name'=>'Martinique' , 'country_status'=>'1'],
            ['country_name'=>'Mauritania' , 'country_status'=>'1'],
            ['country_name'=>'Mauritius' , 'country_status'=>'1'],
            ['country_name'=>'Mayotte' , 'country_status'=>'1'],
            ['country_name'=>'Mexico' , 'country_status'=>'1'],
            ['country_name'=>'Micronesia, Federated States of' , 'country_status'=>'1'],
            ['country_name'=>'Moldova, Republic of' , 'country_status'=>'1'],
            ['country_name'=>'Monaco' , 'country_status'=>'1'],
            ['country_name'=>'Mongolia' , 'country_status'=>'1'],
            ['country_name'=>'Montserrat' , 'country_status'=>'1'],
            ['country_name'=>'Morocco' , 'country_status'=>'1'],
            ['country_name'=>'Mozambique' , 'country_status'=>'1'],
            ['country_name'=>'Myanmar' , 'country_status'=>'1'],
            ['country_name'=>'Namibia' , 'country_status'=>'1'],
            ['country_name'=>'Nauru' , 'country_status'=>'1'],
            ['country_name'=>'Nauru' , 'country_status'=>'1'],
            ['country_name'=>'Nepal' , 'country_status'=>'1'],
            ['country_name'=>'Netherlands' , 'country_status'=>'1'],
            ['country_name'=>'Netherlands Antilles' , 'country_status'=>'1'],
            ['country_name'=>'New Caledonia' , 'country_status'=>'1'],
            ['country_name'=>'New Zealand' , 'country_status'=>'1'],
            ['country_name'=>'Nicaragua' , 'country_status'=>'1'],
            ['country_name'=>'Niger' , 'country_status'=>'1'],
            ['country_name'=>'Nigeria' , 'country_status'=>'1'],
            ['country_name'=>'Niue' , 'country_status'=>'1'],
            ['country_name'=>'Norfork Island' , 'country_status'=>'1'],
            ['country_name'=>'Northern Mariana Islands' , 'country_status'=>'1'],
            ['country_name'=>'Norway' , 'country_status'=>'1'],
            ['country_name'=>'Oman' , 'country_status'=>'1'],
            ['country_name'=>'Pakistan' , 'country_status'=>'1'],
            ['country_name'=>'Palau' , 'country_status'=>'1'],
            ['country_name'=>'Panama' , 'country_status'=>'1'],
            ['country_name'=>'Papua New Guinea' , 'country_status'=>'1'],
            ['country_name'=>'Paraguay' , 'country_status'=>'1'],
            ['country_name'=>'Peru' , 'country_status'=>'1'],
            ['country_name'=>'Philippines' , 'country_status'=>'1'],
            ['country_name'=>'Pitcairn' , 'country_status'=>'1'],
            ['country_name'=>'Poland' , 'country_status'=>'1'],
            ['country_name'=>'Portugal' , 'country_status'=>'1'],
            ['country_name'=>'Puerto Rico' , 'country_status'=>'1'],
            ['country_name'=>'Qatar' , 'country_status'=>'1'],
            ['country_name'=>'Republic of South Sudan' , 'country_status'=>'1'],
            ['country_name'=>'Reunion' , 'country_status'=>'1'],
            ['country_name'=>'Romania' , 'country_status'=>'1'],
            ['country_name'=>'Russian Federation' , 'country_status'=>'1'],
            ['country_name'=>'Rwanda' , 'country_status'=>'1'],
            ['country_name'=>'Saint Kitts and Nevis' , 'country_status'=>'1'],
            ['country_name'=>'Saint Lucia' , 'country_status'=>'1'],
            ['country_name'=>'Saint Vincent and the Grenadines' , 'country_status'=>'1'],
            ['country_name'=>'Samoa' , 'country_status'=>'1'],
            ['country_name'=>'San Marino' , 'country_status'=>'1'],
            ['country_name'=>'Sao Tome and Principe' , 'country_status'=>'1'],
            ['country_name'=>'Saudi Arabia' , 'country_status'=>'1'],
            ['country_name'=>'Senegal' , 'country_status'=>'1'],
            ['country_name'=>'Serbia' , 'country_status'=>'1'],
            ['country_name'=>'Seychelles' , 'country_status'=>'1'],
            ['country_name'=>'Sierra Leone' , 'country_status'=>'1'],
            ['country_name'=>'Singapore' , 'country_status'=>'1'],
            ['country_name'=>'Slovakia' , 'country_status'=>'1'],
            ['country_name'=>'Slovenia' , 'country_status'=>'1'],
            ['country_name'=>'Solomon Islands' , 'country_status'=>'1'],
            ['country_name'=>'Somalia' , 'country_status'=>'1'],
            ['country_name'=>'South Africa' , 'country_status'=>'1'],
            ['country_name'=>'South Georgia South Sandwich Islands', 'country_status'=>'1'],
            ['country_name'=>'Spain' , 'country_status'=>'1'],
            ['country_name'=>'Sri Lanka' , 'country_status'=>'1'],
            ['country_name'=>'St. Helena' , 'country_status'=>'1'],
            ['country_name'=>'St. Pierre and Miquelon' , 'country_status'=>'1'],
            ['country_name'=>'Sudan' , 'country_status'=>'1'],
            ['country_name'=>'Suriname' , 'country_status'=>'1'],
            ['country_name'=>'Svalbarn and Jan Mayen Islands' , 'country_status'=>'1'],
            ['country_name'=>'Swaziland' , 'country_status'=>'1'],
            ['country_name'=>'Sweden' , 'country_status'=>'1'],
            ['country_name'=>'Switzerland' , 'country_status'=>'1'],
            ['country_name'=>'Syrian Arab Republic' , 'country_status'=>'1'],
            ['country_name'=>'Taiwan' , 'country_status'=>'1'],
            ['country_name'=>'Tajikistan' , 'country_status'=>'1'],
            ['country_name'=>'Tanzania, United Republic of' , 'country_status'=>'1'],
            ['country_name'=>'Thailand' , 'country_status'=>'1'],
            ['country_name'=>'Togo' , 'country_status'=>'1'],
            ['country_name'=>'Tokelau' , 'country_status'=>'1'],
            ['country_name'=>'Tonga' , 'country_status'=>'1'],
            ['country_name'=>'Trinidad and Tobago' , 'country_status'=>'1'],
            ['country_name'=>'Tunisia' , 'country_status'=>'1'],
            ['country_name'=>'Turkey' , 'country_status'=>'1'],
            ['country_name'=>'Turkmenistan' , 'country_status'=>'1'],
            ['country_name'=>'Turks and Caicos Islands' , 'country_status'=>'1'],
            ['country_name'=>'Tuvalu' , 'country_status'=>'1'],
            ['country_name'=>'Uganda' , 'country_status'=>'1'],
            ['country_name'=>'Ukraine' , 'country_status'=>'1'],
            ['country_name'=>'United Arab Emirates' , 'country_status'=>'1'],
            ['country_name'=>'United Kingdom' , 'country_status'=>'1'],
            ['country_name'=>'United States minor outlying islands', 'country_status'=>'1'],
            ['country_name'=>'Uruguay' , 'country_status'=>'1'],
            ['country_name'=>'Uzbekistan' , 'country_status'=>'1'],
            ['country_name'=>'Vanuatu' , 'country_status'=>'1'],
            ['country_name'=>'Vatican City State' , 'country_status'=>'1'],
            ['country_name'=>'Venezuela' , 'country_status'=>'1'],
            ['country_name'=>'Vietnam' , 'country_status'=>'1'],
            ['country_name'=>'Virgin Islands (British)' , 'country_status'=>'1'],
            ['country_name'=>'Virgin Islands (U.S.)' , 'country_status'=>'1'],
            ['country_name'=>'Wallis and Futuna Islands' , 'country_status'=>'1'],
            ['country_name'=>'Western Sahara' , 'country_status'=>'1'],
            ['country_name'=>'Yemen' , 'country_status'=>'1'],
            ['country_name'=>'Yugoslavia' , 'country_status'=>'1'],
            ['country_name'=>'Zaire' , 'country_status'=>'1'],
            ['country_name'=>'Zambia' , 'country_status'=>'1'],
            ['country_name'=>'Zimbabwe' , 'country_status'=>'1'] ];
        foreach ($countries as $country) {
            $existCountry = Country::where('country_name',$country['country_name'])->first();
            if(!$existCountry){
                Country::create($country);
            }
        }

    }
}
