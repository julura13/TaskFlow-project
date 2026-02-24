@extends('errors::minimal')

@section('title', __('Too many requests'))
@section('code', '429')
@section('message', __('You have made too many requests.'))
@section('detail', __('Please wait a moment and try again.'))
