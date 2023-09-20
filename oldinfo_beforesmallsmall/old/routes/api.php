<?php

use App\Http\Controllers\UserAPIController;
use App\Http\Controllers\TenantAPIController;
use App\Http\Controllers\LandlordAPIController;
use App\Http\Controllers\PropertyAPIController;
use App\Http\Controllers\VerificationAPIController;
use App\Http\Controllers\TransactionAPIController;
use App\Http\Controllers\InspectionAPIController;
use App\Http\Controllers\PayoutAPIController;
use App\Http\Controllers\BookingAPIController;
use App\Http\Controllers\ReportRepairAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user-api/{id?}',[UserAPIController::class,'userAPI']);
Route::get('user-count-api/{id?}',[UserAPIController::class,'userCountAPI']);
Route::get('usercx-api/{id?}',[UserAPIController::class,'userCXAPI']);

Route::get('tenant-api/{id?}',[TenantAPIController::class,'tenantAPI']);
Route::get('tenant-profile-api/{id?}',[TenantAPIController::class,'tenantProfile']);
Route::get('tenant-rental-info/{id?}',[TenantAPIController::class,'tenantRentalInfo']);
Route::put('update-account-manager-api',[TenantAPIController::class,'updateAccountManagerAPI']);

Route::get('landlord-api/{id?}',[LandlordAPIController::class,'landlordAPI']);
Route::get('landlord-count-api/{id?}',[LandlordAPIController::class,'landlordCountAPI']);
Route::post('add-landlord-api',[LandlordAPIController::class,'addLandlordAPI']);

Route::get('property-api/{id?}',[PropertyAPIController::class,'propertyAPI']);
Route::post('add-property-api',[PropertyAPIController::class,'addPropertyAPI']);
Route::put('edit-property-api',[PropertyAPIController::class,'editPropertyAPI']);

Route::get('verification-api/{id?}',[VerificationAPIController::class,'verificationAPI']);
Route::get('verification-count-api/{id?}',[VerificationAPIController::class,'verificationCountAPI']);

Route::get('transaction-api/{id?}',[TransactionAPIController::class,'transactionAPI']);
Route::get('transaction-count-api/{id?}',[TransactionAPIController::class,'transactionCountAPI']);

Route::get('inspection-api/{id?}',[InspectionAPIController::class,'inspectionAPI']);
Route::get('inspection-count-api/{id?}',[InspectionAPIController::class,'inspectionCountAPI']);
Route::put('update-inspection-api',[InspectionAPIController::class,'updateInspectionAPI']);

Route::get('payout-api/{id?}',[PayoutAPIController::class,'payoutAPI']);
Route::post('add-payout-api',[PayoutAPIController::class,'addPayoutAPI']);

Route::get('all-repair-api/{id?}',[ReportRepairAPIController::class,'allRepairAPI']);
Route::post('report-repair-api',[ReportRepairAPIController::class,'reportRepairAPI']);

Route::get('booking-api/{id?}',[BookingAPIController::class,'bookingAPI']);
Route::get('booking-distinct-count-api/{id?}',[BookingAPIController::class,'bookingDistinctCountAPI']);
Route::get('booking-distinct-tenant-api/{id?}',[BookingAPIController::class,'bookingDistinctTenantAPI']);

