@extends('errors::minimal')

@section('title', __('Page not found'))
@section('code', '404')
@section('message', __("Oops, you've reached a page that doesn't exist."))
@section('detail', __("The link may be broken or the page may have been removed. Try going back or use the button below to return to the dashboard."))
