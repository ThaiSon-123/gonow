@include('clients.blocks.header')
@include('clients.blocks.banner')
<!-- Tour Grid Area start -->
<section class="tour-grid-page py-100 rel z-2">
    <div class="container">
        <div class="row">
            @if ($tours->isEmpty())
                <div class="d-flex flex-column align-items-center justify-content-center text-center mt-5 mb-5">
                    <div class="p-4 shadow-sm" 
                        style="max-width:600px; background: #ffffff; border-radius: 20px; border:1px solid #e9ecef;">                        <h5 class="fw-bold text-dark mb-2">
                            <i class="bi bi-search text-success me-2"></i>Không tìm thấy tour phù hợp
                        </h5>
                        <p class="text-muted mb-0">
                            Rất tiếc, chúng tôi không tìm thấy tour nào liên quan đến từ khóa của bạn.<br>
                            Hãy thử tìm kiếm lại với <span class="fw-semibold text-success">từ khóa khác</span> nhé!
                        </p>
                    </div>
                </div>
            @else
                @foreach ($tours as $tour)
                    <div class="col-xl-4 col-md-6" style="margin-bottom: 30px">
                        <div class="destination-item tour-grid style-three bgc-lighter equal-block-fix" data-aos="fade-up"
                            data-aos-duration="1500" data-aos-offset="50">
                            <div class="image">
                                <a href="#" class="heart"><i class="fas fa-heart"></i></a>
                                @if (count($tour->images) > 0)
                                    <img src="{{ asset('admin/assets/images/gallery-tours/' . $tour->images[0]) }}"
                                        alt="Tour List">
                                @else
                                    <img src="{{ asset('clients/assets/images/no-image.jpg') }}" alt="No Image Available">
                                @endif
                            </div>
                            <div class="content equal-content-fix">
                                <div class="destination-header">
                                    <span class="location"><i class="fal fa-map-marker-alt"></i>
                                        {{ $tour->destination }}</span>
                                    <div class="ratting">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($tour->rating && $i < $tour->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <h5><a
                                        href="{{ route('tour-detail', ['id' => $tour->tourId]) }}">{{ $tour->title }}</a>
                                </h5>
                                <ul class="blog-meta">
                                    <li><i class="far fa-clock"></i>{{ $tour->time }}</li>
                                    <li><i class="far fa-user"></i>{{ $tour->quantity }}</li>
                                </ul>
                                <div class="destination-footer">
                                    <span
                                        class="price"><span>{{ number_format($tour->priceAdult, 0, ',', '.') }}</span>
                                        VND / người</span>
                                    <a href="{{ route('tour-detail', ['id' => $tour->tourId]) }}"
                                        class="theme-btn style-two style-three">
                                        <span data-hover="Đặt ngay">Đặt ngay</span>
                                        <i class="fal fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</section>
<!-- Tour Grid Area end -->

@include('clients.blocks.new_letter')
@include('clients.blocks.footer')
