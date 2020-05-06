@extends('layouts.master')

@section('content')
    <div class="container faq">
        <h1 class="page-title">{{$Lang->get('navbar_faq')}}</h1>

        <h2>{{$Lang->get('common_questions', 'faq')}}</h2>
        <div class="faq-box">
            <div class="faq-container">
                <a class="faq-question"><i class="fas fa-chevron-right"></i> {{$Lang->get('why_this_bot_q', 'faq')}}</a>
                <div class="faq-answer">{!! $Lang->get('why_this_bot_a', 'faq') !!}</div>
            </div>
            <div class="faq-container">
                <a class="faq-question"><i class="fas fa-chevron-right"></i> {{$Lang->get('what_is_os_q', 'faq')}}</a>
                <div class="faq-answer">{!! $Lang->get('what_is_os_a', 'faq') !!}</div>
            </div>
        </div>
    </div>
@endsection