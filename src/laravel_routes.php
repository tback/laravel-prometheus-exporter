<?php

Route::get('metrics', \Tback\PrometheusExporter\LpeController::class . '@metrics')->name('metrics');
