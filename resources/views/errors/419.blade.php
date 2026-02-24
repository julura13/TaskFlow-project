@extends('errors::minimal')

@section('title', __('Page expired'))
@section('code', '419')
@section('message', __('Your session has expired.'))
@section('detail', __('Please refresh the page and try again. Your form may need to be resubmitted.'))
