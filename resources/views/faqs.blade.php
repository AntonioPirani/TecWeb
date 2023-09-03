@extends('layouts.public')

@section('title', 'FAQs')

@section('content')
    <div class="container">
        <h1 class="faq-title">Frequently Asked Questions</h1>

        <ul class="faq-list">
            @foreach ($faqs as $faq)
                <li class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        {{ $faq->domanda }}
                    </div>
                    <div class="faq-answer">
                        {{ $faq->risposta }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        function toggleFaq(question) {
            const faqItem = question.parentNode;
            const answer = faqItem.querySelector('.faq-answer');

            if (faqItem.classList.contains('open')) {
                faqItem.classList.remove('open');
                answer.style.display = 'none';
            } else {
                faqItem.classList.add('open');
                answer.style.display = 'block';
            }
        }
    </script>
@endsection
