@extends('errors::minimal')

@section('title', __('Access denied'))
@section('code', '403')
@section('message', __("You don't have permission to view this page."))
@section('detail', __($exception->getMessage() ?: 'If you believe this is an error, please contact support or try another action.'))
