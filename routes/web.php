<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('login');

// Route::group(['prefix'=>'client','namespace'=>'api'], function(){
// //echo 123123;die();
  
//   Route::get('foo', function () {
//     return 'Hello World';
// });
// });

Route::get('/','EmpLoginController@index')->name('login');
Route::get('/dashbord', 'DashboardController@dashboard')->name('home');
Route::post('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/logout', 'DashboardController@logout')->name('logout');

Route::get('/manage-hairstyle', 'HairStyleController@index')->name('manage_hairstyle');
Route::get('/manage-hairstyle-list', 'HairStyleController@list')->name('manage_hairstyle_list');
Route::get('/add-hairstyle', 'HairStyleController@add')->name('add_hairstyle');
Route::post('/save-hairstyle', 'HairStyleController@save')->name('save_hairstyle');


Route::get('/manage-service', 'ServiceController@index')->name('manage_service');
Route::get('/manage-service-list', 'ServiceController@list')->name('manage_service_list');
Route::get('/add-service', 'ServiceController@add')->name('add_service');
Route::post('/save-service', 'ServiceController@save')->name('save_service');
Route::get('/edit-service', 'ServiceController@edit')->name('edit_service');
Route::post('/update-service', 'ServiceController@update')->name('update_service');
Route::post('/delete-service', 'ServiceController@delete')->name('delete_service');



Route::get('/manage-employee', 'EmployeeController@index')->name('manage_employee');
Route::get('/manage-employee-list', 'EmployeeController@list')->name('manage_employee_list');
Route::get('/add-employee', 'EmployeeController@add')->name('add_employee');
Route::post('/save-employee', 'EmployeeController@save')->name('save_employee');
Route::post('/update-employee', 'EmployeeController@update')->name('update_employee');



Route::get('/manage-schedule', 'ScheduleController@index')->name('manage_schedule');
Route::get('/manage-schedule-list', 'ScheduleController@list')->name('manage_schedule_list');
Route::get('/add-schedule', 'ScheduleController@index')->name('add_schedule');
Route::post('/save-schedule', 'ScheduleController@save')->name('save_schedule');



Route::post('/delete-user', 'AdminController@delete_user')->name('delete_user');
Route::post('/delete-employee', 'AdminController@delete_employee')->name('delete_employee');


Route::get('/manage-booking', 'BookingController@index')->name('manage_booking');
Route::get('/manage-booking-p', 'BookingController@previous_booking')->name('manage_booking_p');
Route::get('/manage-booking-list', 'BookingController@list')->name('manage_booking_list');
Route::get('/manage-booking-prev-list', 'BookingController@previous_list')->name('manage_prev_booking_list');
Route::get('/accept-booking/{id}', 'BookingController@accept')->name('accept_booking');


Route::get('/manage-customer', 'UserController@index')->name('manage_customer');
Route::get('/manage-customer-list', 'UserController@list')->name('manage_customer_list');


Route::get('/barber-account', 'BarberController@account')->name('barber_account');
Route::get('/barber-cng-pass', 'BarberController@cng_pass')->name('barber_cng_pass');
Route::post('/barber-update-pass', 'BarberController@update_pass')->name('update_pass');
Route::get('/barber-payment', 'BarberController@payment')->name('barber_payment');
Route::get('/barber-contact', 'BarberController@contact')->name('barber_contact');
Route::post('/barber-contact-save', 'BarberController@contact_save')->name('save_message');


Route::get('/manage-gallery', 'GalleryController@index')->name('manage_gallery');
//Route::get('/manage-schedule-list', 'GalleryController@list')->name('manage_schedule_list');
Route::get('/add-gallery', 'GalleryController@add')->name('add_gallery');
Route::post('/save-gallery', 'GalleryController@save')->name('save_gallery');



Route::get('/terms-condition', 'PagesController@index')->name('terms_condition');
Route::post('/save-terms', 'PagesController@save_terms')->name('save_terms');

//Routes for admin ==============================================
Route::get('/admin', 'AdminLoginController@index')->name('admin_login');
Route::post('/admin-login-check', 'AdminLoginController@login_check')->name('admin_login_check');
Route::get('/admin-dashboard', 'AdminController@index')->name('admin_dashboard');
Route::get('/admin-barbers', 'AdminController@manage_barbers')->name('manage_barbers');
Route::get('/admin-barbers-list', 'AdminController@manage_barbers_list')->name('manage_barbers_list');
Route::get('/admin-users', 'AdminController@manage_users')->name('manage_users');
Route::get('/admin-users-list', 'AdminController@manage_users_list')->name('manage_users_list');
Route::get('/admin-barber-detail', 'AdminController@barber_detail')->name('barber_detail');

Route::get('/admin-logout', 'AdminController@logout')->name('admin_logout');

Route::get('/settings', 'AdminController@settings')->name('settings');
Route::post('/save_settings', 'AdminController@save_settings')->name('save_settings');

//=======================================================================================
//======================================   API   ========================================
//=======================================================================================

// Api Routes for Barber

Route::post('app-login', 'API@login');
Route::post('app-client-register', 'API@client_register');
Route::post('app-barber-register', 'API@barber_register');
Route::post('app-saloon-register', 'API@saloon_register');

Route::get('app-get-countries', 'API@get_countries');
Route::get('app-get-states', 'API@get_states');

