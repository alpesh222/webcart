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
                        <li><i class="fa fa-money"></i>Price</li>
                        <!--					<li>Customer Rating</li>-->
                        <li>Resolution</li>
                        <li>Screen Type</li>
                        <li>Display Size</li>
                        <li>Refresh Rate</li>
                        <li>Model Year</li>
                        <li>Tuner Technology</li>
                        <li>Ethernet Input</li>
                        <li>USB Input</li>
                        <li>Scart Input</li>
                    </ul>
                </div> <!-- .features -->

                <div class="cd-products-wrapper">
                    <ul class="cd-products-columns">

                        <li class="product">
                            <div class="top-info">
                                <div class="check"></div>
                                <img src="https://images.idgesg.net/images/article/2019/07/aspire5slim-100806682-large.jpg" alt="product image">
                                <h3>Sumsung Series 6 J6300</h3>
                            </div> <!-- .top-info -->

                            <ul class="cd-features-list">
                                <li>$600</li>
                                <!--							<li class="rate"><span>5/5</span></li>-->
                                <li>1080p</li>
                                <li>LED</li>
                                <li>47.6 inches</li>
                                <li>800Hz</li>
                                <li>2015</li>
                                <li>mpeg4</li>
                                <li>1 Side</li>
                                <li>3 Port</li>
                                <li>1 Rear</li>
                            </ul>
                        </li> <!-- .product -->

                        <li class="product">
                            <div class="top-info">
                                <div class="check"></div>
                                <img src="https://images.idgesg.net/images/article/2019/07/aspire5slim-100806682-large.jpg" alt="product image">
                                <h3>Sumsung Series 6 J6300</h3>
                            </div> <!-- .top-info -->

                            <ul class="cd-features-list">
                                <li>$600</li>
                                <!--							<li class="rate"><span>5/5</span></li>-->
                                <li>1080p</li>
                                <li>LED</li>
                                <li>47.6 inches</li>
                                <li>800Hz</li>
                                <li>2015</li>
                                <li>mpeg4</li>
                                <li>1 Side</li>
                                <li>3 Port</li>
                                <li>1 Rear</li>
                            </ul>
                        </li> <!-- .product -->

                        <li class="product">
                            <div class="top-info">
                                <div class="check"></div>
                                <img src="https://images.idgesg.net/images/article/2019/07/aspire5slim-100806682-large.jpg" alt="product image">
                                <h3>Sumsung Series 6 J6300</h3>
                            </div> <!-- .top-info -->

                            <ul class="cd-features-list">
                                <li>$600</li>
                                <!--							<li class="rate"><span>5/5</span></li>-->
                                <li>1080p</li>
                                <li>LED</li>
                                <li>47.6 inches</li>
                                <li>800Hz</li>
                                <li>2015</li>
                                <li>mpeg4</li>
                                <li>1 Side</li>
                                <li>3 Port</li>
                                <li>1 Rear</li>
                            </ul>
                        </li> <!-- .product -->
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