@extends('layouts.front')

@section('title', $category->name . ' - Blog - ' . config('app.name'))

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque">{{ $category->name }}</h1>
                    <nav class="wow fadeInUp">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">blog</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Page Blog Start -->
<div class="page-blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 order-lg-2">
                <div class="sidebar">
                    <!-- Search Box Start -->
                    <div class="sidebar-box search-box wow fadeInUp">
                        <h3>Search</h3>
                        <form method="GET" action="{{ route('blog.index') }}" class="search-form">
                            <div class="form-group">
                                <input type="text" name="search" placeholder="Search posts..." value="{{ request('search') }}" class="form-control">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <!-- Search Box End -->

                    <!-- Categories Box Start -->
                    <div class="sidebar-box wow fadeInUp">
                        <h3>Categories</h3>
                        <ul class="category-list">
                            @forelse($categories as $cat)
                            <li><a href="{{ route('blog.category', $cat->slug) }}">{{ $cat->name }} <span class="count">{{ $cat->published_posts_count ?? 0 }}</span></a></li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                    <!-- Categories Box End -->

                    <!-- Recent Posts Start -->
                    <div class="sidebar-box wow fadeInUp">
                        <h3>Recent Posts</h3>
                        <div class="recent-posts-list">
                            @forelse($recentPosts as $recent)
                            <div class="recent-post-item">
                                @if($recent->featured_image)
                                <div class="recent-post-image">
                                    <a href="{{ route('blog.show', $recent->slug) }}">
                                        <img src="{{ $recent->featured_image }}" alt="{{ $recent->title }}">
                                    </a>
                                </div>
                                @endif
                                <div class="recent-post-content">
                                    <h4><a href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a></h4>
                                    <span class="date"><i class="far fa-calendar"></i> {{ $recent->published_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <!-- Recent Posts End -->
                </div>
            </div>

            <div class="col-lg-8 col-md-12 order-lg-1">
                <div class="row">
                    @forelse($posts as $index => $post)
                    <div class="col-lg-6 col-md-6">
                        <div class="blog-item wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                            <div class="post-featured-image" data-cursor-text="View">
                                <figure>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="image-anime">
                                        @if($post->featured_image)
                                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}">
                                        @else
                                        <img src="{{ url('front/images/post-1.jpg') }}" alt="{{ $post->title }}">
                                        @endif
                                    </a>
                                </figure>
                            </div>
                            <div class="post-item-content">
                                <div class="post-item-body">
                                    <h2><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
                                </div>
                                <div class="post-item-footer">
                                    <span class="post-date"><i class="far fa-calendar"></i> {{ $post->published_at->format('d M Y') }}</span>
                                    <span class="read-time"><i class="far fa-clock"></i> {{ $post->reading_time }} min read</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info">No posts in this category.</div>
                    </div>
                    @endforelse
                </div>

                @if($posts->hasPages())
                <div class="row">
                    <div class="col-md-12">
                        <div class="post-pagination wow fadeInUp" data-wow-delay="0.5s">
                            <ul class="pagination">
                                {{ $posts->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Page Blog End -->

@push('styles')
<style>
.search-form .form-group { position: relative; }
.search-form .form-control { padding-right: 50px; }
.search-form .btn {
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    border-radius: 0 8px 8px 0;
}
.sidebar-box {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 3px 20px rgba(0,0,0,0.08);
}
.sidebar-box h3 {
    font-size: 20px;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 15px;
}
.sidebar-box h3::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 2px;
    background: #007bff;
}
.category-list { list-style: none; padding: 0; margin: 0; }
.category-list li { border-bottom: 1px solid #eee; }
.category-list li:last-child { border-bottom: none; }
.category-list li a {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    color: #333;
    text-decoration: none;
}
.category-list li a:hover { color: #007bff; }
.category-list .count {
    background: #f0f0f0;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 14px;
    color: #666;
}
.recent-post-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}
.recent-post-item:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
.recent-post-image img {
    width: 70px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}
.recent-post-content h4 { font-size: 15px; margin-bottom: 5px; }
.recent-post-content h4 a { color: #333; text-decoration: none; }
.recent-post-content .date { font-size: 12px; color: #888; }
</style>
@endpush

@endsection