Route::get('app-get-my-homepage-info/{id}', 'API@get_my_homepage_info');
//Route::get('app-get-my-service/{id}', 'API@get_my_services');
Route::post('app-create-service', 'API@create_services');
Route::post('app-update-service', 'API@update_services');


Route::get('app-get-barber-profile-info/{id}', 'API@get_barber_info');
Route::get('app-get-client-profile/{id}', 'API@get_client_profile');
//Route::get('app-get-my-gallery/{id}', 'API@get_my_gallery');
Route::post('app-save-gallery', 'API@save_gallery');
//Route::get('app-get-my-bookings/{id}', 'API@get_my_bookings');
//Route::get('app-get-my-reviews/{id}', 'API@get_my_reviews');


Route::get('app-get-offset-wise-work', 'API@get_offset_wise_work');

Route::post('app-invite-with-email', 'API@invite_with_email');

Route::get('app-edit-service/{id}', 'API@edit_service');
Route::get('app-delete-service/{id}', 'API@delete_service');

Route::post('app-update-profile', 'API@update_profile');
Route::post('app-cng-barber-pass', 'API@change_barber_pass');

//Api Routes for Clients
Route::get('app-get-my-home-info/{id}', 'API@get_my_homeinfo');
Route::get('app-get-barber-profile/{id}/{any}', 'API@get_barber_profile');
Route::get('app-get-edit-location-info/{id}', 'API@get_edit_location_info');


Route::get('app-get-offset-stylist/{id}', 'API@get_offset_wise_stylist');
Route::get('app-get-offset-styles/{id}', 'API@get_offset_wise_styles');

Route::get('app-get-my-favs/{id}', 'API@get_my_favs');
Route::get('app-get-my-all-fav-stylist/{id}', 'API@get_my_all_fav_stylist');
Route::get('app-get-my-all-fav-styles/{id}', 'API@get_my_all_fav_styles');


Route::get('app-remove-my-favs/{id}', 'API@remove_my_favs');
Route::post('app-add-payment', 'API@add_payment');

Route::get('app-get-clients-gallery/{id}', 'API@get_clients_gallery');
Route::get('app-remove-clients-gallery/{id}', 'API@remove_clients_gallery');
Route::get('app-remove-barber-gallery/{id}', 'API@remove_barbers_gallery');

Route::post('app-add-review', 'API@add_review');

Route::post('app-update-barber-info', 'API@update_barber_info');

Route::get('app-make-fav/{id}/{any}', 'API@make_fav');
Route::get('app-rmv-fav/{id}/{any}', 'API@rmv_fav');

Route::get('app-find-barber', 'API@find_barber');
Route::get('app-get-all-service/{id}', 'API@get_all_services');

Route::get('app-make-fav-style/{id}/{any}', 'API@make_fav_style');
Route::get('app-rmv-fav-style/{id}', 'API@rmv_fav_style');

Route::post('app-update-client-profile', 'API@update_client_profile');

Route::get('app-get-booking-info/{id}/{any}', 'API@get_booking_info');
Route::get('app-get-booking-info-by-id/{id}', 'API@get_booking_info_id');

Route::get('app-get-offset-gallery/{id}', 'API@get_offset_gallery');


Route::get('app-get-booking-schedule', 'API@get_booking_schedule');
Route::get('app-get-saloon-wise-barber/{id}', 'API@get_saloon_wise_barber');
Route::get('app-get-remove-barber/{id}', 'API@get_remove_barber');


Route::post('app-make-booking', 'API@make_booking');



Route::get('app-get-my-bookings', 'API@get_my_booking');
Route::get('app-booking-confirm', 'API@confirm_booking');
Route::get('app-booking-cancel', 'API@cancel_booking');
Route::get('app-get-barber-booking/{id}', 'API@get_barber_booking');
Route::get('app-barber-confirm-booking', 'API@barber_booking_confirm');
Route::get('app-barber-cancel-booking', 'API@barber_booking_cancel');

Route::get('app-get-barber-waitlist', 'API@barber_get_wishlist');


Route::get('app-forget-user', 'API@forget_user');
Route::get('app-chek-reset-code-user', 'API@check_user_reset_code');
Route::post('app-reset-forgotten-password', 'API@reset_forgotten_password');
Route::get('search-user-by-emailorphn', 'API@searchUserByEmailOrPhn');

Route::get('app-search-barber-with-name', 'API@search_barber_with_name');
Route::get('app-get-payment', 'API@get_payment');

Route::get('app-get-settings', 'API@get_settings');


// Get Place Api
Route::get('app-get-place', 'API@get_place');

Route::get('app-get-barber-with-location', 'API@get_barber_with_location');

// ================================= API route for salon ============================
Route::get('app-get-salon-profile/{id}', 'API@get_salon_profile');

// ============================= Notification API ==============================
Route::post('app-subscription-barber', 'API@subscribe_barber');
Route::post('app-subscription-user', 'API@subscribe_user');



//=======================  work in 30-03-2020 ==============================
Route::get('app-waitlist-confirm', 'API@waitlist_confirm');
Route::get('app-waitlist-cancel', 'API@waitlist_cancel');
Route::get('app-waitlist-complete', 'API@waitlist_complete');

//=======================  work in 31-03-2020 ==============================
Route::get('app-get-salon-and-offset-wise-arber', 'API@salon_and_offset_wise_barber');























