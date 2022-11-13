    
    @if(!empty($category))
    <section class="section-wrapper clearfix">
        <div class="section-header">
            <h3>{{$category->name}}</h3>
        </div>

        <div class="recent-products">
            <div class="row">
                <div class="grid-products separator">
                    @each('public.products.partials.category_card', $category->child()->get(), 'category')
                </div>
            </div>
        </div>
    </section>
    @endif

