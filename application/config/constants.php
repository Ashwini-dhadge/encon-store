<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/***********************************************************************/
define('JWT_ENCRYPTION_KEY','test@123');
define('EMAIL_ID', 'wetap_encon@wetap.in');
define('FROM_EMAIL','wetap_encon@wetap.in');
define('EMAIL_PASSWORD', '{g^M}2JQ5k{C');
define('SUPERADMIN_ID', '1');
define('SUPERADMIN_ROLE', '1');
define('ADMIN_ROLE', '2');
define('BRANCH_ROLE', '3');
define('FRANCHISE_ROLE', '4');
define('HUB_ROLE', '5');
define('CUSTOMER', '10');
define('SALES_EMPLOYEE','6');
define('ACCOUNT_EMPLOYEE','7');
define('CUSTOMER_SUPPORT','8');
define('OPERATIONAL_EMPLOYEE','9');
define('DELIVERY_BOY','11');
define('VENDOR_ROLE','12');
define('ADMIN_LOGIN','12');

define('PROJECT_NAME', 'ENCON ERP');
define('ADMIN', 'admin/');
define('AUTH', 'auth/');
define('INC', 'includes/');
define('DASHBOARD', 'dashboard/');
define('MASTERS', 'masters/');
define('RATE_MASTERS', 'rate_master/');
define('CUST', 'customer/');
//path
define('USER_PROFILE', 'assets/uploads/users/');
define('BRANCH_DOCUMENT', 'assets/uploads/branch_document/');
define('DELETED_BRANCH_DOCUMENT', 'assets/deleted_photo/branch_document/');
define('UPLOAD_DOCUMENT', 'assets/uploads/shipment/');

define('LOG_PROFILE', './log/login/');
define('LOG_FILE_PREFIX', 'log_file');
define('ACTION_LOG_PROFILE', './log/action_log/');
define('ACTION_LOG_FILE_PREFIX', 'actionlog_file');

define('VENDOR_IMAGE', 'assets/uploads/vendor_image/');
define('CFSD_DESIGN_FILE', 'assets/uploads/cfds_design_files/');
define('FRP_HEADER_PIPE_DESIGN_FILE', 'assets/uploads/frp_header_pipe_design_files/');
define('FRP_CLAMP_DESIGN_FILE', 'assets/uploads/frp_clamp_design_files/');
define('PO_ATTACH', 'assets/uploads/po_attchment/');
define('GRN_ATTACH', 'assets/uploads/grn_attchment/');

// define('PO_PDF_PATH', 'pdfs/');
define('MANAGER_ROLE', '3');
define('PO_STATUS_PENDING', '0');
define('PO_STATUS_APPROVED', '1');
define('PO_STATUS_REJECTED', '2');

//
define('APPROVED_TYPE_PO', '1');
define('APPROVED_TYPE_ITEM', '2');

define('ADDITIONAL_ATTACHEMENT','assets/uploads/additional_attchment/');
define('PO_PDF_PATH', 'pdfs/');
define('MATERIAL_ISSUE_FILES','assets/uploads/material_issue_attachement/');
//ashwini
define('INVENTORY_ACTION_ADD', '1');
define('INVENTORY_ACTION_ISSUE_MINUS', '2');
define('GRN_TYPE', '1');
define('IS_INVENTORY_REVERSED', '1');
define('ISSUE_TYPE', '2');
define('OPENING_STOCK_TYPE', '3');
define('RECEVIED_STOCK_TYPE', '4');
define('RETURN_TYPE', '5');
define('LAST_YEAR_OPENING_STOCK_TYPE', '6');
define('OPPORTUNITY_TRACKER_IMAGE', 'assets/uploads/opportunity_tracker/');
define('CONSUMPTION_ISSUE', '1');
define('TRANSFER', '2');
define('PRODUCTION', '3');
define('SCRAP', '4');
define('WASTAGE', '5');
define('RE_USABLE', '6');
define('FRESH', '7');
define('RESERVE', '1');
define('NOT_RESERVE', '0');


// 14-02 
define('SALES_LEAD', '1');
define('SALES_OPPORTUNITY', '2');

// 23-02

define('DEFAULT_PLANT_NARRATION', 'default plant narration');

// view_opportunity_tracker type 1 is use add opportunity button
define('OPPORTUNITY_TYPE_ONE', '1');

// view_opportunity_tracker type 2 is use update opportunity button when it type is 0 (main).
define('OPPORTUNITY_TYPE_TWO', '2');

// view_opportunity_tracker type 3 is use update opportunity button when it type is 1 (sub).
define('OPPORTUNITY_TYPE_THREE', '3');

// view_opportunity_tracker type 4 is use manage redirect page condition.
define('OPPORTUNITY_TYPE_FOUR', '4');

define('OPPORTUNITY_STATUS_INPROCESS', '1');
define('OPPORTUNITY_STATUS_COMPLETE', '2');

define('QUOTATION_STATUS_PENDING', '0');
define('QUOTATION_STATUS_APPROVED', '1');
define('QUOTATION_STATUS_REJECTED', '2');

define('QUOTATION_PDF_TITLE', 'Quotation');
// define('BALAJI_PLANT', '6');
//compant id
define('BALAJI_PLANT', '6');
define('ENCON_INTERNATIONAL', '7');
define('ENCON_COOLING_TOWERS_PVT_LTD_PLOT_NO_B_101_SINNAR', '3');