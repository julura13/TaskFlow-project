@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('You need to sign in to view this page.'))
@section('detail', __('Please log in and try again.'))
