@extends('errors::minimal')

@section('title', __('Service unavailable'))
@section('code', '503')
@section('message', __('We are temporarily unavailable.'))
@section('detail', __('We are performing maintenance or the service is overloaded. Please try again in a few minutes.'))
