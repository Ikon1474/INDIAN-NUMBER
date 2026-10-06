<?php

header('Content-Type: application/json');

require_once __DIR__ . '/vendor/autoload.php';

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;

$number = $_GET['number'] ?? '';

if (empty($number)) {
    echo json_encode([
        "status" => false,
        "message" => "Parameter number required",
        "example" => "?number=+919876543210",
        "api_by" => "https://t.me/username_506",
        "support" => "https://t.me/username_506"
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

try {

    $phoneUtil = PhoneNumberUtil::getInstance();

    $phoneNumber = $phoneUtil->parse($number, null);

    $valid = $phoneUtil->isValidNumber($phoneNumber);
    $possible = $phoneUtil->isPossibleNumber($phoneNumber);

    $region = $phoneUtil->getRegionCodeForNumber($phoneNumber);

    $countryNames = [
        "IN" => "India",
        "BD" => "Bangladesh",
        "PK" => "Pakistan",
        "US" => "United States",
        "GB" => "United Kingdom",
        "CA" => "Canada",
        "AU" => "Australia",
        "AE" => "United Arab Emirates",
        "SA" => "Saudi Arabia",
        "NP" => "Nepal",
        "LK" => "Sri Lanka"
    ];

    $country = $countryNames[$region] ?? $region;

    $type = $phoneUtil->getNumberType($phoneNumber);

    $types = [
        PhoneNumberType::FIXED_LINE => "Fixed Line",
        PhoneNumberType::MOBILE => "Mobile",
        PhoneNumberType::FIXED_LINE_OR_MOBILE => "Fixed Line Or Mobile",
        PhoneNumberType::TOLL_FREE => "Toll Free",
        PhoneNumberType::PREMIUM_RATE => "Premium Rate",
        PhoneNumberType::SHARED_COST => "Shared Cost",
        PhoneNumberType::VOIP => "VOIP",
        PhoneNumberType::PERSONAL_NUMBER => "Personal Number",
        PhoneNumberType::PAGER => "Pager",
        PhoneNumberType::UAN => "UAN",
        PhoneNumberType::VOICEMAIL => "Voicemail",
        PhoneNumberType::UNKNOWN => "Unknown"
    ];

    $response = [
        "status" => true,
        "number" => $number,
        "country" => $country,
        "country_code" => $phoneNumber->getCountryCode(),
        "region" => $region,
        "national_number" => (string)$phoneNumber->getNationalNumber(),
        "international_format" => $phoneUtil->format(
            $phoneNumber,
            PhoneNumberFormat::INTERNATIONAL
        ),
        "national_format" => $phoneUtil->format(
            $phoneNumber,
            PhoneNumberFormat::NATIONAL
        ),
        "e164_format" => $phoneUtil->format(
            $phoneNumber,
            PhoneNumberFormat::E164
        ),
        "valid" => $valid,
        "possible" => $possible,
        "type" => $types[$type] ?? "Unknown",
        "carrier" => "Unknown",
        "timezone" => "Asia/Kolkata",
        "timestamp" => time(),
        "api_by" => "https://t.me/username_506",
        "support" => "https://t.me/username_506"
    ];

    echo json_encode(
        $response,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
    );

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "error" => $e->getMessage(),
        "api_by" => "https://t.me/username_506",
        "support" => "https://t.me/username_506"
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

}
?>