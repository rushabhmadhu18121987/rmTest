<?php

/* Common global params */
define('OK', 200);
define('NON_AUTHORITATIVE', 203);
define('NO_CONTENT', 204);
define('BAD_REQUEST', 400);
define('ACCESS_DENINED', 401);
define('NOT_FOUND', 404);
define('METHOD_NOT_ALLOWED', 405);
define('NOT_ACCEPTABLE', 406);
define('CONFLICT', 409);
define('BAD_GATEWAY', 502);
define('INTERNAL_SERVER_ERROR', 500);
//
define('PRIVATE_KEY', 'af0bd6e01ee771e0ab9ae96e47e4247f');
define('SECRET_KEY', 'basecode@spaceo');
define('HASH_KEY', 'sha256');


// DEFINE SCENARIO
define('SCH_DEFAULT', 'default');
define('SCH_CREATE', 'create');
define('SCH_FILTER', 'filter');
define('SCH_UPDATE', 'update');
define('SCH_CONFIRM', 'confirm');
define('SCH_APPROVE', 'approve');
define('SCH_DISAPPROVE', 'disapprove');
define('SCH_CANCEL', 'cancel');
define('SCH_EXTEND', 'extend');
define('SCH_DELETE', 'delete');
define('SCH_SIGNUP', 'signup');
define('SCH_SIGNIN', 'signin');
define('SCH_PAYMENT', 'payment');
define('SCH_VERIFY_OTP', 'verify_otp');
define('SCH_RESEND_OTP', 'resend_otp');
define('SCH_FORGOT_PASSWORD', 'forgot_password');
define('SCH_CHANGE_PASSWORD', 'change_password');
define('SCH_SOCIAL_SIGNIN', 'social_signin');
define('SCH_SOCIAL_SIGNUP', 'social_signup');
define('SCH_UPDATE_PROFILE', 'update_profile');
define('SCH_ADD_MOBILENO', 'add_mobile_number');

$hostName = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
$serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
if (getenv('ENV_VAR') == "local") {                  // local server configuration
    $projectPath = '/project/veebo-web/code/';
} else if (getenv('ENV_VAR') == "development_dev2") {    // dev server configuration
    $projectPath = '/project/veebo-web/code/';
} else if (getenv('ENV_VAR') == "production") {     // Production Confuguration
    $projectPath = '/';
} else {     // Production Confuguration
    $projectPath = '/';
}

$baseUrl = $hostName . $projectPath;
$apiPath = $projectPath . 'api/v1';
// Define API Constant
define('PROJECT_NAME', 'Basecode v5');
define('API_VERSION', '1.0.0');
define('API_HOST', $serverName);
define('API_PATH', $apiPath);

$s3Url = 'https://s3.us-east-2.amazonaws.com/nearby-deployments-mobilehub-1821461399/';

return [
    'user.passwordResetTokenExpire' => 3600,
    //'PASSWORD_RESET_TOKEN_EXPIRE' => 3600,
    'DEFAULT_LANG' => 'en',
    'BASE_URL' => $baseUrl,
    'BACKEND_URL' => $baseUrl . 'backend/web/',
    //Logo Image URL
    'LOGO_URL' => $baseUrl . 'uploads/site_logo.png',
    'LOGO_MINI_URL' => $baseUrl . 'uploads/logo.png',
    /* S3 images url */
    'S3_URL' => $s3Url,
    'USER_PIC_URL' => $s3Url . 'users/',    
    'USER_PROFILE' => 'users',    
    'CATEGORY_URL' => $s3Url . 'category/',
    'FAVICON_BACKEND_URL' => $baseUrl . 'backend/web/img/favicon/',
    
    //'DEFAULT_COMPANY_PIC' => $s3Url . 'user_icon.png',

    /* Pagination size for API */
    'BUSINESS_PAGE_SIZE' => 10,
    'RATING_PAGE_SIZE' => 10,
    'EVENT_PAGE_SIZE' => 10,
    /* Smtp */
    'SMTP_FROM_EMAIL' => 'akshayb.spaceo@gmail.com',
    'DEVELOPER_EMAIL' => 'akshayb.spaceo@gmail.com',
    /* Social */
    'FB_URL' => 'https://graph.facebook.com/me',
    'FB_RETURN_FIELDS' => 'picture.width(100).height(100),first_name,last_name,email,gender,birthday,location{location}',
    'GOOGLE_URL' => 'https://people.googleapis.com/v1/people/me?personFields=photos,names,emailAddresses,genders,birthdays,phoneNumbers',
    /* AWS S3 */
    'AWS_REGION' => 'us-east-2',
    'AWS_KEY' => 'AKIAJIMNMVSZGQCIE7IQ',
    'AWS_SECRET' => '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',
    'AWS_BUCKET' => 'nearby-deployments-mobilehub-1821461399',
    /* FCM */
    'FCM_API_SERVER_URL' => 'https://fcm.googleapis.com/fcm/send',
    'FCM_SERVER_KEY' => '',
    /* Twilio */
    'TWILIO_SID' => 'AC6809380f8f98aeeb146fb0eeb6df1582',
    'TWILIO_TOKEN' => 'cd3e0d9a67ffc73412b664fdbe46db73',
    'TWILIO_FROM_NO' => '+12727703582',
    
    'api_url_v1' => $baseUrl . "api/v1/",
    'PROFILE_IMAGE_URL' => $baseUrl . 'uploads/',
    'DEAL_PIC' => $s3Url . 'category/',
    /* Start img  Path */
    'FAVICON_IMAGE_URL' => $baseUrl . 'uploads/appWayParkingFavicon_2x.png',
    'FRONTEND_URL' => $baseUrl . "frontend/web/",
    'FRONTEND_IMAGES_URL' => $baseUrl . "frontend/web/images/",
    'LEASE_SPACE_IMAGES_URL' => $baseUrl . 'uploads/lease_space/',
    'FRONTEND_URL_IMAGES_FAVICON' => $baseUrl . 'uploads/logo_favicon.png',
    /* END img  Path */
    'DEFAULT_IMAGE_URL' => $s3Url . 'profile_pic.png',
    'STRIPE_SECRET_KEY' => 'sk_test_kXNIWzteaZaeeGM2OBd2li2q',
    'STRIPE_PUBLIC_KEY' => 'pk_test_QKxBmaf5M3W2AGAbhCaQUBr6',
    'SITE_CURRENCY' => 'USD',
];
