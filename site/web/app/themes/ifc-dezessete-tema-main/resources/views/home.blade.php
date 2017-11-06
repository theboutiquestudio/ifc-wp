@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @php($noticias_loop = new WP_Query(['post_type' => 'noticia', 'post_per_page' => 5]))

  @if (!$noticias_loop->have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @while ($noticias_loop->have_posts()) @php($noticias_loop->the_post())
    @include('partials.content-'.get_post_type())
  @endwhile

  {!! get_the_posts_navigation() !!}
@endsection
