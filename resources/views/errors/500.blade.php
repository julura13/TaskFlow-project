@extends('errors::minimal')

@section('title', __('Server error'))
@section('code', '500')
@section('message', __('Something went wrong on our end.'))
@section('detail', __('We have been notified and are looking into it. Please try again later or return to the dashboard.'))
