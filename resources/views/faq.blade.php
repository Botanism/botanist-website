@extends('layouts.master')

@section('content')
    <div class="container faq">
        <h1 class="page-title">{{$Lang->get('navbar_faq')}}</h1>

        @if($faqMissingLanguage)
            <div class="alert alert-warning">{{$Lang->get('faq_not_available_language')}}</div>
        @else
            @foreach($faq as $category)
                <h2>{{$category->category}}</h2>
                <div class="faq-box">
                    @foreach($category->questions as $question)
                        <div class="faq-container" id="{{Str::slug($question->question, '_')}}">
                            <a class="faq-question"><i class="fas fa-chevron-right"></i> {{$question->question}}</a>
                            <div class="faq-answer">{!! $question->answer !!}</div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
@endsection