<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return vocountry_id
     */
    public function run()
    {
        DB::table('country')->delete();
        $countries = array(
            array('country_id' => 1,'code' => 'AF' ,'country_name' => "Afghanistan",'phonecode' => 93),
            array('country_id' => 2,'code' => 'AL' ,'country_name' => "Albania",'phonecode' => 355),
            array('country_id' => 3,'code' => 'DZ' ,'country_name' => "Algeria",'phonecode' => 213),
            array('country_id' => 4,'code' => 'AS' ,'country_name' => "American Samoa",'phonecode' => 1684),
            array('country_id' => 5,'code' => 'AD' ,'country_name' => "Andorra",'phonecode' => 376),
            array('country_id' => 6,'code' => 'AO' ,'country_name' => "Angola",'phonecode' => 244),
            array('country_id' => 7,'code' => 'AI' ,'country_name' => "Anguilla",'phonecode' => 1264),
            array('country_id' => 8,'code' => 'AQ' ,'country_name' => "Antarctica",'phonecode' => 0),
            array('country_id' => 9,'code' => 'AG' ,'country_name' => "Antigua And Barbuda",'phonecode' => 1268),
            array('country_id' => 10,'code' => 'AR','country_name' => "Argentina",'phonecode' => 54),
            array('country_id' => 11,'code' => 'AM','country_name' => "Armenia",'phonecode' => 374),
            array('country_id' => 12,'code' => 'AW','country_name' => "Aruba",'phonecode' => 297),
            array('country_id' => 13,'code' => 'AU','country_name' => "Australia",'phonecode' => 61),
            array('country_id' => 14,'code' => 'AT','country_name' => "Austria",'phonecode' => 43),
            array('country_id' => 15,'code' => 'AZ','country_name' => "Azerbaijan",'phonecode' => 994),
            array('country_id' => 16,'code' => 'BS','country_name' => "Bahamas The",'phonecode' => 1242),
            array('country_id' => 17,'code' => 'BH','country_name' => "Bahrain",'phonecode' => 973),
            array('country_id' => 18,'code' => 'BD','country_name' => "Bangladesh",'phonecode' => 880),
            array('country_id' => 19,'code' => 'BB','country_name' => "Barbados",'phonecode' => 1246),
            array('country_id' => 20,'code' => 'BY','country_name' => "Belarus",'phonecode' => 375),
            array('country_id' => 21,'code' => 'BE','country_name' => "Belgium",'phonecode' => 32),
            array('country_id' => 22,'code' => 'BZ','country_name' => "Belize",'phonecode' => 501),
            array('country_id' => 23,'code' => 'BJ','country_name' => "Benin",'phonecode' => 229),
            array('country_id' => 24,'code' => 'BM','country_name' => "Bermuda",'phonecode' => 1441),
            array('country_id' => 25,'code' => 'BT','country_name' => "Bhutan",'phonecode' => 975),
            array('country_id' => 26,'code' => 'BO','country_name' => "Bolivia",'phonecode' => 591),
            array('country_id' => 27,'code' => 'BA','country_name' => "Bosnia and Herzegovina",'phonecode' => 387),
            array('country_id' => 28,'code' => 'BW','country_name' => "Botswana",'phonecode' => 267),
            array('country_id' => 29,'code' => 'BV','country_name' => "Bouvet Island",'phonecode' => 0),
            array('country_id' => 30,'code' => 'BR','country_name' => "Brazil",'phonecode' => 55),
            array('country_id' => 31,'code' => 'IO','country_name' => "British Indian Ocean Territory",'phonecode' => 246),
            array('country_id' => 32,'code' => 'BN','country_name' => "Brunei",'phonecode' => 673),
            array('country_id' => 33,'code' => 'BG','country_name' => "Bulgaria",'phonecode' => 359),
            array('country_id' => 34,'code' => 'BF','country_name' => "Burkina Faso",'phonecode' => 226),
            array('country_id' => 35,'code' => 'BI','country_name' => "Burundi",'phonecode' => 257),
            array('country_id' => 36,'code' => 'KH','country_name' => "Cambodia",'phonecode' => 855),
            array('country_id' => 37,'code' => 'CM','country_name' => "Cameroon",'phonecode' => 237),
            array('country_id' => 38,'code' => 'CA','country_name' => "Canada",'phonecode' => 1),
            array('country_id' => 39,'code' => 'CV','country_name' => "Cape Verde",'phonecode' => 238),
            array('country_id' => 40,'code' => 'KY','country_name' => "Cayman Islands",'phonecode' => 1345),
            array('country_id' => 41,'code' => 'CF','country_name' => "Central African Republic",'phonecode' => 236),
            array('country_id' => 42,'code' => 'TD','country_name' => "Chad",'phonecode' => 235),
            array('country_id' => 43,'code' => 'CL','country_name' => "Chile",'phonecode' => 56),
            array('country_id' => 44,'code' => 'CN','country_name' => "China",'phonecode' => 86),
            array('country_id' => 45,'code' => 'CX','country_name' => "Christmas Island",'phonecode' => 61),
            array('country_id' => 46,'code' => 'CC','country_name' => "Cocos (Keeling) Islands",'phonecode' => 672),
            array('country_id' => 47,'code' => 'CO','country_name' => "Colombia",'phonecode' => 57),
            array('country_id' => 48,'code' => 'KM','country_name' => "Comoros",'phonecode' => 269),
            array('country_id' => 49,'code' => 'CG','country_name' => "Congo",'phonecode' => 242),
            array('country_id' => 50,'code' => 'CD','country_name' => "Congo The Democratic Republic Of The",'phonecode' => 242),
            array('country_id' => 51,'code' => 'CK','country_name' => "Cook Islands",'phonecode' => 682),
            array('country_id' => 52,'code' => 'CR','country_name' => "Costa Rica",'phonecode' => 506),
            array('country_id' => 53,'code' => 'CI','country_name' => "Cote D Ivoire (Ivory Coast)",'phonecode' => 225),
            array('country_id' => 54,'code' => 'HR','country_name' => "Croatia (Hrvatska)",'phonecode' => 385),
            array('country_id' => 55,'code' => 'CU','country_name' => "Cuba",'phonecode' => 53),
            array('country_id' => 56,'code' => 'CY','country_name' => "Cyprus",'phonecode' => 357),
            array('country_id' => 57,'code' => 'CZ','country_name' => "Czech Republic",'phonecode' => 420),
            array('country_id' => 58,'code' => 'DK','country_name' => "Denmark",'phonecode' => 45),
            array('country_id' => 59,'code' => 'DJ','country_name' => "Djibouti",'phonecode' => 253),
            array('country_id' => 60,'code' => 'DM','country_name' => "Dominica",'phonecode' => 1767),
            array('country_id' => 61,'code' => 'DO','country_name' => "Dominican Republic",'phonecode' => 1809),
            array('country_id' => 62,'code' => 'TP','country_name' => "East Timor",'phonecode' => 670),
            array('country_id' => 63,'code' => 'EC','country_name' => "Ecuador",'phonecode' => 593),
            array('country_id' => 64,'code' => 'EG','country_name' => "Egypt",'phonecode' => 20),
            array('country_id' => 65,'code' => 'SV','country_name' => "El Salvador",'phonecode' => 503),
            array('country_id' => 66,'code' => 'GQ','country_name' => "Equatorial Guinea",'phonecode' => 240),
            array('country_id' => 67,'code' => 'ER','country_name' => "Eritrea",'phonecode' => 291),
            array('country_id' => 68,'code' => 'EE','country_name' => "Estonia",'phonecode' => 372),
            array('country_id' => 69,'code' => 'ET','country_name' => "Ethiopia",'phonecode' => 251),
            array('country_id' => 70,'code' => 'XA','country_name' => "External Territories of Australia",'phonecode' => 61),
            array('country_id' => 71,'code' => 'FK','country_name' => "Falkland Islands",'phonecode' => 500),
            array('country_id' => 72,'code' => 'FO','country_name' => "Faroe Islands",'phonecode' => 298),
            array('country_id' => 73,'code' => 'FJ','country_name' => "Fiji Islands",'phonecode' => 679),
            array('country_id' => 74,'code' => 'FI','country_name' => "Finland",'phonecode' => 358),
            array('country_id' => 75,'code' => 'FR','country_name' => "France",'phonecode' => 33),
            array('country_id' => 76,'code' => 'GF','country_name' => "French Guiana",'phonecode' => 594),
            array('country_id' => 77,'code' => 'PF','country_name' => "French Polynesia",'phonecode' => 689),
            array('country_id' => 78,'code' => 'TF','country_name' => "French Southern Territories",'phonecode' => 0),
            array('country_id' => 79,'code' => 'GA','country_name' => "Gabon",'phonecode' => 241),
            array('country_id' => 80,'code' => 'GM','country_name' => "Gambia The",'phonecode' => 220),
            array('country_id' => 81,'code' => 'GE','country_name' => "Georgia",'phonecode' => 995),
            array('country_id' => 82,'code' => 'DE','country_name' => "Germany",'phonecode' => 49),
            array('country_id' => 83,'code' => 'GH','country_name' => "Ghana",'phonecode' => 233),
            array('country_id' => 84,'code' => 'GI','country_name' => "Gibraltar",'phonecode' => 350),
            array('country_id' => 85,'code' => 'GR','country_name' => "Greece",'phonecode' => 30),
            array('country_id' => 86,'code' => 'GL','country_name' => "Greenland",'phonecode' => 299),
            array('country_id' => 87,'code' => 'GD','country_name' => "Grenada",'phonecode' => 1473),
            array('country_id' => 88,'code' => 'GP','country_name' => "Guadeloupe",'phonecode' => 590),
            array('country_id' => 89,'code' => 'GU','country_name' => "Guam",'phonecode' => 1671),
            array('country_id' => 90,'code' => 'GT','country_name' => "Guatemala",'phonecode' => 502),
            array('country_id' => 91,'code' => 'XU','country_name' => "Guernsey and Alderney",'phonecode' => 44),
            array('country_id' => 92,'code' => 'GN','country_name' => "Guinea",'phonecode' => 224),
            array('country_id' => 93,'code' => 'GW','country_name' => "Guinea-Bissau",'phonecode' => 245),
            array('country_id' => 94,'code' => 'GY','country_name' => "Guyana",'phonecode' => 592),
            array('country_id' => 95,'code' => 'HT','country_name' => "Haiti",'phonecode' => 509),
            array('country_id' => 96,'code' => 'HM','country_name' => "Heard and McDonald Islands",'phonecode' => 0),
            array('country_id' => 97,'code' => 'HN','country_name' => "Honduras",'phonecode' => 504),
            array('country_id' => 98,'code' => 'HK','country_name' => "Hong Kong S.A.R.",'phonecode' => 852),
            array('country_id' => 99,'code' => 'HU','country_name' => "Hungary",'phonecode' => 36),
            array('country_id' => 100,'code' => 'IS','country_name' => "Iceland",'phonecode' => 354),
            array('country_id' => 101,'code' => 'IN','country_name' => "India",'phonecode' => 91),
            array('country_id' => 102,'code' => 'country_id','country_name' => "Indonesia",'phonecode' => 62),
            array('country_id' => 103,'code' => 'IR','country_name' => "Iran",'phonecode' => 98),
            array('country_id' => 104,'code' => 'IQ','country_name' => "Iraq",'phonecode' => 964),
            array('country_id' => 105,'code' => 'IE','country_name' => "Ireland",'phonecode' => 353),
            array('country_id' => 106,'code' => 'IL','country_name' => "Israel",'phonecode' => 972),
            array('country_id' => 107,'code' => 'IT','country_name' => "Italy",'phonecode' => 39),
            array('country_id' => 108,'code' => 'JM','country_name' => "Jamaica",'phonecode' => 1876),
            array('country_id' => 109,'code' => 'JP','country_name' => "Japan",'phonecode' => 81),
            array('country_id' => 110,'code' => 'XJ','country_name' => "Jersey",'phonecode' => 44),
            array('country_id' => 111,'code' => 'JO','country_name' => "Jordan",'phonecode' => 962),
            array('country_id' => 112,'code' => 'KZ','country_name' => "Kazakhstan",'phonecode' => 7),
            array('country_id' => 113,'code' => 'KE','country_name' => "Kenya",'phonecode' => 254),
            array('country_id' => 114,'code' => 'KI','country_name' => "Kiribati",'phonecode' => 686),
            array('country_id' => 115,'code' => 'KP','country_name' => "Korea North",'phonecode' => 850),
            array('country_id' => 116,'code' => 'KR','country_name' => "Korea South",'phonecode' => 82),
            array('country_id' => 117,'code' => 'KW','country_name' => "Kuwait",'phonecode' => 965),
            array('country_id' => 118,'code' => 'KG','country_name' => "Kyrgyzstan",'phonecode' => 996),
            array('country_id' => 119,'code' => 'LA','country_name' => "Laos",'phonecode' => 856),
            array('country_id' => 120,'code' => 'LV','country_name' => "Latvia",'phonecode' => 371),
            array('country_id' => 121,'code' => 'LB','country_name' => "Lebanon",'phonecode' => 961),
            array('country_id' => 122,'code' => 'LS','country_name' => "Lesotho",'phonecode' => 266),
            array('country_id' => 123,'code' => 'LR','country_name' => "Liberia",'phonecode' => 231),
            array('country_id' => 124,'code' => 'LY','country_name' => "Libya",'phonecode' => 218),
            array('country_id' => 125,'code' => 'LI','country_name' => "Liechtenstein",'phonecode' => 423),
            array('country_id' => 126,'code' => 'LT','country_name' => "Lithuania",'phonecode' => 370),
            array('country_id' => 127,'code' => 'LU','country_name' => "Luxembourg",'phonecode' => 352),
            array('country_id' => 128,'code' => 'MO','country_name' => "Macau S.A.R.",'phonecode' => 853),
            array('country_id' => 129,'code' => 'MK','country_name' => "Macedonia",'phonecode' => 389),
            array('country_id' => 130,'code' => 'MG','country_name' => "Madagascar",'phonecode' => 261),
            array('country_id' => 131,'code' => 'MW','country_name' => "Malawi",'phonecode' => 265),
            array('country_id' => 132,'code' => 'MY','country_name' => "Malaysia",'phonecode' => 60),
            array('country_id' => 133,'code' => 'MV','country_name' => "Maldives",'phonecode' => 960),
            array('country_id' => 134,'code' => 'ML','country_name' => "Mali",'phonecode' => 223),
            array('country_id' => 135,'code' => 'MT','country_name' => "Malta",'phonecode' => 356),
            array('country_id' => 136,'code' => 'XM','country_name' => "Man (Isle of)",'phonecode' => 44),
            array('country_id' => 137,'code' => 'MH','country_name' => "Marshall Islands",'phonecode' => 692),
            array('country_id' => 138,'code' => 'MQ','country_name' => "Martinique",'phonecode' => 596),
            array('country_id' => 139,'code' => 'MR','country_name' => "Mauritania",'phonecode' => 222),
            array('country_id' => 140,'code' => 'MU','country_name' => "Mauritius",'phonecode' => 230),
            array('country_id' => 141,'code' => 'YT','country_name' => "Mayotte",'phonecode' => 269),
            array('country_id' => 142,'code' => 'MX','country_name' => "Mexico",'phonecode' => 52),
            array('country_id' => 143,'code' => 'FM','country_name' => "Micronesia",'phonecode' => 691),
            array('country_id' => 144,'code' => 'MD','country_name' => "Moldova",'phonecode' => 373),
            array('country_id' => 145,'code' => 'MC','country_name' => "Monaco",'phonecode' => 377),
            array('country_id' => 146,'code' => 'MN','country_name' => "Mongolia",'phonecode' => 976),
            array('country_id' => 147,'code' => 'MS','country_name' => "Montserrat",'phonecode' => 1664),
            array('country_id' => 148,'code' => 'MA','country_name' => "Morocco",'phonecode' => 212),
            array('country_id' => 149,'code' => 'MZ','country_name' => "Mozambique",'phonecode' => 258),
            array('country_id' => 150,'code' => 'MM','country_name' => "Myanmar",'phonecode' => 95),
            array('country_id' => 151,'code' => 'NA','country_name' => "Namibia",'phonecode' => 264),
            array('country_id' => 152,'code' => 'NR','country_name' => "Nauru",'phonecode' => 674),
            array('country_id' => 153,'code' => 'NP','country_name' => "Nepal",'phonecode' => 977),
            array('country_id' => 154,'code' => 'AN','country_name' => "Netherlands Antilles",'phonecode' => 599),
            array('country_id' => 155,'code' => 'NL','country_name' => "Netherlands The",'phonecode' => 31),
            array('country_id' => 156,'code' => 'NC','country_name' => "New Caledonia",'phonecode' => 687),
            array('country_id' => 157,'code' => 'NZ','country_name' => "New Zealand",'phonecode' => 64),
            array('country_id' => 158,'code' => 'NI','country_name' => "Nicaragua",'phonecode' => 505),
            array('country_id' => 159,'code' => 'NE','country_name' => "Niger",'phonecode' => 227),
            array('country_id' => 160,'code' => 'NG','country_name' => "Nigeria",'phonecode' => 234),
            array('country_id' => 161,'code' => 'NU','country_name' => "Niue",'phonecode' => 683),
            array('country_id' => 162,'code' => 'NF','country_name' => "Norfolk Island",'phonecode' => 672),
            array('country_id' => 163,'code' => 'MP','country_name' => "Northern Mariana Islands",'phonecode' => 1670),
            array('country_id' => 164,'code' => 'NO','country_name' => "Norway",'phonecode' => 47),
            array('country_id' => 165,'code' => 'OM','country_name' => "Oman",'phonecode' => 968),
            array('country_id' => 166,'code' => 'PK','country_name' => "Pakistan",'phonecode' => 92),
            array('country_id' => 167,'code' => 'PW','country_name' => "Palau",'phonecode' => 680),
            array('country_id' => 168,'code' => 'PS','country_name' => "Palestinian Territory Occupied",'phonecode' => 970),
            array('country_id' => 169,'code' => 'PA','country_name' => "Panama",'phonecode' => 507),
            array('country_id' => 170,'code' => 'PG','country_name' => "Papua new Guinea",'phonecode' => 675),
            array('country_id' => 171,'code' => 'PY','country_name' => "Paraguay",'phonecode' => 595),
            array('country_id' => 172,'code' => 'PE','country_name' => "Peru",'phonecode' => 51),
            array('country_id' => 173,'code' => 'PH','country_name' => "Philippines",'phonecode' => 63),
            array('country_id' => 174,'code' => 'PN','country_name' => "Pitcairn Island",'phonecode' => 0),
            array('country_id' => 175,'code' => 'PL','country_name' => "Poland",'phonecode' => 48),
            array('country_id' => 176,'code' => 'PT','country_name' => "Portugal",'phonecode' => 351),
            array('country_id' => 177,'code' => 'PR','country_name' => "Puerto Rico",'phonecode' => 1787),
            array('country_id' => 178,'code' => 'QA','country_name' => "Qatar",'phonecode' => 974),
            array('country_id' => 179,'code' => 'RE','country_name' => "Reunion",'phonecode' => 262),
            array('country_id' => 180,'code' => 'RO','country_name' => "Romania",'phonecode' => 40),
            array('country_id' => 181,'code' => 'RU','country_name' => "Russia",'phonecode' => 70),
            array('country_id' => 182,'code' => 'RW','country_name' => "Rwanda",'phonecode' => 250),
            array('country_id' => 183,'code' => 'SH','country_name' => "Saint Helena",'phonecode' => 290),
            array('country_id' => 184,'code' => 'KN','country_name' => "Saint Kitts And Nevis",'phonecode' => 1869),
            array('country_id' => 185,'code' => 'LC','country_name' => "Saint Lucia",'phonecode' => 1758),
            array('country_id' => 186,'code' => 'PM','country_name' => "Saint Pierre and Miquelon",'phonecode' => 508),
            array('country_id' => 187,'code' => 'VC','country_name' => "Saint Vincent And The Grenadines",'phonecode' => 1784),
            array('country_id' => 188,'code' => 'WS','country_name' => "Samoa",'phonecode' => 684),
            array('country_id' => 189,'code' => 'SM','country_name' => "San Marino",'phonecode' => 378),
            array('country_id' => 190,'code' => 'ST','country_name' => "Sao Tome and Principe",'phonecode' => 239),
            array('country_id' => 191,'code' => 'SA','country_name' => "Saudi Arabia",'phonecode' => 966),
            array('country_id' => 192,'code' => 'SN','country_name' => "Senegal",'phonecode' => 221),
            array('country_id' => 193,'code' => 'RS','country_name' => "Serbia",'phonecode' => 381),
            array('country_id' => 194,'code' => 'SC','country_name' => "Seychelles",'phonecode' => 248),
            array('country_id' => 195,'code' => 'SL','country_name' => "Sierra Leone",'phonecode' => 232),
            array('country_id' => 196,'code' => 'SG','country_name' => "Singapore",'phonecode' => 65),
            array('country_id' => 197,'code' => 'SK','country_name' => "Slovakia",'phonecode' => 421),
            array('country_id' => 198,'code' => 'SI','country_name' => "Slovenia",'phonecode' => 386),
            array('country_id' => 199,'code' => 'XG','country_name' => "Smaller Territories of the UK",'phonecode' => 44),
            array('country_id' => 200,'code' => 'SB','country_name' => "Solomon Islands",'phonecode' => 677),
            array('country_id' => 201,'code' => 'SO','country_name' => "Somalia",'phonecode' => 252),
            array('country_id' => 202,'code' => 'ZA','country_name' => "South Africa",'phonecode' => 27),
            array('country_id' => 203,'code' => 'GS','country_name' => "South Georgia",'phonecode' => 0),
            array('country_id' => 204,'code' => 'SS','country_name' => "South Sudan",'phonecode' => 211),
            array('country_id' => 205,'code' => 'ES','country_name' => "Spain",'phonecode' => 34),
            array('country_id' => 206,'code' => 'LK','country_name' => "Sri Lanka",'phonecode' => 94),
            array('country_id' => 207,'code' => 'SD','country_name' => "Sudan",'phonecode' => 249),
            array('country_id' => 208,'code' => 'SR','country_name' => "Suricountry_name",'phonecode' => 597),
            array('country_id' => 209,'code' => 'SJ','country_name' => "Svalbard And Jan Mayen Islands",'phonecode' => 47),
            array('country_id' => 210,'code' => 'SZ','country_name' => "Swaziland",'phonecode' => 268),
            array('country_id' => 211,'code' => 'SE','country_name' => "Sweden",'phonecode' => 46),
            array('country_id' => 212,'code' => 'CH','country_name' => "Switzerland",'phonecode' => 41),
            array('country_id' => 213,'code' => 'SY','country_name' => "Syria",'phonecode' => 963),
            array('country_id' => 214,'code' => 'TW','country_name' => "Taiwan",'phonecode' => 886),
            array('country_id' => 215,'code' => 'TJ','country_name' => "Tajikistan",'phonecode' => 992),
            array('country_id' => 216,'code' => 'TZ','country_name' => "Tanzania",'phonecode' => 255),
            array('country_id' => 217,'code' => 'TH','country_name' => "Thailand",'phonecode' => 66),
            array('country_id' => 218,'code' => 'TG','country_name' => "Togo",'phonecode' => 228),
            array('country_id' => 219,'code' => 'TK','country_name' => "Tokelau",'phonecode' => 690),
            array('country_id' => 220,'code' => 'TO','country_name' => "Tonga",'phonecode' => 676),
            array('country_id' => 221,'code' => 'TT','country_name' => "Trincountry_idad And Tobago",'phonecode' => 1868),
            array('country_id' => 222,'code' => 'TN','country_name' => "Tunisia",'phonecode' => 216),
            array('country_id' => 223,'code' => 'TR','country_name' => "Turkey",'phonecode' => 90),
            array('country_id' => 224,'code' => 'TM','country_name' => "Turkmenistan",'phonecode' => 7370),
            array('country_id' => 225,'code' => 'TC','country_name' => "Turks And Caicos Islands",'phonecode' => 1649),
            array('country_id' => 226,'code' => 'TV','country_name' => "Tuvalu",'phonecode' => 688),
            array('country_id' => 227,'code' => 'UG','country_name' => "Uganda",'phonecode' => 256),
            array('country_id' => 228,'code' => 'UA','country_name' => "Ukraine",'phonecode' => 380),
            array('country_id' => 229,'code' => 'AE','country_name' => "United Arab Emirates",'phonecode' => 971),
            array('country_id' => 230,'code' => 'GB','country_name' => "United Kingdom",'phonecode' => 44),
            array('country_id' => 231,'code' => 'US','country_name' => "United States",'phonecode' => 1),
            array('country_id' => 232,'code' => 'UM','country_name' => "United States Minor Outlying Islands",'phonecode' => 1),
            array('country_id' => 233,'code' => 'UY','country_name' => "Uruguay",'phonecode' => 598),
            array('country_id' => 234,'code' => 'UZ','country_name' => "Uzbekistan",'phonecode' => 998),
            array('country_id' => 235,'code' => 'VU','country_name' => "Vanuatu",'phonecode' => 678),
            array('country_id' => 236,'code' => 'VA','country_name' => "Vatican City State (Holy See)",'phonecode' => 39),
            array('country_id' => 237,'code' => 'VE','country_name' => "Venezuela",'phonecode' => 58),
            array('country_id' => 238,'code' => 'VN','country_name' => "Vietnam",'phonecode' => 84),
            array('country_id' => 239,'code' => 'VG','country_name' => "Virgin Islands (British)",'phonecode' => 1284),
            array('country_id' => 240,'code' => 'VI','country_name' => "Virgin Islands (US)",'phonecode' => 1340),
            array('country_id' => 241,'code' => 'WF','country_name' => "Wallis And Futuna Islands",'phonecode' => 681),
            array('country_id' => 242,'code' => 'EH','country_name' => "Western Sahara",'phonecode' => 212),
            array('country_id' => 243,'code' => 'YE','country_name' => "Yemen",'phonecode' => 967),
            array('country_id' => 244,'code' => 'YU','country_name' => "Yugoslavia",'phonecode' => 38),
            array('country_id' => 245,'code' => 'ZM','country_name' => "Zambia",'phonecode' => 260),
            array('country_id' => 246,'code' => 'ZW','country_name' => "Zimbabwe",'phonecode' => 263),
        );
        DB::table('country')->insert($countries);
    }
}
