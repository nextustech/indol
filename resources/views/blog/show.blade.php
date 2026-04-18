@extends('layouts.front')

@section('title', $post->meta_title ?: $post->title . ' - Blog - ' . config('app.name'))

@section('meta')
<meta name="description" content="{{ $post->meta_description ?: $post->short_description }}">
<meta name="keywords" content="{{ $post->meta_keywords }}">

@if($post->og_title || $post->og_description || $post->og_image)
<meta property="og:title" content="{{ $post->og_title ?: $post->title }}">
<meta property="og:description" content="{{ $post->og_description ?: $post->short_description }}">
@if($post->og_image)
<meta property="og:image" content="{{ $post->og_image }}">
@elseif($post->featured_image)
<meta property="og:image" content="{{ $post->featured_image }}">
@endif
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:type" content="article">
@endif
@endsection

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-box">
                    <h1 class="text-anime-style-3" data-cursor="-opaque">{{ $post->title }}</h1>
                    <div class="post-single-meta wow fadeInUp">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><i class="fa-regular fa-user"></i> {{ $post->author->name ?? 'Admin' }}</li>
                            <li class="breadcrumb-item"><i class="fa-regular fa-clock"></i> {{ $post->published_at->format('d M, Y') }}</li>
                            <li class="breadcrumb-item"><i class="fa-regular fa-eye"></i> {{ number_format($post->view_count) }} views</li>
                            @if($post->category)
                            <li class="breadcrumb-item"><a href="{{ route('blog.category', $post->category->slug) }}"><i class="fa-regular fa-folder"></i> {{ $post->category->name }}</a></li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Page Single Post Start -->
<div class="page-single-post">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Post Featured Image Start -->
                <div class="post-image">
                    <figure class="image-anime reveal">
                        @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}">
                        @else
                        <img src="{{ url('front/images/post-1.jpg') }}" alt="{{ $post->title }}">
                        @endif
                    </figure>
                </div>
                <!-- Post Featured Image End -->

                <!-- Post Single Content Start -->
                <div class="post-content">
                    <!-- Post Entry Start -->
                    <div class="post-entry">
                        {!! $post->content !!}
                    </div>
                    <!-- Post Entry End -->

                    <!-- Post Tag Links Start -->
                    <div class="post-tag-links">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="post-tags wow fadeInUp" data-wow-delay="0.5s">
                                    @if($post->tags->count())
                                    <span class="tag-links">
                                        Tags:
                                        @foreach($post->tags as $tag)
                                        <a href="{{ route('blog.tag', $tag->slug) }}">{{ $tag->name }}</a>
                                        @endforeach
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="post-social-sharing wow fadeInUp" data-wow-delay="0.5s">
                                    <ul>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ request()->url() }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                                        <li><a href="https://twitter.com/intent/tweet?url={{ request()->url() }}&text={{ urlencode($post->title) }}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
                                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ request()->url() }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ request()->url() }}" target="_blank"><i class="fa-brands fa-whatsapp"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Post Tag Links End -->
                </div>
                <!-- Post Single Content End -->

                <!-- Comments Section Start -->
                @if($post->allow_comments)
                <div class="comments-section mt-5">
                    <div class="post-comments">
                        <h3>Comments ({{ $post->approvedComments->count() }})</h3>

                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Comment Form Start -->
                        <div class="comment-form-box mt-4">
                            <h4>Leave a Comment</h4>
                            <form method="POST" action="{{ route('blog.comment', $post->id) }}" class="comment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="name" placeholder="Your Name *" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" name="email" placeholder="Your Email *" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="comment" placeholder="Your Comment *" rows="4" required class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Comment</button>
                            </form>
                        </div>
                        <!-- Comment Form End -->

                        <!-- Comments List Start -->
                        @if($post->approvedComments->count())
                        <div class="comments-list mt-5">
                            @foreach($post->approvedComments as $comment)
                            <div class="comment-item">
                                <div class="comment-header">
                                    <span class="comment-author">{{ $comment->name }}</span>
                                    <span class="comment-date">{{ $comment->created_at->format('d M, Y') }}</span>
                                </div>
                                <p>{{ $comment->comment }}</p>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <!-- Comments List End -->
                    </div>
                </div>
                @endif
                <!-- Comments Section End -->
            </div>

            <div class="col-lg-4">
                <!-- Sidebar Start -->
                <div class="sidebar">
                    <!-- Categories Box Start -->
                    <div class="sidebar-box wow fadeInUp">
                        <h3>Categories</h3>
                        <ul class="category-list">
                            @forelse(\App\Models\BlogCategory::where('status', 1)->withCount('publishedPosts')->orderBy('name')->get() as $category)
                            <li><a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }} <span class="count">{{ $category->published_posts_count ?? 0 }}</span></a></li>
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
                <!-- Sidebar End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Single Post End -->

@push('styles')
<style>
.post-tag-links {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #eee;
}

.tag-links a {
    background: #f0f0f0;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 14px;
    color: #333;
    text-decoration: none;
    margin-left: 8px;
    transition: all 0.3s ease;
}

.tag-links a:hover {
    background: #007bff;
    color: #fff;
}

.post-social-sharing {
    text-align: right;
}

.post-social-sharing ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.post-social-sharing ul li a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f0f0f0;
    color: #333;
    text-decoration: none;
    transition: all 0.3s ease;
}

.post-social-sharing ul li a:hover {
    background: #007bff;
    color: #fff;
}

.comment-form-box {
    background: #fff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 3px 20px rgba(0,0,0,0.08);
}

.comment-form-box h4 {
    margin-bottom: 20px;
}

.comment-form .form-control {
    margin-bottom: 15px;
    padding: 12px 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
}

.comment-item {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.comment-author {
    font-weight: 600;
    color: #333;
}

.comment-date {
    font-size: 14px;
    color: #888;
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

.category-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li {
    border-bottom: 1px solid #eee;
}

.category-list li:last-child {
    border-bottom: none;
}

.category-list li a {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    color: #333;
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-list li a:hover {
    color: #007bff;
}

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

.recent-post-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.recent-post-image img {
    width: 70px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.recent-post-content h4 {
    font-size: 15px;
    margin-bottom: 5px;
}

.recent-post-content h4 a {
    color: #333;
    text-decoration: none;
}

.recent-post-content .date {
    font-size: 12px;
    color: #888;
}
</style>
@endpush

@endsection