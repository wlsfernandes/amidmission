@extends('frontend.layouts.app')

@section('title', 'Our Team')

@section('content')

<section class="team__section pt-130 pb-130 overhid">
    <div class="container">

        @foreach ($sectors as $sector)

            @if ($sector->teams->count())

                {{-- Sector Title --}}
                <div class="mb-5">
                    <h2 class="heading-gradient-green-black text-center">
                        {{ $sector->name }}
                    </h2>
                </div>

             <div class="row justify-content-center">

                    @foreach ($sector->teams as $team)

                        <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4">
                            <div class="team__items position-relative h-100">

                                {{-- Full Card Click --}}
                                <a href="{{ route('team.profile', $team->slug) }}"
                                   class="stretched-link"
                                   aria-label="{{ $team->name }}">
                                </a>

                                {{-- Image --}}
                                <div class="team__thumb">
                                    <img
                                        src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                                        alt="{{ $team->name }}"
                                        class="img-fluid w-100"
                                        loading="lazy">
                                </div>

                                {{-- Content --}}
                                <div class="team__content text-center p-3">
                                    <h6 class="mb-1">{{ $team->name }}</h6>

                                    @if ($team->role)
                                        <span class="team-role-badge">
                                            {{ $team->role }}
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>

                    @endforeach

                </div>

            @endif

        @endforeach

    </div>
</section>

@endsection
