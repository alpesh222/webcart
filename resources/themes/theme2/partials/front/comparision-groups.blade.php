@if( !empty( $comparision_group_types ) && count( $comparision_products ) > 1)
    @php
        $comparision_types = !empty($comparision_group_types->comparision_groups) ? unserialize($comparision_group_types->comparision_groups) : array();
    @endphp
    @if( count($comparision_types) > 0 )
        <div class="clearfix">  </div>

        <div class=" related-products col-md-12">
            <h3 class="text-primary"> <span> @lang('Compare with similar items :') </span></h3>
        </div>

        <section class="cd-products-comparison-table">
            <header>
                <div class="actions">
                    <a href="#0" class="reset">Reset</a>
                    <a href="#0" class="filter">Filter</a>
                </div>
            </header>

            <div class="cd-products-table">
                <div class="features">
                    <div class="top-info">Models</div>
                    <ul class="cd-features-list">
                        @foreach($comparision_types as $item)
                            @php
                                $comp_type_icon  = \App\ComparisionGroup::getPhotoNameById($item['photo_id']);
                                $comp_type_name  = \App\ComparisionGroup::getSpecificationTypeById($item['comp_type']);
                            @endphp
                            <li><img src="{{ asset('img/'.$comp_type_icon) }}" class="custom_comp_icon" width="25" alt="<?=$comp_type_icon?>"> <?=$comp_type_name?> </li>
                        @endforeach
                        <!--					<li>Customer Rating</li>-->
{{--                        <li>Resolution</li>--}}
{{--                        <li>Screen Type</li>--}}
{{--                        <li>Display Size</li>--}}
{{--                        <li>Refresh Rate</li>--}}
{{--                        <li>Model Year</li>--}}
{{--                        <li>Tuner Technology</li>--}}
{{--                        <li>Ethernet Input</li>--}}
{{--                        <li>USB Input</li>--}}
{{--                        <li>Scart Input</li>--}}
                    </ul>
                </div> <!-- .features -->

                <div class="cd-products-wrapper">
                    <ul class="cd-products-columns">
                        @foreach($comparision_products as $product)
                            <li class="product">
                                <div class="top-info">
                                    <div class="check"></div>
                                    @if($product->photo)
                                        @php
                                            $image_url = \App\Helpers\Helper::check_image_avatar($product->photo->name, 500);
                                        @endphp
                                        <img src="{{$image_url}}" class="img-responsive" alt="{{$product->name}}" />
                                    @else
                                        <img src="https://via.placeholder.com/500x500?text=No+Image" class="img-responsive" alt="{{$product->name}}" />
                                    @endif
                                    <h3>{{ $product->name }}</h3>
                                </div> <!-- .top-info -->

                                <ul class="cd-features-list">
                                    @foreach($comparision_types as $item)
                                        @if(count($product->specificationTypes) > 0 )
                                            @foreach( $product->specificationTypes as $specification )
                                                    @php $specification_type = 'N/a'; @endphp
                                                    @if($specification->id == $item['comp_type'])
                                                        @php
                                                            $spec_value = !empty($specification->pivot->value) ? $specification->pivot->value : '' ;
                                                            $spec_unit  = !empty($specification->pivot->unit) ? $specification->pivot->unit : '' ;
                                                            $specification_type =  $spec_value.' '. $spec_unit;
                                                            $specification_type = !empty($specification_type) ? $specification_type : 'N/a';
                                                            break;
                                                        @endphp
                                                    @endif
                                            @endforeach
                                                <li> {{ $specification_type }} </li>
                                        @else
                                            <li>@lang('N/a')</li>
                                        @endif
                                    @endforeach
{{--                                    <li>$600</li>--}}
                                    <!--							<li class="rate"><span>5/5</span></li>-->
{{--                                    <li>1080p</li>--}}
{{--                                    <li>LED</li>--}}
{{--                                    <li>47.6 inches</li>--}}
{{--                                    <li>800Hz</li>--}}
{{--                                    <li>2015</li>--}}
{{--                                    <li>mpeg4</li>--}}
{{--                                    <li>1 Side</li>--}}
{{--                                    <li>3 Port</li>--}}
{{--                                    <li>1 Rear</li>--}}
                                </ul>
                            </li> <!-- .product -->
                        @endforeach
                    </ul> <!-- .cd-products-columns -->
                </div> <!-- .cd-products-wrapper -->

                <!--			<ul class="cd-table-navigation">-->
                <!--				<li><a href="#0" class="prev inactive">Prev</a></li>-->
                <!--				<li><a href="#0" class="next">Next</a></li>-->
                <!--			</ul>-->
            </div> <!-- .cd-products-table -->
        </section> <!-- .cd-products-comparison-table -->

    @endif
@endif