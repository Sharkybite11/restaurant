// Xendit Routes
Route::prefix('xendit')->group(function () {
    Route::post('/invoice', [XenditController::class, 'createInvoice']);
    Route::get('/invoice/{invoiceId}', [XenditController::class, 'getInvoice']);
    Route::post('/webhook', [XenditController::class, 'webhook']);
}); 