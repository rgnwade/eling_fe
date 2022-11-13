<a href="{{ url('products')}}?category={{$category->slug}}" class="product-card">
    <div class="product-card-inner">
        <div class="product-image clearfix">

            @if (! $category->logo->exists)
            <div class="image-placeholder">
                <i class="fa fa-picture-o" aria-hidden="true"></i>
            </div>
            @else
            <div class="image-holder">
                <img src="{{ $category->logo->thumb }}">
            </div>
            @endif

        </div>

        <div class="product-content clearfix">
            <span class="product-name"> {{ $category->name }}</span>
        </div>
    </div>
</a>