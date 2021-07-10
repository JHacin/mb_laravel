@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="container mb-6">
            <h1 class="title">{{ \App\Models\SpecialSponsorship::TYPE_LABELS[$sponsorship_type] }}</h1>
        </div>
    </div>
@endsection
